<?php
/**
 * UserFrosting OAuth2-server (https://github.com/Ekwav/UF_OAUTH2-SERVER)
 *
 * @link      https://github.com/Ekwav/UF_OAUTH2-SERVER
 * @copyright Copyright (c) 2017 Ekwav (Coflnet)
 * @license   -ask me if you want to distribute my code, only thing that you are not allowed to chang is the Powered by Coflnet :)
 */
namespace UserFrosting\Sprinkle\OAuth2Server\Controller;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use UserFrosting\Sprinkle\OAuth2Server\OAuth2\RefreshTokenRepository;
use UserFrosting\Sprinkle\OAuth2Server\OAuth2\UserRepository;
use UserFrosting\Sprinkle\OAuth2Server\OAuth2\UserEntity;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\OAuth2Server\Database\Models\Scopes;
use UserFrosting\Sprinkle\OAuth2Server\Database\Models\OauthClients;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\OAuth2Server\Sprunje\ClientSprunje;

class ApiAuthController extends SimpleController
{

    public function finish_authorize($request, $response, $args)
    {
		$server = $this->ci->OAuth2;
		try {
			 $authRequest = $_SESSION["auth_request"];
		// Return the HTTP redirect response
        return $server->completeAuthorizationRequest($authRequest, $response);
		}
		catch (OAuthServerException $exception) {
			return $exception->generateHttpResponse($response);
		} catch (\Exception $exception) {
			// Catch unexpected exceptions
			$body = $response->getBody();
			$body->write($exception->getMessage());
			return $response->withStatus(500)->withBody($body);
		}
	}


	public function authorizePage($request, $response, $args)
	{

		$throttler = $this->ci->throttler;
		$view = $this->ci->view;
		$session = $this->ci->session;
		$t = $this->ci->translator;


		//before starting, test against bruteforce:
		$throttleData = [
			'id' => $this->ci->currentUser->id
		];

		$delay = $throttler->getDelay('oauth2_authorize_request', $throttleData);

		if ($delay > 0) {
			$ms->addMessageTranslated("danger", "RATE_LIMIT_EXCEEDED", [
				"delay" => $delay
			]);
			return $response->withStatus(429);
		}

		// detect, if we have a cool route or not
		if($args['client_id']) {
			$client_id = $args['client_id'];
			// The League/oauth2-server package doesn't support arguments so we wil make a new Query
			$request = $request->withQueryParams($args);
		}
		elseif($request->getQueryParams()['client_id']) {
			$client_id = $request->getQueryParams()['client_id'];
		}
		else {
			// Display an error page
			$message = $t->translate("OAUTH2.ERROR.NO_CLIENT");
			return $view->render($response, 'pages/error/oauth2.html.twig', ['message' => $message]);
		}

		$this->ci->session['CLIENT'] = OauthClients::where('public_id', '=' , $client_id)->first();

		if($this->ci->session['CLIENT'] == null)
		{
			$throttler->logEvent('oauth2_authorize_request', $throttleData);
			$message = $t->translate("OAUTH2.ERROR.APP_NOT_EXISTS");
			return $view->render($response, 'pages/error/oauth2.html.twig', ['message' => $message]);
		}

		$this->ci->session['auth_type'] = $request->getQueryParams()['response_type'];


		//get the scopes from url we will also make sure that there in only one white space
		$requestedScopes = explode(" " ,trim(preg_replace('/\s\s+/', ' ', $request->getQueryParams()['scope'])));

		//for some reason this line is needed, I don't know why
		$this->requested = $requestedScopes;
		$this->scopes = Scopes::whereIn('slug', $requestedScopes)->get()->toArray();


		// Loop true the name and description to translate them
		foreach($this->scopes as $key => $scope)
		{
			$scopes[$key]["name"] = $t->translate($this->scopes[$key]["name"]);
			$scopes[$key]["description"] = $t->translate($this->scopes[$key]["description"]);
			$scopes[$key]["slug"] = $this->scopes[$key]["slug"];
		}

		// Loop all requested scopes to see, if their are activated by the app owner
		// If they are unactivated scopes and it is the app owner we will display him a hint
		foreach($this->requested as $key => $requested_scopes)
		{
			if(!in_array($requested_scopes, json_decode($_SESSION["CLIENT"]["active_scopes"])))
			{
				if($session['CLIENT.user_id']==$this->ci->currentUser->id)
				{
					$message = $t->translate("OAUTH2.ERROR.DISABLED_SCOPE");
					return $view->render($response, 'pages/error/oauth2.html.twig', ['message' => $message]);
				}
				else
				{
					$message = $t->translate("OAUTH2.ERROR.DISABLED_SCOPE_PUBLIC");
					return $view->render($response, 'pages/error/oauth2.html.twig', [
					'message' => $message,
					'redirect' => $session['CLIENT.redirect']]);
				}
			}
		}

		// Ok, looks like everything is fine with these scopes so we will save them in the session.
		$session['scopes'] = $scopes;

        // The oauth2 flow implements a session, throughout the user validation this woudl get lost
        // so we store it in the session to send it back when we are done.
        $session['state'] = $request->getQueryParams()['state'];

		// nothing went wrong yet? Let's create the actuall OAuth2 object request and store it in the Session
		$session['auth_request'] = $this->ci->OAuth2->validateAuthorizationRequest($request);

		// Now we only need the approval from the user
		return $view->render($response, 'pages/oauth2_review_details.html.twig', [
			'scopes' => $scopes,
			'app' => $session['CLIENT']]);
		}


	public function validateAuthRequest($request, $response, $args)
	{
		// The user submited the form, now we can tell the authorization middleware what user it is.
		$this->ci->session['auth_request']->setUser(new UserEntity($this->ci->currentUser->id));

		// Select an option based on what the user choose
		if(isset($_POST['AUTHORIZE']))
		{
			$this->ci->session['auth_request']->setAuthorizationApproved(true);
		}
		elseif(isset($_POST['EDIT']))
		{
			//The user wants to change something, show him the edit page
			$scopes = $this->ci->session['scopes'];
			return $this->ci->view->render($response, 'pages/oauth2_change_details.html.twig', [
			'scopes' => $scopes,
			'type' => $this->ci->session['auth_type'],
			'app' => $this->ci->session['CLIENT']]);
		}
		else
		{
			$this->ci->session['auth_request']->setAuthorizationApproved(false);
		}


		$params = $request->getParsedBody();

		// Build the redirect route to finish the authorization Grant, it only accepts GET :/
		// I belive that it is a security hole like I reported here: https://github.com/thephpleague/oauth2-server/issues/730
		$route = $this->ci->config['site.uri.public'] . "/finish_authorize?response_type=" . $params['response_type'] .
        $route .= "&scope=" . $params['scope'];
        $route .= "&client_id=" . $params['client_id'];
        $route .= "&state=" . $session['state'];

		return $response->withRedirect($route);
	}


  // This is an example Controller how to get user information with a token
	public function getUserInfo($request, $response, $args)
	{
        // First of all we get the user id and the scopes
		$scopes = $request->getAttribute('oauth_scopes', []);
		$user_id = $request->getAttribute('oauth_user_id', []);

        // Now we will query the database with the user id
		$user = User::where('id',  $user_id)->first();

        // No matter what specified by the user we will always return his id.
		$information["user_id"] = $user_id;

        // If the user activated basic, we return user_name and his locale
		if (in_array('basic', $scopes)) {
    		$information["user_name"] = $user->user_name;
    		$information["locale"] = $user->locale;
		}
		if (in_array('email', $scopes)) {
    		$information["email"] = $user->email;
		}
        // If the user granted full_access, we return everything we have
        // or want, we shouldn't give out the password even if its encrypted.
        if (in_array('full_access', $scopes)){
    		$information["user_name"] = $user->user_name;
    		$information["locale"] = $user->locale;
            $information["email"] = $user->email;
		}
		return $response->withJson($information);
	}


    public function AccessToken($request, $response, $args)
    {
        $client_id = $request->getParsedBody()['client_id'];
        $this->ci->session['CLIENT'] = OauthClients::where('public_id', '=' , $client_id)->first();
        $server = $this->ci->OAuth2;
        try {
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response->withStatus(500);
        }
    }


	public function renderClients($request, $response, $args)
	{
		$apps = OauthClients::where('user_id', '=' , $this->ci->currentUser->id)->get()->toArray();
		return $this->ci->view->render($response, 'pages/oauth2_list_apps.html.twig', ['Apps' => $apps]);
	}


	public function getModalCreateClient($request, $response, $args)
	{
		$schema = new RequestSchema('schema://requests/new_oauth_client.json');
		$validator = new JqueryValidationAdapter($schema, $this->ci->translator);
		$rules = $validator->rules('json', false);
		$apps = OauthClients::where('user_id', '=' , $this->ci->currentUser->id)->get()->toArray();
		return $this->ci->view->render($response, 'modals/oauth2/create_client.html.twig', [
		'Apps' => $apps,
		'page' => [
			'validators' =>  $rules
		]]);
	}

    public function getClients($request, $response, $args)
	{
        // GET parameters
        $params = $request->getQueryParams();

        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;

        $sprunje = new ClientSprunje($classMapper, $params);

        $sprunje->extendQuery(function ($query) {
            return $query->where('user_id',$this->ci->currentUser->id);
        });

        return $sprunje->toResponse($response);
    }

	public function addNewClient($request, $response, $args)
	{
		$params = $request->getParsedBody();

		// Load the request schema
		$schema = new RequestSchema('schema://requests/new_oauth_client.json');

		// Whitelist and set parameter defaults
		$transformer = new RequestDataTransformer($schema);
		$data = $transformer->transform($params);

		$ms = $this->ci->alerts;

		$validator = new ServerSideValidator($schema, $this->ci->translator);


		if (!$validator->validate($data)) {
			$ms->addValidationErrors($validator);
			return $response->withStatus(400);
		}

		// Generate a secret and an public_id
		// Since mt_rand will most likely only generate up to nine didgets numbers we will call it twice
		$this->secret = bin2hex(random_bytes(50));

		$this->public_id = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
		if(OauthClients::where('public_id', '=' , $this->public_id)->first())
		{
			while(OauthClients::where('public_id', '=' , $this->public_id)->first() != null)
			{
				$this->public_id = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
			}
		}


		// Active scopes will get their own database - eventually
		// Please let me know in the issues if you think it is a good idea or not
		// Currently you can't edit your scopes in the dashboard or when you add them, but you can do that here or in the db.
		// It is very likely that you don't even need to.
		$active_scopes = ["basic", "email", "full_name", "full_access"];

		$this->newClient = new OauthClients([
				"user_id" => $this->ci->currentUser->id,
				"name" => $data["name"],
				"secret" => $this->secret,
				"redirect" => $data["redirect"],
				"personal_access_client" => '0',
				"password_client" => '0',
				"revoked" => '0',
				"description" => $data["description"],
				"active_scopes" => json_encode($active_scopes),
				"public_id" => $this->public_id,
				"icon_url" => $data["icon"],
				]);
		$this->newClient->save();

        return $response->withStatus(204);
	}

}

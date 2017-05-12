<?php

namespace UserFrosting\Sprinkle\Api\ServicesProvider;

use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\ImplicitGrant;
use UserFrosting\Sprinkle\Api\OAuth2\UserEntity;
use UserFrosting\Sprinkle\Api\OAuth2\AccessTokenRepository;
use UserFrosting\Sprinkle\Api\OAuth2\ClientRepository;
use UserFrosting\Sprinkle\Api\OAuth2\ScopeRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use UserFrosting\Sprinkle\Api\OAuth2\RefreshTokenRepository;
use UserFrosting\Sprinkle\Api\OAuth2\UserRepository;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use UserFrosting\Sprinkle\Api\OAuth2\AuthCodeRepository;
use League\OAuth2\Server\ResourceServer;
use UserFrosting\Sprinkle\Api\Model\OauthClients;
use UserFrosting\Sprinkle\Api\Model\Scopes;

class ServicesProvider
{
    public function register($container)
    {
		$container['OAuth2'] = function ($c) {
			$all_scopes = Scopes::where('created_at', '>', 2)->get()->toArray();
		 
			// Init our repositories
			$clientRepository = new ClientRepository($_SESSION["CLIENT"]);
			$scopeRepository = new ScopeRepository($all_scopes);
			$accessTokenRepository = new AccessTokenRepository();
			$authCodeRepository = new AuthCodeRepository();
			$refreshTokenRepository = new RefreshTokenRepository();
			$privateKeyPath = 'file://' . __DIR__ . '/../OAuth2/private.key';
			$publicKeyPath = 'file://' . __DIR__ . '/../OAuth2/public.key';
			
			// Setup the authorization server
			$OAuth2 = new AuthorizationServer(
				$clientRepository,
				$accessTokenRepository,
				$scopeRepository,
				$privateKeyPath,
				$publicKeyPath
			);
			
			
			// Enable the implicit grant on the server with a token TTL of 1 hour
			// You can change P1W to P3 months to allow access tokens that last three months
			// With this grant type you don't have to deal with anything else. It is the easiest to get startet.
			// Read more on the league/oauth2 documentation: https://oauth2.thephpleague.com/authorization-server/implicit-grant/
			$OAuth2->enableGrantType(
				new ImplicitGrant(new \DateInterval('P1W')),
				new \DateInterval('P1W') // access tokens will expire after 1 hour
			); 
			
			
			// This is the AuthCode Grant server, it is recomended if you want to validate the App because your Server will 
			// only issue an autorisation code that has to be sent with the client secret to get an access token. 
			// Read more on league/oauth2 docs: https://oauth2.thephpleague.com/authorization-server/auth-code-grant/
			// authorization codes will expire after 10 minutes
			$grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
				$authCodeRepository,
				$refreshTokenRepository,
				new \DateInterval('PT10M') 
			);

			$grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

			// Enable the authentication code grant on the server
			$OAuth2->enableGrantType(
				$grant,
				new \DateInterval('PT6H') // access tokens will expire after 6 hours
			);
			return $OAuth2; 
		};
		
		
		// Create the ResourceServer Service, you can call this on your route to protect access
		$container['ResourceServer'] = function ($c) {
			$publicKeyPath = 'file://' . __DIR__ . '/../OAuth2/public.key';
			$server = new ResourceServer(
				new AccessTokenRepository(),
				$publicKeyPath
			);
			return $server; 
		}; 
	}
}
<?php
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;


$app->get('/authorize/{client_id}/{response_type}/{scope}', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->get('/oauth', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->get('/finish_authorize', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:finish_authorize')->add('authGuard');



//$app->get('/oauth2/change', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:oAuth2ChangeRequest');
$app->get('/apps', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:renderClients')->add('authGuard');
$app->get('/app/new', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:renderAddNewClient')->add('authGuard');
//$app->get('/app/new/scope', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:newScope');

$app->post('/authorize_vertify', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:validateAuthRequest')->add('authGuard');
$app->post('/app/new', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:addNewClient')->add('authGuard');

// This is a test api endpoint to try it :)
// IMPORTANT! YOU NEED TO ADD ALL YOUR API ENDPOINTS TO THE CSRF.BLACKLIST IN YOUR config file
// OTHERWISE THE CSRF MIDDLEWARE WILL BLOCK THEM! You can find an example in the README
$app->post('/api/userinfo', 'UserFrosting\Sprinkle\OAuth2Server\Controller\ApiAuthController:getUserInfo')->add(new ResourceServerMiddleware($this->ci->ResourceServer));

?>

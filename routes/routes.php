<?php
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;


$app->get('/authorize/{client_id}/{response_type}/{scope}', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->get('/oauth', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->get('/finish_authorize', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:finish_authorize')->add('authGuard');


//$app->get('/oauth2/change', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:oAuth2ChangeRequest');
$app->get('/apps', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:renderClients')->add('authGuard');
$app->get('/app/new', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:renderAddNewClient')->add('authGuard');
$app->get('/app/new/scope', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:newScope');

$app->post('/authorize_vertify', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:validateAuthRequest')->add('authGuard');
$app->post('/app/new', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:addNewClient')->add('authGuard');

// This is a test api endpoint to try it :)
// IMPORTANT! YOU NEED TO ADD ALL YOUR API ENDPOINTS TO THE EXECLUTION LIST OF CSRF IN YOUR INDEX.PHP 
// OTHERWISE THE CSRF MIDDLEWARE WILL BLOCK THEM! You can find an example in the README
$app->post('/api/userinfo', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:getUserInfo')->add(new ResourceServerMiddleware($this->ci->ResourceServer));

?>
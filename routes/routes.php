<?php
use League\OAuth2\Server\Middleware\AuthorizationServerMiddleware;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;


$app->get('/authorize/{client_id}/{response_type}/{scope}', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->get('/oauth', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:authorizePage')->add('authGuard');
$app->post('/authorize_vertify', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:validateAuthRequest');
$app->get('/finish_authorize', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:finish_authorize');

$app->get('/oauth2/change', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:oAuth2ChangeRequest');
$app->get('/app/new', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:addNewClient');


$app->get('/app/new/scope', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:newScope');
$app->post('/api/test', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:test')->add(new ResourceServerMiddleware($this->ci->ResourceServer));

$app->post('/api/nutzer', 'UserFrosting\Sprinkle\Api\Controller\ApiAuthController:nutzer')->add(new ResourceServerMiddleware($this->ci->ResourceServer));

//$app->post('/authorize', function () {
//})->add(new AuthorizationServerMiddleware($this->ci->OAuth2));
//$app->get('/auth/{appid}/{secret}', ''}; pageIndex
// add(new ResourceServerMiddleware($app->getContainer()->get(ResourceServer::class)));

?>
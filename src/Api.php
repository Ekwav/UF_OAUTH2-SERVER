<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\Api;

use UserFrosting\Sprinkle\Api\ServicesProvider\ServicesProvider;
use UserFrosting\Sprinkle\Core\Initialize\Sprinkle;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Grant\ImplicitGrant;
use OAuth2\Server\Entities\UserEntity;
use OAuth2\Server\Repositories\AccessTokenRepository;
use OAuth2\Server\Repositories\ClientRepository;
use OAuth2\Server\Repositories\ScopeRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Api extends Sprinkle
{
   
     //* Register OAuth2 services.
     
    public function init()
    {
		$serviceProvider = new ServicesProvider();
        $serviceProvider->register($this->ci);
		
    }
}

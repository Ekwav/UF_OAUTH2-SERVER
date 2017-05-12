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
//use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use UserFrosting\Sprinkle\Api\OAuth2\AuthCodeRepository;
use League\OAuth2\Server\ResourceServer;

use UserFrosting\Sprinkle\Api\Model\OauthClients;
use UserFrosting\Sprinkle\Api\Model\Scopes;

use UserFrosting\Sprinkle\Core\Facades\Debug;
class ServicesProvider
{
    public function register($container)
    {
		$container['OAuth2'] = function ($c) {
		 
		 
			// Init our repositories
			$clientRepository = new ClientRepository($_SESSION["CLIENT"]);
			$scopeRepository = new ScopeRepository(Scopes::where('created_at', '>', 2)->get()->toArray());
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
			$OAuth2->enableGrantType(
				new ImplicitGrant(new \DateInterval('P2W')),
				new \DateInterval('P2W') // access tokens will expire after 1 hour
			); 
			
			$grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
				$authCodeRepository,
				$refreshTokenRepository,
				new \DateInterval('PT10M') // authorization codes will expire after 10 minutes
			);

			$grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

			// Enable the authentication code grant on the server
			$OAuth2->enableGrantType(
				$grant,
				new \DateInterval('PT6H') // access tokens will expire after 1 hour
			);
	/*	$grant = new PasswordGrant(
            new UserRepository(),           // instance of UserRepositoryInterface
            new RefreshTokenRepository()    // instance of RefreshTokenRepositoryInterface
        );
        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month
        // Enable the password grant on the server with a token TTL of 1 hour
        $OAuth2->enableGrantType(
            $grant,
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        ); 
		*/
			return $OAuth2; 
		};
		
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
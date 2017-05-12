<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace UserFrosting\Sprinkle\Api\OAuth2;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use UserFrosting\Sprinkle\Api\OAuth2\ScopeEntity;
use UserFrosting\Sprinkle\Core\Facades\Debug;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
	 public function __construct($scope)
	 {
		 $scopes = array();
		 foreach($scope as $key => $value)
		 {
			 $scopes[$scope[$key]['slug']] = $scope[$key]['slug'];
		 }
		 array_flip($scopes);
	 }
	 
	 
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $scope = new ScopeEntity();
        $scope->setIdentifier($scopeIdentifier);

        return $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        // Example of programatically modifying the final scope of the access token
        if ((int) $userIdentifier === 1) {
            $scope = new ScopeEntity();
            $scope->setIdentifier('email');
            $scopes[] = $scope;
        }

        return $scopes;
    }
}
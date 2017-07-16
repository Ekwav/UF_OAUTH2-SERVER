<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */
namespace UserFrosting\Sprinkle\OAuth2Server\OAuth2;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use UserFrosting\Sprinkle\OAuth2Server\OAuth2\AccessTokenEntity;
use UserFrosting\Sprinkle\Core\Facades\Debug;
class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        // Some logic here to save the access token to a database
		//Debug::debug(implode($accessTokenEntity));
    }
    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        // Some logic here to revoke the access token
    }
    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return false; // Access token hasn't been revoked
    }
    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);
        return $accessToken;
    }
}

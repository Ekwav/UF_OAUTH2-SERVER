<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */
namespace UserFrosting\Sprinkle\Api\OAuth2;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use UserFrosting\Sprinkle\Api\OAuth2\ClientEntity;
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */

	 public function __construct($clients)
	 {
		 $this->clients = $clients;
	 }
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $clients = [
            $this->clients->public_id => [
                'secret'          => $this->clients->secret,// we normally don't need this, because the user will vertify himself
                'name'            => $this->clients->name,
                'redirect_uri'    => $this->clients->redirect,
                'is_confidential' => true,
            ],
        ];
        // Check if client is registered
        if (array_key_exists($clientIdentifier, $clients) === false) {
            return;
        }
        if (
            $mustValidateSecret === true
            && $clients[$clientIdentifier]['is_confidential'] === true
            && password_verify($clientSecret, $clients[$clientIdentifier]['secret']) === false
        ) {
            return;
        }
        $client = new ClientEntity();
        $client->setIdentifier($clientIdentifier);
        $client->setName($clients[$clientIdentifier]['name']);
        $client->setRedirectUri($clients[$clientIdentifier]['redirect_uri']);
        return $client;
    }
}

<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */
namespace UserFrosting\Sprinkle\OAuth2Server\OAuth2;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use UserFrosting\Sprinkle\OAuth2Server\OAuth2\ClientEntity;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */

	 public function __construct()
	 {
		 $this->clients = $_SESSION["CLIENT"];
	 }
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $clients = [
            $this->clients->public_id => [
                'secret'          => $this->clients->secret,
                'name'            => $this->clients->name,
                'redirect_uri'    => $this->clients->redirect,
                'is_confidential' => true,
            ],
        ];
        //$this->clients->secret = password_hash()

        // Check if client is registered
        if (array_key_exists($clientIdentifier, $clients) === false) {
            return;
        }

        if (
            $mustValidateSecret === true
            && $clients[$clientIdentifier]['is_confidential'] === true
            && $clientSecret !== $this->clients->secret
        ) {
            return;
        }

        $client = new ClientEntity();
        $client->setIdentifier($clientIdentifier);
        $client->setName($this->clients->name);
        $client->setRedirectUri($this->clients->redirect);;
        return $client;
    }
}

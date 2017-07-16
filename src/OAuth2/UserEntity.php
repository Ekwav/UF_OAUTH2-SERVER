<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */
namespace UserFrosting\Sprinkle\OAuth2Server\OAuth2;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Interop\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Log\UserActivityDatabaseHandler;
use UserFrosting\Sprinkle\Account\Log\UserActivityProcessor;
use UserFrosting\Sprinkle\Account\Model\User;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Account\Twig\AccountExtension;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Log\MixedFormatter;
use UserFrosting\Sprinkle\Core\Util\ClassMapper;
use UserFrosting\Session\Session;

class UserEntity implements UserEntityInterface
{
    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
	//protected $authenticator;

    /**
     * Constructor.
     *
     * @param ContainerInterface $ci The global container object, which holds all your services.
     */
    public function __construct($userID)
    {
		    $this->userID = $userID;
    }

    public function getIdentifier()
    {
		    return $this->userID;
    }
}

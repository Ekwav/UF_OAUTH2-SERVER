<?php

    /**
     * Sample site configuration file for UserFrosting.  You should definitely set these values!
     *
     */
    return [
        'csrf' => [
            // A list of url paths to ignore CSRF checks on
            // URL paths will be matched against each regular expression in this list.
            // Each regular expression should map to an array of methods.
            // Regular expressions will be delimited with ~ in preg_match, so if you
            // have routes with ~ in them, you must escape this character in your regex.
            // Also, remember to use ^ when you only want to match the beginning of a URL path!
            // See the docs https://learn.userfrosting.com/routes-and-controllers/client-input/csrf-guard#BlacklistingRoutes
            'blacklist' =>  [
              'api/userinfo' => [
                'POST'
              ]
            ]
          ],
          'oauth2server' => [

            // IMPORTANT change this value!
            // You can copy-past this into your comandline to get a key:
            // php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'
            'EncryptionKey' => '4XrWDreG9k2C7G0RLv/kyETd24kHT376bgGqhWk6fr4=',
            // Auth Codes exparations time, 10 min
            'auth_code_time' => 'PT10M',
            // Refresh token exparations time, 3 months
            // If a user didn't open your application for this amount of time, he has to authorize your app again.
            'refresh_token_time' => 'P3M',
            // Access token exparations time, 6 hours
            'access_token_time' => 'PT6H',
            // Note: if a token isn't used within the time defined above it isn't usable anymore, for security purposes.

            // If you generated a public and privat key somewhere else change this values.
            'public_key_path' => '',
            'private_key_path' => ''
          ],
          'throttles' => [
            'guess_secret_attempt' => [
                'method'   => 'ip',
                'interval' => 3600,
                'delays' => [
                    2 => 5,
                    3 => 10,
                    4 => 20,
                    5 => 40,
                    6 => 80,
                    7 => 600
                ]
            ],
            'register_new_app_default' => [
                'method'   => 'data', //app id
                'interval' => 172800,
                'delays' => [
                    1 => 3600,
                    2 => 7200,	//2h
                    3 => 21600, //6h
                    4 => 43200, //12 hours
                    5 => 86400, //one day
                    6 => 172800, //two days
                ]
            ],
              'login_from_outside_default' => [
                'method'   => 'data', //app id
                'interval' => 7200,
                'delays' => [
                  10 => 60,
                  100 => 600,
                  500 => 3600,
                  1000 => 21600,
                ]
            ],
            'login_from_outside_trusted' => [
                'method'   => 'data', //app id
                'interval' => 7200,
                'delays' => [
                  100 => 60,
                  1000 => 600,
                  5000 => 3600,
                  1000 => 21600,
                ]
            ],
			'oauth2_authorize_request' => [
                'method'   => 'data', //user id
                'interval' => 7200,
                'delays' => [
                  10 => 60,
                  20 => 300,
                  50 => 3600,
                  100 => 21600,
                ]
            ],
        ],
    ];

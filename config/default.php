<?php

    /**
     * Sample site configuration file for UserFrosting.  You should definitely set these values!
     *
     */
    return [   
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

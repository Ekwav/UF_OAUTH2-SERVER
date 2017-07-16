<?php
return array(
	"OAUTH2" => [
		"@TRANSLATION" => "OAuth2",
		"PROCESS" => [
			"DENY" => "Deny",
			"EDIT" => "Edit",
			"AUTHORIZE" => "Authorize",
			"INFORMATION" => "The App <b>{{app}}</b> gets access to:",
			"ALLOWED" => "Allowed",
			"DENIED" => "Denied"
		],

		"PERMISSION" => "Permission",


		"ERROR" => [
			"@TRANSLATION" => "Something went wrong.",
			"TITLE" => "Authetificationerror",
			"DISABLED_SCOPE" => "You requested an unactivated scope, if you need it, enable it in the app settings.",
			"APP_NOT_EXISTS" => "The requested app could not be found, please check the 'client_id'.",
			"DISABLED_SCOPE_PUBLIC" => "The App doesn't need access to one or more of the requested spermissions. We reported this request to the app owner",
			"NO_CLIENT" => "No AppID. Please provide us with a 'client_id'.",
			"REDIRECT" => "Klick <a href='{{redirect}}'>here</a> to get back to the App."
		],

		"SCOPE" => [
			"EMAIL" => [
				"@TRANSLATION" => "E-mail",
				"DESCRIPTION" => "The E-mail of your account."
			],
			"NAME" => [
				"@TRANSLATION" => "Name",
				"DESCRIPTION" => "Your full name."
			],
			"USERNAME" => [
				"@TRANSLATION" => "Username",
				"DESCRIPTION" => "Your choosen username"
			],
			"ID" => [
				"@TRANSLATION" => "userID",
				"DESCRIPTION" => "The userID of your account."
			],
			"CLOUD_SAVE" => [
				"@TRANSLATION" => "CloudSave",
				"DESCRIPTION" => "Gives the app the permission to save data for you on our server."
			],
			"BASIC" => [
				"@TRANSLATION" => "Basic",
				"DESCRIPTION" => "Gives acces to your userID, username and CloudSave."
			],
			"FULL_ACCESS" => [
				"@TRANSLATION" => "FULL ACCESS",
				"DESCRIPTION" => "This Application will get access to EVERYTHING you have access to. Be careful to who you grant this permission!"
			],
			"USER_ID" => [
				"@TRANSLATION" => "UserID",
				"DESCRIPTION" => "This id is assigned to your account and can be used to validate your identity. You need atleast this permission to authorize an app. This Number holds none of your personal information!"
			]
		],
		"CLIENT" => [
			"NEW" => [
				"@TRANSLATION" => "New App",
				"DESCRIPTION" => "Here you can add a new app."
			],
			"ICON" => [
				"@TRANSLATION" => "Productlogo-URL",
				"EXAMPLE" => "https://example.com/mylogo.png",
				"HELP" => "This pciture is displayed on the authorisation page."
			],
			"REDIRECT_URI" => [
				"@TRANSLATION" => "Redirect-URI",
				"EXAMPLE" => "https://example.com/oauth2callback",
				"HELP" => "After accepting the permissions, the user is redirected to this link."
			],
			"DESCRIPTION" => [
				"@TRANSLATION" => "Product description",
				"EXAMPLE" => "This App is about ... ",
				"HELP" => "This will be displayed to the user when he wants more information about your app."
			],
			"NAME" => [
				"@TRANSLATION" => "Product name",
				"EXAMPLE" => "The best App in the world",
				"HELP" => "This is the displayed name of your app. It is shown on the authorisation page for example."
			]
		]
	]
);

?>

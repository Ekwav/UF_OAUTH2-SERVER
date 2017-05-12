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
			]
		]
	]
);

?>
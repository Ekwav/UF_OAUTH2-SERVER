<?php
return array(
	"OAUTH2" => [
		"@TRANSLATION" => "OAuth2",
		"PROCESS" => [
			"DENY" => "Abbrechen",
			"EDIT" => "Bearbeiten",
			"AUTHORIZE" => "Authorisieren",
			"INFORMATION" => "Die App <b>{{app}}</b> erh&aumllt Zugriff auf:",
			"ALLOWED" => "Erlaubt",
			"DENIED" => "Verweigert"
		],
		
		"PERMISSION" => "Berechtigung",
		
		
		"ERROR" => [
			"@TRANSLATION" => "Im Autentificationsprozess ist etwas schief gelaufen.",
			"TITLE" => "Authetificationsfehler",
			"DISABLED_SCOPE" => "Du hast eine nicht Aktivierte/existierende Berechtigung angefordert, falls du diese Berechtigung brauchst, aktiviere sie in den App-Einstellungen",
			"APP_NOT_EXISTS" => "Die von dir angefragte App existiert nicht, bitte überprüfe den Parameter 'client_id'.",
			"DISABLED_SCOPE_PUBLIC" => "Diese App braucht keinen Zugriff auf ein oder mehrere der angefragten Berechtigungen. Vielleicht versucht jemand dich im Namen der App zu überlisten. Diese Anfrage wurde dem Appinhaber gemeldet.",
			"NO_CLIENT" => "Es wurde keine AppID angegeben. Bitte gib einen Wert für 'client_id' an.",
			"REDIRECT" => "Klicke <a href='{{redirect}}'>hier</a> um in die App zurückzukommen."
		],
		
		"SCOPE" => [
			"EMAIL" => [
				"@TRANSLATION" => "E-mail",
				"DESCRIPTION" => "Die E-mail deines Accounts."
			],
			"NAME" => [
				"@TRANSLATION" => "Name",
				"DESCRIPTION" => "Dein Vollständiger Name."
			],
			"USERNAME" => [
				"@TRANSLATION" => "Nutzername",
				"DESCRIPTION" => "Dein selbstgewählter Nutzername"
			],
			"ID" => [
				"@TRANSLATION" => "Nutzer ID",
				"DESCRIPTION" => "Die Nutzer ID deines Accounts."
			],
			"CLOUD_SAVE" => [
				"@TRANSLATION" => "Online Speicher",
				"DESCRIPTION" => "Ermöglicht der App Informationen für dich bei uns zu Speichern."
			],
			"BASIC" => [
				"@TRANSLATION" => "Basis",
				"DESCRIPTION" => "Beinhaltet Zugriff auf deine Nutzernummer, Nuternamen und Cloud save."
			],
			"EMAIL" => [
				"@TRANSLATION" => "E-mail",
				"DESCRIPTION" => "Die E-mail deines Accounts."
			],
		]
	]
);

?>
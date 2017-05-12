# UF_OAUTH2-SERVER
Implementation of [league/oauth2-server](https://oauth2.thephpleague.com) in [userfrosting4](https://userfrosting.com)

## What does it do?
With this sprinkle you can securly conect your app to userfrosting with the OAuth2 authorization flow.
In short, this is the `This App wants to get access to ...` that you know from Google facebook and others for userfrosting.
To get access to some data you have to redirect the user to `YourDomain.com/authorize/{{AppID}}/token/{{scope}}` while AppID 
is an unique identifier to your app (you can have as many as you want) that will be generated when you register your app.
And {{scope}} is a list of permissions for your app separated by `+` or <kbd>space</kbd>.
You can also replace `token` with `code` to optain an access code instead of an token, more on this [here](http://stackoverflow.com/questions/16321455),
but I would recomend using the token for people that just want to conect their unity3d game to their own server.
And also for other people that are just getting started.


# Instalation
1.Download and copy the Sprinkle, or open it with github and clone it in your Sprinkle folder.
1.Add `api` to your `sprinkles.json`.
1.Run `composer update` in the folder `/app`.
1.Then you have to create a public and private key, we need them in order to encrypt the tokens.
Navigate to `UF_OAUTH2-SERVER/src/OAuth2` open the terminal and run `openssl genrsa -out private.key 1024` _you can also replace 1024 with 2048 to generate a longer key_
Then you have to extract the public key from the private key with `openssl rsa -in private.key -pubout -out public.key`. More information on this [here](https://oauth2.thephpleague.com/installation/)
1.Open the terminal in `/migrations` and run `php uf-install` type `y` wait till it finishes and close the terminal.
You can now create `Clients` aka Applications.
1.Open `YourDomain/apps` and continue there.

## It looks like this
![screenshot1](https://github.com/Ekwav/UF_OAUTH2-SERVER/tree/develop/screenshots/authorization_page.PNG)
![screenshot2](https://github.com/Ekwav/UF_OAUTH2-SERVER/tree/develop/screenshots/authorization_page_mobile.PNG)
![screenshot1](https://github.com/Ekwav/UF_OAUTH2-SERVER/tree/develop/screenshots/manage_apps.PNG)


## Important things to know
My sprinkle may contain bugs and errors of any type, if you find one, please report it in the issues tab.

If you need help, you can find me in the [userfrosting chat](https://chat.userfrosting.com).

You have to add every API-endpoint to the csrf execlution list in `public/index.php`.
Modify line `49` to `51` to say something like:
```
$csrfBlacklist = [
    $container->config['assets.raw.path'],
	"/api/userinfo",
	"/api/anotherEndpoint"
];```

Don't remove the `Powered by Coflnet` from the authorization page, it has to stay visable. You can modify everything else to fit your needs.

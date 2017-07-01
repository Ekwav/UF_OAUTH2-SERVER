
# UF_OAUTH2-SERVER
Implementation of [league/oauth2-server](https://oauth2.thephpleague.com) in [userfrosting4](https://userfrosting.com)

## What does it do?
With this sprinkle, you can securely connect your app to userfrosting with the OAuth2 authorization flow.
In short, this is the `This App wants to get access to ...` that you know from Google Facebook and others for Userfrosting.
To get access to some data you have to redirect the user to `YourDomain.com/authorize/{{AppID}}/token/{{scope}}` while AppID
is a unique identifier to your app (you can have as many as you want) that will be generated when you register your app.
And {{scope}} is a list of permissions for your app separated by `+` or <kbd>space</kbd>.
You can also replace `token` with `code` to obtain an access code instead of a token, more on this [here](http://stackoverflow.com/questions/16321455),
but I would recommend using the token for people that just want to connect their unity3d game to their own server.
And also for other people that are just getting started.


# Installation
1. Download and copy the Sprinkle, or open it with GitHub and clone it in your Sprinkle folder.  
2. Add `api` to your `sprinkles.json`.  
3. Run `composer update` in your Userfrosting installation directory (rootfolder).  
4. Then you have to create a public and private key, we need them in order to encrypt the tokens.  
Navigate to `UF_OAUTH2-SERVER/src/OAuth2` open the terminal and run `openssl genrsa -out private.key 1024` _you can also replace 1024 with 2048 to generate a longer key_
Then you have to extract the public key from the private key with `openssl rsa -in private.key -pubout -out public.key`. More information on this [here](https://oauth2.thephpleague.com/installation/)
5. Open the terminal in your root Userfrosting directory and run `php bakery bake` till it finishes and closes the terminal.  
You can now create `Clients` aka Applications.
6. Open `YourDomain/apps` and continue there.  

## It looks like this
![screenshot1](https://github.com/Ekwav/UF_OAUTH2-SERVER/blob/master/screenshots/authorization_page.PNG?raw=true)
![screenshot2](https://github.com/Ekwav/UF_OAUTH2-SERVER/blob/master/screenshots/authorization_page_mobile.PNG?raw=true)
![screenshot1](https://github.com/Ekwav/UF_OAUTH2-SERVER/blob/master/screenshots/manage_apps.PNG?raw=true)


## Important things to know
My sprinkle may contain bugs and errors of any type, if you find one, please report it in the issues tab.

If you need help, you can find me in the [userfrosting chat](https://chat.userfrosting.com/direct/Ekwav).

-You have to add every API-endpoint to the csrf blacklist in your config.-
Currently (1.7.2017) this didn't work for me, for that I recommend you to create
your routes after the schema `remoteapi/CUSTOMNAME` to cover them automatically.  
```
'csrf' => [
    // A list of URL paths to ignore CSRF checks on
    'blacklist' =>  [
      "^remoteapi/userinfo",
	    "^remoteapi/anotherEndpoint"
]
```

## Usage
Protect your API endpoints by adding `->add(new ResourceServerMiddleware($this->ci->ResourceServer));` to the routes you want to protect. Remember [adding it to the csrfBlacklist, or name it `/remoteapi/ENDPOINT`](https://github.com/Ekwav/UF_OAUTH2-SERVER/blob/master/README.md#important-things-to-know). Now that route is protected and can only be accessed by using POST with an `Authorization` header with the value `access token`.    
Getting an access token is as easy as redirecting the user from your application to your server by opening a browser. The URL follows the schema `https://YOURDOMAIN.COM/authorize/APPID/token/SCOPES` you can find your APPID on the site `/apps` the scopes is an array of permissions you want to get separated by `space` or `+` (URL encoded `space`). The user can then review the requested permissions and `authorize`, `edit` or `deny` it. If the user authorizes the request he will be redirected to the URL specified on app creation with the token as a parameter. You then have to grab from the URL and save it to the device storage for further use.  
Now you have the token on your user's device, you are able to send requests.
`POST` it to the server as a header with the key `Authorization` and everything should be fine.  
But how do you know, what user is requesting data from you at the server side in your Userfrosting Controller? It turns out, that the access token is an encrypted JSON array aka `JSON Web Token` that contains all important information about the token. It stores:  
1. The user_id
2. The app/client_id
3. The scopes
4. The expiration time. (the default is 4 weeks)
5. The access token ID. (Can be used for disabling it from the server side or tracking purposes)
For an example on how to use these look at the `getUserInfo()` function in the [ApiAuthController](https://github.com/Ekwav/UF_OAUTH2-SERVER/blob/master/src/Controller/ApiAuthController.php#L183)

Don't remove the `Powered by Coflnet` from the authorization page, it has to stay visible. You can modify everything else under MIT to fit your needs.

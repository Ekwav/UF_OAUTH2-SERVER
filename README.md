# UF_OAUTH2-SERVER
Implementation of [league/oauth2-server](https://oauth2.thephpleague.com) in [userfrosting4](https://userfrosting.com)

# Instalation
Download and copy the Sprinkle, or open it with github and clone it in your Sprinkle folder.
Then you have to create a public and private key, we need them in order to encrypt the tokens.
Navigate to `UF_OAUTH2-SERVER/src/OAuth2` open the terminal and run `openssl genrsa -out private.key 1024` _you can also replace 1024 with 2048 to generate a longer key_
Then you have to extract the public key from the private key with `openssl rsa -in private.key -pubout -out public.key`. More information on this [here](https://oauth2.thephpleague.com/installation/)
You can now create `Clients` aka Applications.
Open `YourDomain/apps` and continue there.


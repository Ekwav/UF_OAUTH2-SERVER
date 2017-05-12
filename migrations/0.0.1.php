<?php

    use Illuminate\Database\Capsule\Manager as Capsule;
    use Illuminate\Database\Schema\Blueprint;
	use UserFrosting\Sprinkle\Api\Model\Scopes;
	
 if (!$schema->hasTable('oauth_auth_codes')) {
  $schema->create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id');
            $table->integer('client_id');
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
		 echo "Created table 'oauth_auth_codes'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_auth_codes' already exists.  Skipping..." . PHP_EOL;
    }
 
 if (!$schema->hasTable('oauth_access_tokens')) {
  $schema->create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->integer('user_id')->index()->nullable();
            $table->integer('client_id');
            $table->string('name')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('revoked');
            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
        });
		 echo "Created table 'oauth_access_tokens'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_access_tokens' already exists.  Skipping..." . PHP_EOL;
    }
 
 if (!$schema->hasTable('oauth_refresh_tokens')) {
  $schema->create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('access_token_id', 100)->index();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });
		 echo "Created table 'oauth_refresh_tokens'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_refresh_tokens' already exists.  Skipping..." . PHP_EOL;
    }
 
 if (!$schema->hasTable('oauth_clients')) {
  $schema->create('oauth_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->nullable();
            $table->string('name',40);
			$table->bigInteger('public_id');
			$table->string('description');
            $table->string('secret', 100);
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
			$table->string('icon_url');
			$table->text('active_scopes');
            $table->timestamps();
        });
		 echo "Created table 'oauth_clients'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_clients' already exists.  Skipping..." . PHP_EOL;
    }
	
	if (!$schema->hasTable('oauth_scopes')) {
  $schema->create('oauth_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name', 32);
			$table->text('description');
			$table->string('permissions');
			$table->timestamps();
			});
			
			// Create the default scopes
			$scopes = [
				'email' => new Scopes([
					'slug' => 'email',
					'name' => 'OAUTH2.SCOPE.EMAIL',
					'description' => 'OAUTH2.SCOPE.EMAIL.DESCRIPTION',
					'permissions' => ''
				]),
				'basic' => new Scopes([
					'slug' => 'basic',
					'name' => 'OAUTH2.SCOPE.BASIC',
					'description' => 'OAUTH2.SCOPE.BASIC.DESCRIPTION',
					'permissions' => ''
				])
			];

			foreach ($scopes as $slug => $scopes) {
				$scopes->save();
			}
		
		 echo "Created table 'oauth_scopes'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_scopes' already exists.  Skipping..." . PHP_EOL;
    }
 
 
 
 if (!$schema->hasTable('oauth_personal_access_clients')) {
  $schema->create('oauth_personal_access_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->index();
            $table->timestamps();
        });
		 echo "Created table 'oauth_personal_access_clients'..." . PHP_EOL;
    } else {
        echo "Table 'oauth_personal_access_clients' already exists.  Skipping..." . PHP_EOL;
    }
 
 /* System created by myself but replaced with laravel/passport
     
    if (!$schema->hasTable('tokens')) {
        $schema->create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip_address', 45)->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('token', 255)->comment('The token that the client also has.');
            $table->string('app_id', 32)->comment('The App id for the token.');
            $table->text('access_to')->nullable();
			$table->time('expires_on');
			$table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
        });
        echo "Created table 'tokens'..." . PHP_EOL;
    } else {
        echo "Table 'tokens' already exists.  Skipping..." . PHP_EOL;
    }
	
	if (!$schema->hasTable('apps')) {
        $schema->create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner')->unsigned(); //the owner
            $table->string('app_id', 32)->comment('A random app Id');
			$table->string('name', 32);
			$table->text('description');
			$table->string('app_secret', 128)->comment('A random app secret very secure');
			$table->text('redirect_uri')->nullable()->comment('The uri where the token should be sent to');
			$table->text('settings')->nullable();
			$table->text('project_id')->comment('The project of the app');
			$table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('owner')->references('id')->on('users');
            $table->index('user_id');
        });
        echo "Created table 'apps'..." . PHP_EOL;
    } else {
        echo "Table 'apps' already exists.  Skipping..." . PHP_EOL;
    }
	
	if (!$schema->hasTable('projects')) {
        $schema->create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //the owner
            $table->string('project_id', 32)->comment('A random project Id');
			$table->string('name', 32);
			$table->text('description');
			$table->text('members')->nullable()->comment('Json formated list of users and their rights';
			$table->text('settings')->nullable()->comment('Json formated settings';$table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
        });
        echo "Created table 'apps'..." . PHP_EOL;
    } else {
        echo "Table 'apps' already exists.  Skipping..." . PHP_EOL;
    }
*/
<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/Ekwav/UF_OAUTH2-SERVER
 */
namespace UserFrosting\Sprinkle\Api\Database\Migrations\v002;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;
use UserFrosting\Sprinkle\Api\Database\Models\Scopes;

/**
 * Scopes table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthScopes extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_scopes')) {
        $this->schema->create('oauth_scopes', function (Blueprint $table) {
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
            ]),
            'full_access' => new Scopes([
              'slug' => 'full_access',
              'name' => 'OAUTH2.SCOPE.FULL',
              'description' => 'OAUTH2.SCOPE.BASIC.DESCRIPTION',
              'permissions' => ''
            ])
          ];

          foreach ($scopes as $slug => $scopes) {
          		$scopes->save();
          }
      }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('oauth_scopes');
    }
}

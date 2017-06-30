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

/**
 * Clients table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthClients extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_clients')) {
        $this->schema->create('oauth_clients', function (Blueprint $table) {
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
         }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('oauth_clients');
    }
}

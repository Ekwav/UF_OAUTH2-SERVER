<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/Ekwav/UF_OAUTH2-SERVER
 */
namespace UserFrosting\Sprinkle\OAuth2Server\Database\Migrations\v002;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use UserFrosting\System\Bakery\Migration;

/**
 * PersonalAccessClients table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthPersonalAccessClients extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_personal_access_clients')) {
        $this->schema->create('oauth_personal_access_clients', function (Blueprint $table) {
                  $table->increments('id');
                  $table->integer('client_id')->index();
                  $table->timestamps();
              });
         }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('oauth_personal_access_clients');
    }
}

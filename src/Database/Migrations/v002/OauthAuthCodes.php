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
 * Authcodes table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthAuthCodes extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_auth_codes')) {
       $this->schema->create('oauth_auth_codes', function (Blueprint $table) {
                 $table->string('id', 100)->primary();
                 $table->integer('user_id');
                 $table->integer('client_id');
                 $table->text('scopes')->nullable();
                 $table->boolean('revoked');
                 $table->dateTime('expires_at')->nullable();
             });
         }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('oauth_auth_codes');
    }
}

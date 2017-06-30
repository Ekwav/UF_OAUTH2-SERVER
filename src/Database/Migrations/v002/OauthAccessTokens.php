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
 * AccessTokens table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthAccessTokens extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_access_tokens')) {
        $this->schema->create('oauth_access_tokens', function (Blueprint $table) {
                  $table->string('id', 100)->primary();
                  $table->integer('user_id')->index()->nullable();
                  $table->integer('client_id');
                  $table->string('name')->nullable();
                  $table->text('scopes')->nullable();
                  $table->boolean('revoked');
                  $table->timestamps();
                  $table->dateTime('expires_at')->nullable();
              });
         }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('oauth_access_tokens');
    }
}

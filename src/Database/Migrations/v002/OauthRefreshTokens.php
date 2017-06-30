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
 * RefreshTokens table migration
 * Version 0.0.2
 *
 * @extends Migration
 * @author Äkwav (https://coflnet.com/ekwav)
 */
class OauthRefreshTokens extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
      if (!$this->schema->hasTable('oauth_refresh_tokens')) {
        $this->schema->create('oauth_refresh_tokens', function (Blueprint $table) {
                  $table->string('id', 100)->primary();
                  $table->string('access_token_id', 100)->index();
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
        $this->schema->drop('oauth_refresh_tokens');
    }
}

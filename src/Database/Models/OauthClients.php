<?php
namespace UserFrosting\Sprinkle\Api\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

class OauthClients extends Model {

    public $timestamps = true;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = "oauth_clients";

    protected $fillable = [
        "user_id",
        "project_id",
        "name",
        "secret",
        "redirect",
        "personal_access_client",
        "password_client",
        "revoked",
        "description",
        "active_scopes",
        "icon_url",
        "public_id",
        "settings"
    ];
}

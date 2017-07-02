<?php
namespace UserFrosting\Sprinkle\OAuth2Server\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Scopes extends Model {

    public $timestamps = true;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = "oauth_scopes";

    protected $fillable = [
        "slug",
        "name",
        "description",
        "permissions",
    ];
}

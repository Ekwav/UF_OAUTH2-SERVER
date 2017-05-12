<?php
namespace UserFrosting\Sprinkle\Api\Model;

use UserFrosting\Sprinkle\Core\Model\UFModel;

class Scopes extends UFModel {

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
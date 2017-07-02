<?php
namespace UserFrosting\Sprinkle\OAuth2Server\Database\Models;

use UserFrosting\Sprinkle\Core\Database\Models\Model;

class tokens extends Model {

    /*
    // * @var string The name of the table for the current model.

    protected $table = "tokens";

    protected $fillable = [
		"ip_address",
        "user_id",
		"token",
		"app_id",
		"access_to",
		"expires_on"
    ];


    // * Directly joins the related user, so we can do things like sort, search, paginate, etc.

    public function scopeJoinUser($query)
    {
        $query = $query->select('tokens.*');

        $query = $query->leftJoin('users', 'tokens.user_id', '=', 'users.id');

        return $query;
    }


    // * Get the user associated with this owler.

    public function user()
    {
        //** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper
        $classMapper = static::$ci->classMapper;

        return $this->belongsTo($classMapper->getClassMapping('user'), 'user_id');
    }
	*/
}

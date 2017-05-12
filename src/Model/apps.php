<?php
namespace UserFrosting\Sprinkle\api\Model;

use UserFrosting\Sprinkle\Core\Model\UFModel;

class apps extends UFModel {

    
     //* @var string The name of the table for the current model.
     
    protected $table = "apps";

    protected $fillable = [
		"user_id",
		"app_id",
		"app_secret",
		"access_allowed_to",
		"redirect_uri",
		"special_rights",
		"team_members"
    ];

    
   //  * Directly joins the related user, so we can do things like sort, search, paginate, etc.
     
    public function scopeJoinUser($query)
    {
        $query = $query->select('apps.*');

        $query = $query->leftJoin('users', 'apps.user_id', '=', 'users.id');

        return $query;
    }

    
    // * Get the user associated with this owler.
    
    public function user()
    {
        //** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper 
        $classMapper = static::$ci->classMapper;

        return $this->belongsTo($classMapper->getClassMapping('user'), 'user_id');
    }
	
}
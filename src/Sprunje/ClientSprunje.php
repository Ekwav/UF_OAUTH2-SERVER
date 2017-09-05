<?php
namespace UserFrosting\Sprinkle\OAuth2Server\Sprunje;

use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

use UserFrosting\Sprinkle\OAuth2Server\Database\Models\OauthClients;

class ClientSprunje extends Sprunje
{
    protected $name = 'clients';

    protected $sortable = [
        'name',
        'description',
        'created_at'
    ];

    protected $filterable = [
        'name',
        'description',
        'created_at'
    ];

    /**
     * Set the initial query used by your Sprunje.
     */
    protected function baseQuery()
    {
        $instance = new OauthClients();

        // Alternatively, if you have defined a class mapping, you can use the classMapper:
        // $instance = $this->classMapper->createInstance('owl');

        return $instance->newQuery();
    }

    protected function applyTransformations($collection)
    {
        // Exclude password field from results
        $collection->transform(function ($item, $key) {
            unset($item['secret']);
            return $item;
        });

        return $collection;
    }
}

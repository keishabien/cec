<?php
namespace UserFrosting\Sprinkle\Site\Sprunje;

use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;
use UserFrosting\Sprinkle\Site\Database\Models\Search;

class SearchSprunje extends Sprunje
{
    protected $name = 'search';
    protected $filterable = [
        'office_name'
    ];

//    Set initial query used
    protected function baseQuery()
    {
        // TODO: Implement baseQuery() method.
        $instance = new Search();

        // Alternatively, if you have defined a class mapping, you can use the classMapper:
        // $instance = $this->classMapper->createInstance('owl');

        return $instance->newQuery();
    }
}

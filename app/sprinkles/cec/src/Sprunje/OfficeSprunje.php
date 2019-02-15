<?php

namespace UserFrosting\Sprinkle\Cec\Sprunje;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;
use UserFrosting\Sprinkle\Cec\Database\Models\Office;

class OfficeSprunje extends Sprunje
{
    protected $name = 'office_details';

    protected $sortable = [
        'page_title',
        'state'
    ];

    protected $filterable = [
        'page_title',
        'state'
    ];

    /**
     * {@inheritDoc}
     */
    protected function baseQuery()
    {
//        $instance = new Office();

        // Alternatively, if you have defined a class mapping, you can use the classMapper:
         $instance = $this->classMapper->createInstance('office');

        return $instance->newQuery();
    }
}

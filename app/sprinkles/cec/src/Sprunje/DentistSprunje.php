<?php

namespace UserFrosting\Sprinkle\Cec\Sprunje;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;
use UserFrosting\Sprinkle\Cec\Database\Models\DentistDetails;

class DentistSprunje extends Sprunje
{
    protected $name = 'dentist_details';

    protected $sortable = [
        'name',
        'office_id'
    ];

    protected $filterable = [
        'name'
    ];

    protected $listable = [
        'office_id',
        'name'
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

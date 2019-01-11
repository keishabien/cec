<?php

namespace UserFrosting\Sprinkle\Site\Sprunje;

use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;
use UserFrosting\Sprinkle\Site\Database\Models\Office;

class OfficeSprunje extends Sprunje
{
    protected $name = 'offices';

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
        return $this->classMapper->createInstance('office')->newQuery();
    }
}

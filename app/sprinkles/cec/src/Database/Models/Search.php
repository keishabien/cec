<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class Search extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
//    protected $table = 'midwest_wrdp1.cec_update';

    protected $table = 'midwest_wrdp1.office_details';


    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = true;

    /**
     * Get the phone record associated with the user.
     */
    public function search()
    {
        return $this->hasOne('App\Search');
    }
}

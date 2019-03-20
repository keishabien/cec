<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class ChildRecall extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.crecall_details';

    protected $fillable = [
        'office_id',
        'age_range',
        'braces_units',
        'dr_units',
        'hyg_units'
    ];


    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = true;

    public function offices()
    {
        return $this->belongsToMany('App\Office');
    }

}

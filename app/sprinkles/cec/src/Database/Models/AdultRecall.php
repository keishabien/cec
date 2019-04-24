<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class AdultRecall extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.arecall_details';

    protected $fillable = [
        'office_id',
        'dentist_id',
        'hygienist_id',
        'no_plan_units',
        'record_duration',
        'srp_cleaning',
        'srp_transfer',
        'srp_cleaning_units',
        'srp_dr_exam',
        'perio_units',
        'status_id'
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

<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class DrOff extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.dr_off';

    protected $fillable = [
        'office_details_id',
        'doctor_details_id'
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

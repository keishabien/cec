<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class DentistDetails extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.dentist_details';

    protected $fillable = [
        'name',
        'nickname',
        'provider_num',
        'emergency_num',
        'locum',
        'start_date',
        'end_date',
        'leave',
        'leave_start_date',
        'leave_end_date',
        'notes',
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

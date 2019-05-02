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
        'office_id',
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

    public function anpies()
    {
        $classMapper = static::$ci->classMapper;

        return $this->hasMany($classMapper->getClassMapping('anpie'), 'dentist_id');
    }

    public function offices()
    {
        return $this->hasMany('UserFrosting\Sprinkle\Cec\Database\Models\Office', 'office_id', 'id');
    }


    public function hygienists()
    {
        $classMapper = static::$ci->classMapper;
        return $this->belongsTo($classMapper->getClassMapping('hygienist'), 'hygienist_id');
    }

    public function status()
    {
        $classMapper = static::$ci->classMapper;
        return $this->belongsTo($classMapper->getClassMapping('status'), 'status_id');
    }

}

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
        'dentist_id',
        'hygienist_id',
        'age_range',
        'braces_units',
        'dr_units',
        'hyg_units',
        'status_id'
    ];


    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = true;

    public function offices()
    {
        return $this->hasMany('UserFrosting\Sprinkle\Cec\Database\Models\Office', 'office_id', 'id');
    }

    public function dentists()
    {
        $classMapper = static::$ci->classMapper;
        return $this->belongsTo($classMapper->getClassMapping('dentist'), 'dentist_id');
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

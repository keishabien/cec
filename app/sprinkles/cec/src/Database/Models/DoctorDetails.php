<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class DoctorDetails extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'cec.dentist_details';

    protected $fillable = [
        'page_title',
        'state'
    ];
    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = false;

}

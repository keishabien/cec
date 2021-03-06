<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class ZipCodes extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.zipcodes';

    protected $fillable = [
        'zip',
        'city',
        'state',
        'latitude',
        'longitude'
    ];

    /**
     * @var bool Enable timestamps for this class.
     */
    public $timestamps = false;

}

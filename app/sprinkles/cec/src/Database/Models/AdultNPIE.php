<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class AdultNPIE extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.anpie_details';

    protected $fillable = [
        'office_id',
<<<<<<< HEAD
        'dentist_id',
        'hygienist_id',
=======
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
        'chair',
        'dr_units',
        'hyg_units',
        'first_visit',
        'cleaning',
<<<<<<< HEAD
        'notes',
        'status_id'
=======
        'notes'
>>>>>>> 977d424d1ce6ee511a538a80c689bbadc6c2f62e
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

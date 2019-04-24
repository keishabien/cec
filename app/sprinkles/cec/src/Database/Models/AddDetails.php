<?php

namespace UserFrosting\Sprinkle\Cec\Database\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

class AddDetails extends Model
{
    /**
     * @var string The name of the table for the current model.
     */

    protected $table = 'cec.additional_details';

    protected $fillable = [
        'office_id',
        'bom_name',
        'bom_number',
        'dr_hyg_plan',
        'family_same_dr',
        'allow_diff_provider',
        'allow_diff_transfer',
        'int_transfer_NPIE',
        'NPIE_blocks_request',
        'NPIE_daily_limit',
        'directions',
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

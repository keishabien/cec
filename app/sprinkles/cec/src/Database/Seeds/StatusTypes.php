<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Cec\Database\Seeds;

use UserFrosting\Sprinkle\Core\Database\Seeder\BaseSeed;
use UserFrosting\Sprinkle\Cec\Database\Models\Status;
use UserFrosting\Sprinkle\Core\Facades\Debug;

/**
 * Seeder for the default groups
 */
class StatusTypes extends BaseSeed
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {

        $status = array(new Status([
            'record' => 'approved'
            ]),
            new Status([
                'record' => 'pending'
            ]),
            new Status([
                'record' => 'denied'
            ]));

        foreach ($status as $sts) {
            // Don't save if already exist
            if (Status::where('record', $sts->record)->first() == null) {
                $sts->save();
            }
        }

    }
}

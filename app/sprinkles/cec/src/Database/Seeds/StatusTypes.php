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
use UserFrosting\Sprinkle\Account\Database\Models\Status;

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
        $status = $this->getStatus();

        foreach ($status as $sts) {
            // Don't save if already exist
            if (Status::where('slug', $sts->slug)->first() == null) {
                $sts->save();
            }
        }
    }

    /**
     * @return array Groups to seed
     */
    protected function getStatus()
    {
        return [
            new Status([
                'type'        => 'approved'
            ]),
            new Status([
                'type'        => 'pending'
            ]),
            new Status([
                'type'        => 'denied'
            ])
        ];
    }
}

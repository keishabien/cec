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
use UserFrosting\Sprinkle\Account\Database\Models\Group;

/**
 * Seeder for the default groups
 */
class MidwestGroup extends BaseSeed
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $groups = $this->getGroups();

        foreach ($groups as $group) {
            // Don't save if already exist
            if (Group::where('slug', $group->slug)->first() == null) {
                $group->save();
            }
        }
    }

    /**
     * @return array Groups to seed
     */
    protected function getGroups()
    {
        return [
            new Group([
                'slug'        => 'midwest',
                'name'        => 'Midwest'

            ])
        ];
    }
}

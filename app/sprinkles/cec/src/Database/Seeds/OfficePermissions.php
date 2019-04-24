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
use UserFrosting\Sprinkle\Account\Database\Models\Permission;

/**
 * Seeder for the default groups
 */
class OfficePermissions extends BaseSeed
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->validateMigrationDependencies([
            '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\RolesTable',
            '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionsTable'
        ]);

        foreach ($this->officePermissions() as $permissionInfo) {
            $permission = new Permission($permissionInfo);
            $permission->save();
        }
    }

    /**
     * @return array Groups to seed
     */
    protected function officePermissions()
    {
        return [
            [
                'slug' => 'uri_offices',
                'name' => 'See the offices page',
                'conditions' => 'always()',
                'description' => 'Enables the user to see the offices page'
            ]
        ];
    }
}

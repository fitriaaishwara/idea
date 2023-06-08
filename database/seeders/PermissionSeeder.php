<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name'              => 'Dashboard',
                'group_permission'  => 'Dashboard',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data User',
                'group_permission'  => 'User',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create User',
                'group_permission'  => 'User',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit User',
                'group_permission'  => 'User',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete User',
                'group_permission'  => 'User',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Role',
                'group_permission'  => 'Role',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Role',
                'group_permission'  => 'Role',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Role',
                'group_permission'  => 'Role',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Role',
                'group_permission'  => 'Role',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Document Type',
                'group_permission'  => 'Document Type',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Document Type',
                'group_permission'  => 'Document Type',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Document Type',
                'group_permission'  => 'Document Type',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Document Type',
                'group_permission'  => 'Document Type',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Document Archive',
                'group_permission'  => 'Document Archive',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Download Document Archive',
                'group_permission'  => 'Document Archive',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Scope',
                'group_permission'  => 'Scope',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Scope',
                'group_permission'  => 'Scope',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Scope',
                'group_permission'  => 'Scope',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Scope',
                'group_permission'  => 'Scope',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Document',
                'group_permission'  => 'Document',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Document',
                'group_permission'  => 'Document',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Document',
                'group_permission'  => 'Document',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Document',
                'group_permission'  => 'Document',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Download Document',
                'group_permission'  => 'Document',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Recycle Bin',
                'group_permission'  => 'Recycle Bin',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'All Data Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Follow Up Client',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Client Win',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Follow Up',
                'group_permission'  => 'Client',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Schedule Email',
                'group_permission'  => 'Schedule Email',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Create Schedule Email',
                'group_permission'  => 'Schedule Email',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Edit Schedule Email',
                'group_permission'  => 'Schedule Email',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Delete Schedule Email',
                'group_permission'  => 'Schedule Email',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'All Data Schedule Email',
                'group_permission'  => 'Schedule Email',
                'guard_name'        => 'web',
            ],
            [
                'name'              => 'Data Project',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Create Project',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Edit Project',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Delete Project',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'All Data Project',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Data Project Finish',
                'group_permission'  => 'Project',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Create Project Meeting',
                'group_permission'  => 'Project Meeting',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Edit Project Meeting',
                'group_permission'  => 'Project Meeting',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Delete Project Meeting',
                'group_permission'  => 'Project Meeting',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Download Project Meeting',
                'group_permission'  => 'Project Meeting',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Create Folder',
                'group_permission'  => 'Folder',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Edit Folder',
                'group_permission'  => 'Folder',
                'guard_name'        => 'web',

            ],
            [
                'name'              => 'Delete Folder',
                'group_permission'  => 'Folder',
                'guard_name'        => 'web',

            ],
        ];

        DB::table('permissions')->insert($permission);
    }
}

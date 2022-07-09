<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Admin',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Agente',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'manager']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Manager',
            ])->save();
        }
    }
}

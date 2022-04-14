<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([VoyagerDatabaseSeeder::class]);

        $developer = new User([
            'name' => 'Developer',
            'email' => 'info@nairda.net',
            'phone' => '55555555',
            'password' => bcrypt('info@nairda.net')
        ]);
        $developer->save();
        $developer->assignRole('admin');

        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '55555555',
            'password' => bcrypt('admin')
        ]);
        $user->save();
        $user->assignRole('advanced');
    }
}

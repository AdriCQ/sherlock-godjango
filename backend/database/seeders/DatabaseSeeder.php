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
            'email' => 'dev@godjango.dev',
            'phone' => '500000',
            'password' => bcrypt('dev@godjango.dev')
        ]);
        $developer->save();
        $developer->assignRole('admin');

        $user = new User([
            'name' => 'Manager Principal',
            'email' => 'admin@godjango.dev',
            'phone' => '500001',
            'password' => bcrypt('admin@godjango.dev')
        ]);
        $user->save();
        $user->assignRole('manager');
    }
}

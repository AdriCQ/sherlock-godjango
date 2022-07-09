<?php

namespace Database\Seeders;

use App\Models\AgentGroup;
use App\Models\Category;
use App\Models\Client;
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

        // Create Admin Client
        $sherlockClient = new Client(['name'=>'Sherlock', 'description'=>'Sherlock Admin']);
        $sherlockClient->save();

        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@godjango.dev',
            'phone' => '500001',
            'client_id'=>$sherlockClient->id,
            'password' => bcrypt('admin@godjango.dev')
        ]);
        $user->save();
        $user->assignRole('admin');

        // Seed default AgentGroup
        // AgentGroup::query()->insert(['name' => 'Default', 'description' => 'Grupo por defecto para agentes']);

        // Seed Agent Categories
        Category::query()->insert([[
            'name' => 'Default'
        ]]);
    }
}

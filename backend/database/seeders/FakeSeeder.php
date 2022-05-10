<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([DatabaseSeeder::class]);

        $this->seedUsers(5);
    }

    /**
     * seedUsers
     * @param int $limit
     * @param int $repeat
     */
    private function seedUsers(int $limit = 10, int $repeat = 1)
    {
        $faker = Factory::create();
        for ($r = 0; $r < $repeat; $r++) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('password'),
                    'role_id' => 2
                ]);
            }
            User::query()->insert($models);
        }
    }
}

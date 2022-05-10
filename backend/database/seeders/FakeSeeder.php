<?php

namespace Database\Seeders;

use App\Models\PersonalGroup;
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

        $this->seedPersonalGroups(2);
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
                    'role_id' => 2,
                    'group_id' => $faker->numberBetween(1, PersonalGroup::count())

                ]);
            }
            User::query()->insert($models);
        }
    }
    /**
     * seedPersonalGroups
     * @param int $limit
     * @param int $repeat
     */
    private function seedPersonalGroups(int $limit = 10, int $repeat = 1)
    {
        $faker = Factory::create();
        for ($r = 0; $r < $repeat; $r++) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'name' => $faker->name,
                    'description' => $faker->text,
                ]);
            }
            PersonalGroup::query()->insert($models);
        }
    }
}

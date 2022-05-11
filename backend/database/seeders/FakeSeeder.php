<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\AgentGroup;
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

        $this->seedUsers();
        $this->seedAgentGroups();
        $this->seedAgents();;
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
                    'phone' => $faker->phoneNumber,
                    'password' => bcrypt('password'),
                    'role_id' => 2,
                ]);
            }
            User::query()->insert($models);
        }
    }
    /**
     * Seed Agent Groups
     * @param int $limit
     * @param int $repeat
     */
    private function seedAgentGroups(int $limit = 10, int $repeat = 1)
    {
        $faker = Factory::create();
        for ($r = 0; $r < $repeat; $r++) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'name' => $faker->words(3, true),
                    'description' => $faker->text(),
                ]);
            }
            AgentGroup::query()->insert($models);
        }
    }


    /**
     * Seed Agent
     * @param int $limit
     * @param int $repeat
     */
    private function seedAgents()
    {
        $faker = Factory::create();
        $models = [];
        foreach (User::query()->where('id', '>', 2)->get() as $user) {
            array_push($models, [
                "address" => $faker->address,
                "others" => $faker->text,
                "nick" => $faker->name,
                "position" => json_encode(['lat' => 0, 'lng' => 0]),
                "bussy" => $faker->boolean,
                'agent_group_id' => $faker->numberBetween(1, AgentGroup::query()->count()),
                'user_id' => $user->id,
            ]);
        }
        Agent::query()->insert($models);
    }
}

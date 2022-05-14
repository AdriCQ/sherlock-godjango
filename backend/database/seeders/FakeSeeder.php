<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\AgentGroup;
use App\Models\Assignment;
use App\Models\AssignmentCheckpoint;
use App\Models\Event;
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
        $this->seedAgentGroups(2);
        $this->seedAgents();
        $this->seedEvents(15, 2);
        $this->seedAssignments();
        $this->seedAssignmentCheckpoints();
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
    /**
     * seedEvents
     * @param int $limit
     * @param int $repeat
     */
    private function seedEvents(int $limit = 10, int $repeat = 1)
    {
        $faker = Factory::create();
        for ($r = 0; $r < $repeat; $r++) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'type' => $faker->randomElement(Event::$TYPES),
                    'status' => $faker->randomElement(Event::$STATUS),
                    'details' => $faker->text,
                    'agent_id' => $faker->numberBetween(3, Agent::query()->count()),
                    'created_at' => now(),
                ]);
            }
            Event::query()->insert($models);
        }
    }
    /**
     * seedAssignments
     * @param int $limit
     * @param int $repeat
     */
    private function seedAssignments(int $limit = 10, int $repeat = 1)
    {
        $faker = Factory::create();
        for ($r = 0; $r < $repeat; $r++) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'name' => $faker->words(5, true),
                    'description' => $faker->text,
                    'observations' => $faker->text,
                    'event' => $faker->word,
                    'status' => $faker->numberBetween(0, 2),
                    'agent_id' => $faker->numberBetween(1, Agent::count()),
                ]);
            }
            Assignment::query()->insert($models);
        }
    }
    /**
     * seedAssignmentCheckpoints
     */
    private function seedAssignmentCheckpoints(int $limit = 5)
    {
        $faker = Factory::create();
        foreach (Assignment::all() as $ass) {
            $models = [];
            for ($l = 0; $l < $limit; $l++) {
                array_push($models, [
                    'name' => $faker->name,
                    'position' => json_encode([
                        'lat' => 22.4056,
                        'lng' => -79.9539
                    ]),
                    'status' => $faker->numberBetween(0, 2),
                    'contact' => $faker->phoneNumber(),
                    'assignment_id' => $ass->id,
                    'created_at' => now()
                ]);
            }
            AssignmentCheckpoint::query()->insert($models);
        }
    }
}

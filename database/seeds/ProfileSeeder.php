<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'admin'],
            ['name' => 'agent_partner'],
            ['name' => 'agent_customer'],
            ['name' => 'manager']
        ];

        foreach ($data as $profile) {
            Profile::query()->firstOrCreate($profile);
        }
    }
}

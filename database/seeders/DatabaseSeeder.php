<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Crm\Company;
use App\Models\Crm\Person;
use App\Models\Crm\Task;
use App\Models\User;
use Database\Seeders\Crm\CompanySeeder;
use Database\Seeders\Crm\PersonSeeder;
use Database\Seeders\Crm\TaskSeeder;
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
        // User::factory(10)->create();
        // Task::factory(10)->create();

        // \App\Models\User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(PersonSeeder::class);

    }
}

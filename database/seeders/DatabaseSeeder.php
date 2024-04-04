<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\events_routes::factory(10)->create();
        \App\Models\messages::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'rider',
            'last_name' => 'rider',
            'date' => '1997-11-24',
            'phone' => '113456889',
            'email' => 'rider@riders.com',
            'nickname' => 'riders',
            'password' => bcrypt('rider'),
            'role' => 'rider',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'last_name' => 'admin',
            'date' => '1997-11-24',
            'phone' => '113456789',
            'email' => 'admin@admins.com',
            'nickname' => 'admins',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'super_admin',
            'last_name' => 'super_admin',
            'date' => '1997-11-24',
            'phone' => '113456788',
            'email' => 'super_admin@super_admins.com',
            'nickname' => 'super_admins',
            'password' => bcrypt('super_admin'),
            'role' => 'super_admin',
        ]);
    }
}

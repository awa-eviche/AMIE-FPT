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
        $this->call(RoleAndPermissionTablesSeeder::class);
        $this->command->info('RoleAndPermission table seeded!');

        $this->call(UserSeeder::class);
        $this->command->info('User table seeded!');

        $this->call(ListeSeeder::class);
        $this->command->info('Liste table seeded!');
    }
}

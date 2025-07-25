<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\EntidadsTableSeeder;
use Database\Seeders\CuotaminimasTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);

        $this->call(CuotaminimasTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EntidadsTableSeeder::class);

        $this->call(CuotaMinimasTableSeeder::class);
    }

}

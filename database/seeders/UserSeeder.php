<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'thiago gonçalves santos',
                'email' => 'thiago1santos12@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Gabriel',
                'email' => 'Gabriel@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rafael',
                'email' => 'Rafael@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rafaela',
                'email' => 'Rafaela@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

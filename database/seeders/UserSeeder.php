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
                'name' => 'Thiago',
                'email' => 'thiago@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mariana',
                'email' => 'mariana@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Keila',
                'email' => 'keila@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'settings' => json_encode([]),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Francisco',
                'email' => 'francisco@gmail.com',
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

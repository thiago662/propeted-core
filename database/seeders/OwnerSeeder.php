<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('owners')->insert([
            [
                'id' => 1,
                'name' => 'Dono A',
                'email' => 'dono.a@gmail.com',
                'person_id' => '50672760886',
                'phone_number' => '1140244676',
                'cell_phone_number' => '11971257707',
                'zip_code' => '13304397',
                'state' => 'SP',
                'city' => 'Itu',
                'neighborhood' => 'Parque America',
                'street' => 'Luiz Carlos Pires',
                'house_number' => '131',
                'address_reference' => 'Casa',
                'birth_date' => Carbon::now(),
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

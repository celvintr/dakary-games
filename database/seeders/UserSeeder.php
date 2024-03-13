<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #Admin
        DB::table('users')->insert([
            'name'     => 'Administrador',
            'email'    => 'admin@dakarygames.net',
            'password' => Hash::make('DaKaRY,.Gam3s2022'),
        ]);

        // for ($i=0; $i < 50; $i++) {
        //     DB::table('users')->insert([
        //         'name'     => $faker->name,
        //         'email'    => $faker->safeEmail(),
        //         'password' => Hash::make('password'),
        //     ]);
        // }
    }
}

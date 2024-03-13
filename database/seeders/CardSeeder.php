<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cards')->insert([
            ['name' => 'Tarjeta de 35', 'price' => 35.00, 'comission' => 5.00],
            ['name' => 'Tarjeta de 100', 'price' => 100.00, 'comission' => 10.00],
            ['name' => 'Tarjeta de 160', 'price' => 160.00, 'comission' => 10.00],
            ['name' => 'Tarjeta de 300', 'price' => 300.00, 'comission' => 15.00],
            ['name' => 'Tarjeta de 580', 'price' => 580.00, 'comission' => 20.00],
            ['name' => 'Tarjeta Semanal', 'price' => 70.00, 'comission' => 5.00],
            ['name' => 'Tarjeta Mensual', 'price' => 280.00, 'comission' => 10.00],
            ['name' => 'Pase Elite', 'price' => 170.00, 'comission' => 10.00],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=1; $i <= 50; $i++) {
            DB::table('dealers')->insert([
                'code'     => 'D' . $i,
                'document' => $faker->numerify('##-#######'),
                'name'     => $faker->name,
                'phone'    => '(' . $faker->numerify('###') . ') ' . $faker->numerify('####') . '-' . $faker->numerify('####'),
                'company'  => $faker->company(),
                'address'  => $faker->address(),
                'maps'     => '{"address_components":[{"long_name":"9MHR+RF","short_name":"9MHR+RF","types":["plus_code"]},{"long_name":"Pueblo Nuevo","short_name":"Pueblo Nuevo","types":["locality","political"]},{"long_name":"Cedros","short_name":"Cedros","types":["administrative_area_level_2","political"]},{"long_name":"Francisco Moraz\u00e1n Department","short_name":"Francisco Moraz\u00e1n Department","types":["administrative_area_level_1","political"]},{"long_name":"Honduras","short_name":"HN","types":["country","political"]}],"formatted_address":"9MHR+RF Pueblo Nuevo, Honduras","geometry":{"bounds":{"south":14.3795,"west":-87.308875,"north":14.379625,"east":-87.30874999999999},"location":{"lat":14.3796202,"lng":-87.3088291},"location_type":"GEOMETRIC_CENTER","viewport":{"south":14.3782135197085,"west":-87.31016148029151,"north":14.3809114802915,"east":-87.30746351970849}},"place_id":"GhIJTc0vlF3CLEARZiMh28PTVcA","plus_code":{"compound_code":"9MHR+RF Pueblo Nuevo, Honduras","global_code":"766J9MHR+RF"},"types":["plus_code"]}',
            ]);
        }
    }
}

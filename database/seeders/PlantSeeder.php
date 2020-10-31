<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Species($faker));
        foreach(range(0,4) as $i){
            DB::table('plants')->insert([
                'name' => $faker->plant,
                'description' => $faker->sentence(20,true),
                'price' => $faker->randomNumber(6),
                'rate' => $faker->randomFloat(NULL,0,5),
                'types' => 'recommended',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}

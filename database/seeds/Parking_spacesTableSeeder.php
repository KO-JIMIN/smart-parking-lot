<?php

use Illuminate\Database\Seeder;

class Parking_spacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1, $j = 1; $i < 25; $i++) {

            DB::table('parking_spaces')->insert([
                'parking_id'        => $i,
                'parking_area'      => $j,
                'parking_possible'  => true
            ]);

            if($i % 6 == 0)
                $j++;
        }
    }
}

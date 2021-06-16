<?php

use Illuminate\Database\Seeder;

class FeeStatisticsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime2 = '2019-12-31';
        $dateTime2 = strtotime($dateTime2);
        $dateTime = date('Y-m-d', $dateTime2);

        for($i = 1; $i < 426; $i++) {

            $dateTime = strtotime($dateTime."+1 days");
            $dateTime = date('Y-m-d', $dateTime);

            DB::table('fee_statistics')->insert([
                'fee_id'            => $i,
                'fee_date'          => $dateTime,
                'fee_day'           => rand(5000, 20000)
            ]);
        }

    }
}

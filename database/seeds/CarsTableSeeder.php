<?php

use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $str = ['가', '나', '다', '라', '마',
            '거', '너', '더', '러', '머',
            '고', '노', '도', '로', '모',
            '구', '누', '두', '루', '무'];
        for ($i = 1; $i < 300; $i++) {
            $rand = rand(1, count($arr));
            $plate = rand(10, 99).$str[rand(0, 19)].rand(1000, 9999);
            $entryTime = $faker->dateTimeBetween('-1years', 'now');
            $exitTime = $faker->dateTimeInInterval($entryTime, '+3days');
            DB::table('cars')->insert([
                'car_id' => $i,
                'car_feeinfo'       => 1,
                'car_parking_id'    => null,
                'car_number_plate'  => $plate,
                'car_entry_time'    => $entryTime,
                'car_exit_time'     => $exitTime,
                'car_fee'           => null,
                'car_payment_type'  => null
            ]);
            $arr2 = array_splice($arr, $rand, 1);
        }
    }
}

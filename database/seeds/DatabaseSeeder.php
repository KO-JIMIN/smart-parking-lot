<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(FeeStatisticsTableSeeder::class);
        $this->call(Parking_spacesTableSeeder::class);
        $this->call(CarsTableSeeder::class);
    }
}

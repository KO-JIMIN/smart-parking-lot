<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id', true);
            $table->unsignedInteger('car_feeinfo');
            $table->unsignedInteger('car_parking_id')->nullable();
            $table->string('car_number_plate');
            $table->dateTime('car_entry_time');
            $table->dateTime('car_exit_time')->nullable();
            $table->unsignedInteger('car_fee')->nullable();
            $table->string('car_payment_type')->nullable();
            $table->foreign('car_feeinfo')->references('feeinfo_id')
                ->on('fee_information');
            $table->foreign('car_parking_id')->references('parking_id')
                ->on('parking_spaces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('=cars');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_spaces', function (Blueprint $table) {
            $table->unsignedInteger('parking_id', false);
            $table->unsignedInteger('parking_area');
            $table->boolean('parking_possible');
            $table->primary('parking_id');
            $table->foreign('parking_area')->references('area_id')
                ->on('parking_areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('=parking_spaces');
    }
}

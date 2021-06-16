<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model {
    protected $table = "cars";

    protected $primaryKey = 'car_id';

    public $timestamps = false;

    protected $fillable = ['car_exit_time', 'car_fee'];

    public function fee_information() {
        return $this->belongsTo(Fee_information::class, 'car_feeinfo');
    }

    public function parking_spaces() {
        return $this->belongsTo(Parking_spaces::class, 'car_parking_id');
    }
}

?>

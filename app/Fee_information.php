<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee_information extends Model {
    protected $table = "fee_information";

    protected $primaryKey = 'feeinfo_id';

    public $timestamps = false;

    protected $fillable = ['feeinfo_fee'];

    public function cars() {
        return $this->hasMany(Cars::class, 'car_feeinfo');
    }
}

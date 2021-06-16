<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking_areas extends Model {
    protected $table = "parking_areas";

    protected $primaryKey = 'area_id';

    public $timestamps = false;

    protected $fillable = ['area_empty_space'];

    public function parking_spaces() {
        return $this->hasMany(Parking_spaces::class, 'parking_area');
    }
}

?>

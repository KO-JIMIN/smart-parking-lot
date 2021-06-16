<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking_spaces extends Model {
    protected $table = "parking_spaces";

    protected $primaryKey = 'parking_id';

    public $timestamps = false;

    protected $fillable = ['parking_possible'];

    public function scopeGetEmptySpace($query, $area) {
        return $query->where('parking_area', '=', $area)
            ->where('parking_possible', '=', true);
    }

    public function parking_areas() {
        return $this->belongsTo(Parking_areas::class, 'parking_area');
    }

    public function cars() {
        return $this->hasMany(Cars::class, 'car_parking_id');
    }
}

?>

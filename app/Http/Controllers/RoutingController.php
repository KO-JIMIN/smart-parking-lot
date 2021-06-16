<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Parking_areas;
use App\Parking_spaces;
use Illuminate\Http\Request;

class RoutingController extends Controller {

    // 차량 주차 완료 시
    public function carParked(Request $request) {
        $parking_id      = $request->parking_id;
        $numberPlate     = $request->numberPlate;
        $parkingPossible = 0;

        $carParkingId = Cars::where('car_number_plate', '=', $numberPlate)
            ->get()
            ->toArray();

        if (count($carParkingId) == 0)
            return response(null, 403);

        $carParkingId = $carParkingId[0]['car_parking_id'];

        $parked = Cars::where('car_number_plate', '=', $numberPlate)
            ->update(['car_parking_id' => $parking_id]);

        // 주차 자리 변화에 따른 빈자리 업데이트
        if($parking_id == null) {
            $parkingArea = Parking_spaces::find($carParkingId)
                ->parking_areas
                ->toArray();

            Parking_areas::find($parkingArea['area_id'])
                ->update(['area_empty_space' => $parkingArea['area_empty_space'] + 1]);

            $parkingPossible = 1;
            Parking_spaces::find($carParkingId)
                ->update(['parking_possible' => 1]);
        } else {
            $parkingArea = Parking_spaces::find($parking_id)
                ->parking_areas
                ->toArray();

            Parking_areas::find($parkingArea['area_id'])
                ->update(['area_empty_space' => $parkingArea['area_empty_space'] - 1]);

            Parking_spaces::find($parking_id)
                ->update(['parking_possible' => 0]);
        }

        return response(null, 200);
    }
}

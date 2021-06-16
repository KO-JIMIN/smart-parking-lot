<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Parking_spaces;
use Illuminate\Http\Request;

class UserController extends Controller {
    // 주차장 빈자리 확인
    public function checkSpace() {
        $arr = array();

        $spaces = Parking_spaces::GetEmptySpace(1)->get();
        array_push($arr, count($spaces));

        $spaces = Parking_spaces::GetEmptySpace(2)->get();
        array_push($arr, count($spaces));

        $spaces = Parking_spaces::GetEmptySpace(3)->get();
        array_push($arr, count($spaces));

        $spaces = Parking_spaces::GetEmptySpace(4)->get();
        array_push($arr, count($spaces));

        // 빈 자리 수 배열로 반환
        return response(["emptySpace" => $arr], 200);
    }

    // 주차 위치 확인
    public function locationCar(Request $request) {
        $numberPlate = $request->numberPlate;
//        $numberPlate = "19노9078";

        // 중복 차량 방지
        // 출차하지 않은 차 중 해당 번호판 조회
        $locationCar = Cars::whereNull('car_exit_time')
            ->whereCar_number_plate($numberPlate)->get()->toArray();

        if(count($locationCar) == 0)
            return response(["locationCar" => "차가 없습니다"], 403);

        $area = Parking_spaces::find($locationCar[0]["car_parking_id"])
            ->parking_areas
            ->toArray()['area_name'];

        array_push($locationCar, $area);

        return response(["locationCar" => $locationCar], 200);

    }
}

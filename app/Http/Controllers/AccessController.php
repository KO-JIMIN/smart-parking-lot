<?php

namespace App\Http\Controllers;

use App\Fee_information;
use App\Cars;
use Illuminate\Http\Request;

class AccessController extends Controller {

    //입차시 새로운 차량 레코드 생성
    public function entryCar(Request $request) {

        $numberPlate = $request->numberPlate;

        // 해당차량이 이미 입차해 있으면 추가하지 않음
        $car = Cars::where('car_number_plate', '=', $numberPlate)
            ->whereNull('car_exit_time')
            ->get();

        if (count($car) > 0)
            return response("already in", 200);

        $newCar = new Cars();

        $newCar->car_feeinfo        = 1;
        $newCar->car_parking_id     = null;
        $newCar->car_number_plate   = $numberPlate;
        $newCar->car_entry_time     = date("y-m-d H:i:s");
        $newCar->car_exit_time      = null;
        $newCar->car_fee            = null;
        $newCar->car_payment_type   = null;

        $newCar->save();

        return response(null, 200);
    }

    // 새로운 차량이 디텍팅 되었을 때
    public function detectionNewCar() {
        //Cars 테이블의 마지막 레코드의 차량번호를 전송
        //(마지막으로 입차한 차)
        $newCarId = Cars::max('car_id');

        $newCar = Cars::find($newCarId);

        return response(["numberPlate" => $newCar->car_number_plate], 200);
    }

    //출차 시
    //결제 확인 후 처리
    //1. 결제 되었을 시
    //2. 결제가 되지 않았을 시
    public function exitCar(Request $request) {

        // 더미 버전 ( 결제 API 구현 전 테스트 ver )
        // 출차시 요금 계산후 업데이트 (내림계산)
        $numberPlate = $request->numberPlate;

        $exitCar = Cars::where('car_number_plate', '=', $numberPlate)
            ->whereNull('car_exit_time')->get();

        $feeInfo = Fee_information::find(1)->toArray()['feeinfo_fee'];

        $entryTime = $exitCar->toArray()[0]['car_entry_time'];
        $endTime = date("Y-m-d H:i:s");

        $timest = strtotime($endTime) - strtotime($entryTime);

        $parkingHour = ceil($timest / (60*60));

        $carFee = $parkingHour * $feeInfo;

        $exitCar = Cars::where('car_number_plate', '=', $numberPlate)
            ->whereNull('car_exit_time')
            ->update(['car_exit_time' => $endTime, 'car_fee' => $carFee]);

        return response(null, 200);
    }
}

?>

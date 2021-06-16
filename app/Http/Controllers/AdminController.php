<?php

namespace App\Http\Controllers;

use App\Fee_information;
use App\Cars;
use App\Fee_statistics;
use App\Parking_spaces;
use Illuminate\Http\Request;

class AdminController extends Controller {
    // 현재 주차장 상황
    public function liveSituation() {
        $arr = [];

        // 현재 주차 차량 수
        $parkedCars = Parking_spaces::where('parking_possible', '=', '0')
            ->get();
        array_push($arr, count($parkedCars));

        // 오늘 누적 주차 수
        $today = date("y-m-d")." 00:00:00";
        $todaysTotalCars = Cars::whereBetween('car_entry_time',
            [$today, date("y-m-d H:i:s")])
            ->get();
        array_push($arr, count($todaysTotalCars));

        // 오늘 매출
        $feeIdMax = Fee_statistics::max('fee_id');
        $feeToday = Fee_statistics::find($feeIdMax);
        array_push($arr, $feeToday->fee_day);

        return response(["liveSituation" => $arr], 200);
    }

    // 현재 주차 차량 정보 조회
    public function parkingList(Request $request) {
        $numberPlate = $request->numberPlate;

        $parkingList = Cars::whereNull('car_exit_time')
            ->whereNotNull('car_parking_id');

        if ($numberPlate == null) {
            $parkingList = $parkingList->get();
        } else {
            $parkingList = $parkingList->where('car_number_plate', '=', $numberPlate)
                ->get();
        }

        return response(["parkingList" => $parkingList], 200);
    }

    // 요금 그래프 조회
    public function feeGraph(Request $request) {
        //일주일, 1개월 단위는 위아래 버튼을 생성
        //3개월, 6개월은 이번달 제외하고 계산
        $startTime  = $request->startTime;
        $endTime    = $request->endTime;

        $feeList = Fee_statistics::whereBetween('fee_date', [$startTime, $endTime])
            ->get();
	    return response(["feeList" => $feeList], 200);
    }

    public function feeGraphWeek(Request $request) {
        $startTime  = $request->startTime;
        $endTime    = $request->endTime;

        $feeList = Fee_statistics::whereBetween('fee_date', [$startTime, $endTime])
            ->get()->toArray();

        $lengthOfArr = count($feeList);
        $sumArr = array();
        $sum = 0;

        for ($i = 0, $j = 0; $i < $lengthOfArr; $i++) {
            $sum += $feeList[$i]['fee_day'];
            if(($i + 1) % 7 == 0) {
                $sumArr[$j]['fee_start_date']   = $feeList[$i-6]['fee_date'];
                $sumArr[$j]['fee_end_date']     = $feeList[$i]['fee_date'];
                $sumArr[$j]['fee_day']          = $sum;
                $sum = 0;
                $j++;
            } else if($i + 1 == $lengthOfArr) {
                $sumArr[$j]['fee_start_date']   = $feeList[$i - ($i%7)]['fee_date'];
                $sumArr[$j]['fee_end_date']     = $feeList[$i]['fee_date'];
                $sumArr[$j]['fee_day']          = $sum;
            }
        }

        return response(["feeList" => $sumArr], 200);
    }

    public function feeGraphMonth(Request $request) {
        $startTime  = $request->startTime;
        $endTime    = $request->endTime;

        $feeList = Fee_statistics::whereBetween('fee_date', [$startTime, $endTime])
            ->get()->toArray();

        $nextMonth = date('Y-m', strtotime('next Month', strtotime($startTime)));
        $nextMonth = strtotime($nextMonth);

        $lengthOfArr = count($feeList);
        $sumArr = array();
        $sum = 0;
        $currentDate = $startTime;

        for($i = 0, $j = 0; $i < $lengthOfArr; $i++) {
            $roopDate    = strtotime($feeList[$i]['fee_date']);
            if($nextMonth == $roopDate) {
                $sumArr[$j]['fee_date']     = $currentDate;
                $sumArr[$j]['fee_day']      = $sum;
                $sum = 0;
                $currentDate    = $feeList[$i]['fee_date'];
                $nextMonth      = strtotime('next Month', $nextMonth);
                $j++;
            }

            $sum += $feeList[$i]['fee_day'];

            if($i + 1 == $lengthOfArr) {
                $sumArr[$j]['fee_date']     = $currentDate;
                $sumArr[$j]['fee_day']      = $sum;
            }
        }

        return response(["feeList" => $sumArr], 200);

    }

    // 전체 주차 차량 정보 조회
    public function totalCarList(Request $request) {
        $startTime  = $request->startTime;
        $endTime    = $request->endTime;
        $numberPlate = $request->numberPlate;

        // 시작시간, 끝시간 사이 레코드 쿼리
        // -> 그중 출차한 차만 가져옴
        if($startTime == $endTime) {
            $carList = Cars::whereBetween('car_entry_time',
                [$startTime." 00:00:00", $endTime." 23:59:59"]);
        } else {
            $carList = Cars::whereBetween('car_entry_time',
                [$startTime, $endTime]);
        }

        $carList = $carList->whereNotNull('car_exit_time');

        if ($numberPlate == null) {
            $carList = $carList->get();
        } else {
            $carList = $carList->where('car_number_plate', '=', $numberPlate)
                ->get();
        }

        return response(["totalCarList" => $carList], 200);
    }

    // 요금 정보 업데이트
    public function feeUpdate(Request $request) {
	    $fee = $request->feeInfo;

	    Fee_information::find(1)->update(['feeinfo_fee' => $fee]);

	    return response(null, 200);
    }

    // 요금 정보 조회
    public function searchFee () {

	    $fee = Fee_information::find(1)->toArray();

	    return response(["feeInfo" => $fee['feeinfo_fee']], 200);
    }

}

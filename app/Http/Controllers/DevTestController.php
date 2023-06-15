<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\TowerData;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RfidEmployeeLogs;

class DevTestController extends Controller
{

    public function test(Request $request)
    {
        $current = $request->current;
        
dd(calculateBMSCurrentForDhamrai2($current));
        // $this->calculateCurrentForDhamrai2($current);
        
             $rfid_employee_log = RfidEmployeeLogs::where('chipid', '30:83:98:7C:29:A8')
            ->where('door_closed_at', null)
            ->orderBy('id', 'DESC')
            ->first();
            
        if (!($rfid_employee_log) || ($rfid_employee_log == null)) {
            $access = 0;
            $error = 'rfid log not found';
        } else {
            $access = 1;
            $error = 'rfid log found';
        }
        
        return response()->json([
            
            'access'=>$access
            ]);
        $users = TowerData::select($arry)->orderBy('created_at','DESC')->paginate(20);
//        dd($users);
        return view('test.test', compact('users'));
    }
    public function DeviceData(Request $request)
    {

        $data = TowerData::orderBy('created_at','DESC')->paginate(10);

        return view('rms',compact('data'));
        $array1 = [
            'volotage',
            'current',
            'soc'
        ];

        $array2 = [
            '0' => 22,
            '1' => 23,
            '3' => 58
        ];

        $array2 = array_combine(array_values($array1), $array2);

// Output the modified array $array2
        dd($array2);
        ModL::create($array2);








        $tower_datas = $request->td;
        $tower_datas = array_filter(explode(',', $tower_datas), function ($value) {
            return $value != '';
        });

        $other_new_tower_datas = $request->new_td;
        $other_new_tower_datas = array_filter(explode(',', $other_new_tower_datas), function ($value) {
            return $value != '';
        });
        $alarms = $request->alarm;
        $alarms = array_filter(explode(',', $alarms), function ($value) {
            return $value != '';
        });
        $b = ['w','ws','w3','w4','w5','w6','w7','w8','w9','w0','w11','w12','w33','w34','w45','w23','w22','w23','w55','waa'];

        foreach ($tower_datas as $key => $value) {
            if (isset($b[$key - 1])) {
                $b[$key - 1] = $value;
            }
        }
        dd($b);

        dd($tower_datas);


        if (count($alarms)) {
            foreach ($alarms as $key => $alarm) {

            }
        }

        foreach ($tower_datas as $td) {

        }


    }
        public function calculateCurrentForDhamrai2($current){
        $decimal = $current;
        // 653.22
        $strlen= explode('.',$current);
        
        $decimal = str_replace('.', '', $decimal);
        
        // dump(strlen($rr[0]));
        //        return $decimal;
        // $hexNumber = dechex($decimal);
        if(strlen($strlen[0])>2){
            // Step 1: Determine the binary representation of the decimal number
            $binary = decbin(abs($decimal));

            // Step 2: If the decimal number is negative, convert its absolute value to binary
            $binary = ($decimal < 0) ? $binary : $binary;

            // Step 3: Pad the binary number with leading zeros to the desired length
            $desiredLength = 8; // Desired length of the binary number
            $binary = str_pad($binary, $desiredLength, '0', STR_PAD_LEFT);

            // Step 4: Invert all the bits of the binary number
            $invertedBinary = strtr($binary, '01', '10');

            // Step 5: Add 1 to the inverted binary number
            $twosComplementBinary = bindec($invertedBinary) + 1;

            // Step 6: Determine the sign of the decimal number
            $sign = ($binary[0] === '1') ? -1 : 1;

            // Step 7: Convert the binary number to its decimal representation, considering its sign
            $twosComplementDecimal = $sign * $twosComplementBinary;
            return $twosComplementDecimal / 10;
        }else{
            return $current;
        }
    }


}

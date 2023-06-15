<?php

namespace App\Http\Controllers;

use App\Models\RfidEmployeeInfo;
use App\Models\RfidEmployeeLogs;
use App\Models\Tower;
use App\Models\TowerAlarmData;
use App\Models\TowerAlarmInfo;
use App\Models\TowerData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function
    smuData(Request $request)
    {
        // return $request->all();
        $chipid = $request->chipid; //Tower Id
        $rfid = $request->rfid; //rfid_employee_infos
        $dor_sensor = $request->dore_sensor; //rfid_employee_infos
        $lock_sensor = $request->lock_sensor; //rfid_employee_infos

        // if rfid, dor_sensor-1, lock_sensor-1,chpid then Dore Open
        // if dor_sesor -1 lock-1 rifid-
        // Dore Open


        $access = 0;
        $dd = '';
        $tower = Tower::where('chipid', $chipid)->first();
        if (!$tower) {
            return response()->json([
                'ACCESS' => $access
            ]);
        }

        $employe_info = RfidEmployeeInfo::where('status', 1)->where('rfid', $rfid)->where('company_id', $tower->company_id)->first();


        if ($employe_info && $tower) {
            $latest_log = RfidEmployeeLogs::where('chipid', $chipid)->where('rfid_employee_id', $rfid)->latest()->first();
            if (($dor_sensor && $lock_sensor) && (!$latest_log || $latest_log->door_closed_at)) { //Dore Open
                $new_log = new RfidEmployeeLogs;
                $new_log->chipid = $chipid;
                $new_log->rfid_employee_id = $rfid;
                $new_log->punch_at = now();
                $new_log->door_open_at = now();
                $new_log->lock_open_at = now();
                $new_log->save();
                $access = 1;
                $dd = '($dor_sensor && $lock_sensor) && (!$latest_log || $latest_log->door_closed_at)';
            } elseif ($rfid) {
                $dd = '($rfid)';
                $access = 1;
            }
        } elseif (($tower && !$rfid) && ($dor_sensor && $lock_sensor)) {   //Dore close
            $dd = '($tower && !$rfid) && ($dor_sensor && $lock_sensor)';
            $latest_log = RfidEmployeeLogs::where('chipid', $chipid)->latest()->first();
            if ($latest_log && ($latest_log->door_closed_at == null)) {
                $dd = '(!$latest_log->door_closed_at)';
                $latest_log->door_closed_at = now();
                $latest_log->lock_closed_at = now();
                $latest_log->save();

                $access = 0;

                if ($latest_log->door_open_at && $latest_log->lock_closed_at) {
                    $s = Carbon::parse($latest_log->door_open_at);
                    $t = Carbon::parse($latest_log->lock_closed_at);
                    $diff = $s->diff($t);
                    $latest_log->dore_open_duration = $diff->format('%H:%I:%S');
                    $latest_log->save();
                    $access = 0;
                    $dd = '($latest_log->door_open_at && $latest_log->lock_closed_at)';
                }

            }
        } else {
            $access = 0;
            $dd = 'else()';
        }

        return response()->json([
            'ACCESS' => $access,
            'dd' => $dd,
        ]);
    }

    public function rmsData(Request $request)
    {
//        http://rms.test/api/rms?chipid=30:83:98:7C:29:A8&td=,0,12,144,1.02,15.25,25,7,50,25,11,12,45,12,14,&new_td=,&alarms=,0,1,0,1,1,0,0,0,;


        $tower = Tower::where('chipid', $request->chipid)->first();

        //Manipulating String To array
        $towerData = array_filter(explode(',', $request->td), function ($value) {
            return $value != '';
        });

        $alarmData = array_filter(explode(',', $request->alarms), function ($value) {
            return $value != '';
        });


        //Check if Tower Not found and TowerData must be 14 and AlarmData must be 8 .. If not found any of those then return false;
        if (!$tower || (count($towerData) != 14) || (count($alarmData) != 8)) {
            return response()->json([
                'success' => false
            ]);
        }

        // Tower Connected Time Update
        $tower->last_connected_at = now();
        $tower->save();


        //Array  Combine For Alarm  And TowerData
        $firstData = [
            'voltage_phase_a',
            'voltage_phase_b',
            'voltage_phase_c',
            'current_phase_a',
            'current_phase_b',
            'current_phase_c',
            'frequency',
            'power_factor',
            'cumilative_energy',
            'power',
            'dc_voltage',
            'tanent_load',
            'cumilative_dc_energy',
            'power_dc'
        ];
        $alarmKey = [
            'mains_fail',
            'dc_low_voltage',
            'module_fault',
            'llvd_fault',
            'smoke_alarm',
            'fan_fault',
            'high_tem',
            'door_alarm',
        ];
        $alarmDataArray = array_combine($alarmKey, $alarmData);
        $towerDataArray = array_combine($firstData, $towerData);


//        Alarm Modification START


        //mains_fail 1
        if (($alarmDataArray['mains_fail'] != 'n') && ($alarmDataArray['mains_fail'] == $tower->alarm_1)) {
            $alarmDataArray['mains_fail'] = 1;
            $alarmData[1] = 1;
//            return $alarmDataArray['mains_fail'];
        } else {
            $alarmDataArray['mains_fail'] = 0;
            $alarmData[1] = 0;
//            return $alarmDataArray['mains_fail'];
        }

        //Module Fault 3
        if (($alarmDataArray['module_fault'] != 'n') && ($alarmDataArray['module_fault'] == $tower->alarm_3)) {
            $alarmDataArray['module_fault'] = 1;
            $alarmData[3] = 1;
        } else {
            $alarmDataArray['module_fault'] = 0;
            $alarmData[3] = 0;
        }

        //Smoke Alarm 5
        if (($alarmDataArray['smoke_alarm'] != 'n') && ($alarmDataArray['smoke_alarm'] == $tower->alarm_5)) {
            $alarmDataArray['smoke_alarm'] = 1;
            $alarmData[5] = 1;
        } else {
            $alarmDataArray['smoke_alarm'] = 0;
            $alarmData[5] = 0;
        }

        //Fan Fault 6
        if (($alarmDataArray['fan_fault'] != 'n') && ($alarmDataArray['fan_fault'] == $tower->alarm_6)) {
            $alarmDataArray['fan_fault'] = 1;
            $alarmData[6] = 1;
        } else {
            $alarmDataArray['fan_fault'] = 0;
            $alarmData[6] = 0;
        }
        //High Temp 7
        if (($alarmDataArray['high_tem'] != 'n') && ($alarmDataArray['high_tem'] == $tower->alarm_7)) {
            $alarmDataArray['high_tem'] = 1;
            $alarmData[7] = 1;
        } else {
            $alarmDataArray['high_tem'] = 0;
            $alarmData[7] = 0;
        }

        //Door Alarm 8
        if (($alarmDataArray['door_alarm'] != 'n') && ($alarmDataArray['door_alarm'] == $tower->alarm_8)) {
            $alarmDataArray['door_alarm'] = 1;
            $alarmData[8] = 1;
        } else {
            $alarmDataArray['door_alarm'] = 0;
            $alarmData[8] = 0;
        }


        //LLVD Fault Check and Override the allarmData array value of key 4
        if (($towerDataArray['dc_voltage'] != 'n') && ($towerDataArray['dc_voltage'] <= $tower->llvd_fail_voltage_value)) {
            $alarmDataArray['llvd_fault'] = 1;
            $alarmData[4] = 1; //Update in alarm Data array key 4 for check llvd fault
            $towerDataArray['llvd_fail_voltage_value'] = $tower->llvd_fail_voltage_value;
        } else {
            $alarmDataArray['llvd_fault'] = 0;
            $alarmData[4] = 0; //Update in alarm Data array key 4 for check llvd fault
            $towerDataArray['llvd_fail_voltage_value'] = $tower->llvd_fail_voltage_value;
        }

        if (($towerDataArray['dc_voltage'] != 'n') && ($towerDataArray['dc_voltage'] <= $tower->dc_low_voltage_value)) {
            $alarmDataArray['dc_low_voltage'] = 1;
            $alarmData[2] = 1; //Update in alarm Data array key 2 for Dc Low Voltage
            $towerDataArray['dc_low_voltage_value'] = $tower->dc_low_voltage_value;
        } else {
            $alarmDataArray['dc_low_voltage'] = 0;
            $alarmData[2] = 0; //Update in alarm Data array key 2 for Dc Low Voltage
            $towerDataArray['dc_low_voltage_value'] = $tower->dc_low_voltage_value;
        }
//        Alarm Modification end


        //Array Marge.. (TowerData and AlarmData) for Update in tower_data Table
        $updateTowerData = $alarmDataArray + $towerDataArray;


        //Find out first Tenant of This current Tower and update tenant id and name with check Power Slab
        $updateTowerData['power_slab'] = 0;
        $first_tenant = $tower->firstTowerWiseTanent();
        if ($first_tenant) {
            if (($updateTowerData['power_dc'] != 'n') && ($updateTowerData['power_dc'] > $first_tenant->max_load)) { ///Working from Tower.. Before "teant_load" After power_dc
                $updateTowerData['power_slab'] = 1;
                $updateTowerData['power_consume_total'] = $updateTowerData['power_dc'] - $first_tenant->max_load;

            }
            $updateTowerData['tenant_name'] = $first_tenant->tenant_name;
            $updateTowerData['tenant_id'] = $first_tenant->id;
        }

       //BMS Data Start
        $bms_data_key=[
            'current',
            'voltage_of_pack',
            'soc',
            'soh',
            'cell_voltage_1',
            'cell_voltage_2',
            'cell_voltage_3',
            'cell_voltage_4',
            'cell_voltage_5',
            'cell_voltage_6',
            'cell_voltage_7',
            'cell_voltage_8',
            'cell_voltage_9',
            'cell_voltage_10',
            'cell_voltage_11',
            'cell_voltage_12',
            'cell_voltage_13',
            'cell_voltage_14',
            'cell_voltage_15',
            'cell_temperature_1',
            'cell_temperature_2',
            'cell_temperature_3',
            'cell_temperature_4'
        ];

        if($request->bms){
            $bms_data = array_filter(explode(',', $request->bms), function ($value) {
                return $value != '';
            });
            if(count($bms_data) == 23){
                $bmsDataArray = array_combine($bms_data_key, $bms_data);

                //This Modification For ABHT PoC Dhamrai-2 (DHDHM59)  Start
                if($tower->id == 22){
                    $bmsDataArray['current'] = calculateBMSCurrentForDhamrai2($bmsDataArray['current']);
                }
                 //This Modification For ABHT PoC Dhamrai-2 (DHDHM59)  End
                $updateTowerData = $updateTowerData + $bmsDataArray;
            }
        }

        //BMS Data End


        //Store Row TowerData
        $td = new TowerData;
        $td->chipid = $request->chipid;
        $td->tower_id = $tower->id;
        $td->tower_name = $tower->name;
        $td->siteid = $tower->mno_site_id;
        $td->tower_data = $request->td;
        $td->bms = $request->bms ?: null ;
        $td->other_tower_data = $request->new_td;
        $td->alarms = $request->alarms;
        $td->save();

        //Update meaningful TowerData and alarm data
        $td->update($updateTowerData);

        //Alarm Duration Check START
        $prv_id = TowerData::where('chipid', $td->chipid)
            ->where('id', '!=', $td->id)
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->latest()
            ->first();

        if ($prv_id) {
            $date1 = Carbon::parse($prv_id->created_at);
            $date2 = Carbon::parse($td->created_at);

            //Mains Fail
            if ($prv_id->mains_fail == $td->mains_fail) {
                $td->mains_fail_duration = $date1->diffInSeconds($date2);
            }

            //DC Low Voltage
            if ($prv_id->dc_low_voltage == $td->dc_low_voltage) {
                $td->dc_low_voltage_duration = $date1->diffInSeconds($date2);
            }

            //Module Fail
            if ($prv_id->module_fault == $td->module_fault) {
                $td->module_fault_duration = $date1->diffInSeconds($date2);
            }
            //LLVD Fail
            if ($prv_id->llvd_fault == $td->llvd_fault) {
                $td->llvd_fail_duration = $date1->diffInSeconds($date2);
            }

            //Power Slab Duration
            if ($prv_id->power_slab == $td->power_slab) {
                $td->power_slab_duration = $date1->diffInSeconds($date2);
            }


            //Smoke Alarm Duration
            if ($prv_id->smoke_alarm == $td->smoke_alarm) {
                $td->smoke_alarm_duration = $date1->diffInSeconds($date2);
            }
            //Fan Fault Duration
            if ($prv_id->fan_fault == $td->fan_fault) {
                $td->fan_fault_duration = $date1->diffInSeconds($date2);
            }
            //High Temp Duration
            if ($prv_id->high_tem == $td->high_tem) {
                $td->high_temp_alarm_duration = $date1->diffInSeconds($date2);
            }
            //High Temp Duration
            if ($prv_id->door_alarm == $td->door_alarm) {
                $td->door_open_alarm_duration = $date1->diffInSeconds($date2);
            }


        }

        //Alarm Duration Check START


        $td->save();


        //Alarm Check Start
        foreach ($alarmData as $key => $value) {
            $tai = TowerAlarmInfo::where('alarm_numbers', $key)
                ->where('active', true)
                ->first();

            $source = '';
            if ($tai) { // smoke Alarm Start


                if ($key == 1 || $key == 2 || $key == 3 || $key == 4) {
                    $source = 'ac_dc';
                }
                if ($key == 5 || $key == 6 || $key == 7 || $key == 8) {
                    $source = 'digital_input';
                }

                $prev_alarm = TowerAlarmData::where('tower_id', $tower->id)
                    ->whereLive(1)
                    ->where('alarmable_table_name', $source)
                    ->where('tower_alarm_info_id', $tai->id)
                    ->where('alarm_number', $key)
                    ->latest()
                    ->first();

                if ($value == 1) {
                    if (!$prev_alarm) {
                        $prev_alarm = new TowerAlarmData;
                        $prev_alarm->tower_data_id = $td->id;
                        $prev_alarm->tower_alarm_info_id = $tai->id;
                        $prev_alarm->tower_id = $tower->id;
                        $prev_alarm->chipid = $tower->chipid;
                        $prev_alarm->company_id = $tower->company_id;
                        $prev_alarm->alarmable_table_name = $source;
                        $prev_alarm->alarm_category = $tai->category;
                        $prev_alarm->alarm_title = $tai->title;
                        $prev_alarm->alarm_number = $key;
                        $prev_alarm->alarm_started_at = $td->created_at;
                        $prev_alarm->alarm_ended_at = $td->created_at;
                        $prev_alarm->created_at = $td->created_at;
                        $prev_alarm->save();

                    } else {
                        $prev_alarm->alarm_ended_at = $td->created_at;
                        $prev_alarm->save();

                    }
                } else {
                    if ($prev_alarm) {
                        $prev_alarm->alarm_ended_at = $td->created_at;
                        $prev_alarm->live = 0;
                        $prev_alarm->save();
                    }
                }

            }


        }


        //Check RFID Access. if admin give a permission to open door then we will findout the rfid user and send response [Access = true]  to the device.  TODO
        $access = 0;
        if ($tower->smu_lock) {
            $rfid_employee_log = RfidEmployeeLogs::where('chipid', $request->chipid)
                ->where('door_closed_at', null)
                ->where('request_count', 0)
                ->orderBy('id', 'DESC')
                ->select('id','request_count')
                ->first();
            if ($rfid_employee_log) {
                $access =1;
                $rfid_employee_log->request_count = 1;
                $rfid_employee_log->save();
            }
        }





        return response()->json([
            'success' => true,
            // 'tower_data' => $td->tower_data,
            // 'other_tower_data' => $td->other_tower_data,
            // 'alarms' => $td->alarms,
            // 'inserted_id' => $td->id,
            // 'chipid' => $td->chipid,
             'access' => $access,
//            'rfid' => $rfid?:0,
            'message' => now()
        ]);

    }

    // public function calculateCurrentForDhamrai2($current){
    //     $decimal = $current;
    //     // 653.22
    //     $decimal = str_replace('.', '', $decimal);
    //     //        return $decimal;

    //     // Step 1: Determine the binary representation of the decimal number
    //     $binary = decbin(abs($decimal));

    //     // Step 2: If the decimal number is negative, convert its absolute value to binary
    //     $binary = ($decimal < 0) ? $binary : $binary;

    //     // Step 3: Pad the binary number with leading zeros to the desired length
    //     $desiredLength = 8; // Desired length of the binary number
    //     $binary = str_pad($binary, $desiredLength, '0', STR_PAD_LEFT);

    //     // Step 4: Invert all the bits of the binary number
    //     $invertedBinary = strtr($binary, '01', '10');

    //     // Step 5: Add 1 to the inverted binary number
    //     $twosComplementBinary = bindec($invertedBinary) + 1;

    //     // Step 6: Determine the sign of the decimal number
    //     $sign = ($binary[0] === '1') ? -1 : 1;

    //     // Step 7: Convert the binary number to its decimal representation, considering its sign
    //     $twosComplementDecimal = $sign * $twosComplementBinary;


    //     return $twosComplementDecimal / 10;
    // }


}

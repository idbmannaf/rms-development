<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

use App\Models\ActiveDevice;
use App\Models\Company;
use App\Models\RfidEmployeeInfo;
use App\Models\Tower;
use App\Models\TowerAlarmData;
use App\Models\TowerData;
use App\Exports\CompanyTowersStatusExport;
use App\Exports\RmsDataExport;
use App\Exports\BmsDataExport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CompanyTowerDataController extends Controller
{

    public function companyTowerAlarms(Company $company)
    {
        menuSubmenu('alarmsAll', request()->title);
        if (request()->status and (request()->status == 'live')) {
            $towerAlarmDatas = TowerAlarmData::where('company_id', $company->id)
                ->whereLive(1)
                ->orderBy('alarm_category')
                ->orderBy('alarm_title')
                ->paginate(20);
            // dd($towerAlarmDatas);
        } elseif (request()->status and (request()->status == 'history')) {
            $towerAlarmDatas = TowerAlarmData::where('company_id', $company->id)
                ->whereLive(0)
                ->orderBy('alarm_category')
                ->orderBy('alarm_title')
                ->paginate(20);
        } elseif (request()->title) {
            $towerAlarmDatas = TowerAlarmData::where('company_id', $company->id)
                ->where('alarm_title', request()->title)
                ->orderBy('live', 'desc')
                ->orderBy('alarm_category')
                ->orderBy('alarm_title')
                ->paginate(20);
        } else {
            $towerAlarmDatas = TowerAlarmData::where('company_id', $company->id)
                ->orderBy('live', 'desc')
                ->orderBy('alarm_category')
                ->paginate(20);
        }


        $towerAlarmDatas->appends(request()->all());

        return view('company.towerAlarm.companyTowerAlarms', [
            'towerAlarmDatas' => $towerAlarmDatas,
            'company' => $company
        ]);
    }

    public function companyTowerAlarmDetails(Company $company, TowerAlarmData $alarm)
    {

        $towerAlarmDatas = TowerAlarmData::where('company_id', $company->id)
            ->where('tower_id', $alarm->tower_id)
            ->where('alarm_number', $alarm->alarm_number)
            ->orderBy('live', 'desc')
            ->orderBy('alarm_category')
            ->orderBy('alarm_started_at','desc')
            ->paginate(20);
            // dd($towerAlarmDatas);

        return view('company.towerAlarm.companyTowerAlarmDetails', [
            'alarm' => $alarm,
            'company' => $company,
            'towerAlarmDatas' => $towerAlarmDatas
        ]);
    }


    public function companyWiseTower(Request $request, $company)
    {
        menuSubmenu('rms', $request->status ? $request->status . "Rms" : 'allRms');
        $data = [];
        $paginate = 100;

        $data['company'] = Company::where('id', $company)->first();

        if ($request->status and $request->status == 'online') {
            $data['items'] = $items = Tower::where('company_id', $company)
                ->where('last_connected_at', '>', now()->subMinutes(4))
                ->orderBy('id', "DESC")
                ->paginate($paginate);
        } elseif ($request->status and $request->status == 'offline') {

            $data['items'] = $items = Tower::where('company_id', $company)
                ->where('last_connected_at', '<', now()->subMinutes(4))
                ->orderBy('id', "DESC")
                ->paginate($paginate);
        } else {
            $data['items'] = $items = Tower::where('company_id', $company)->orderBy('id', "DESC")->with('accessuserDoorOpen')->paginate($paginate);
        }

        //  return $items;
        $employeeIds = RfidEmployeeInfo::where('company_id', $company)->pluck('rfid');


        return view("company.tower.company_wise_tower", $data)
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function companyWiseTowerSingleDetails($chipid)
    {
        $data = [];
        $data['chipid'] = $chipid;
        $data['tower'] = $tower = Tower::where('chipid', $chipid)->first();
        $data['toweritems'] = $toweritems = TowersItems::where('tower_id', $tower->id)->with('lastTowerDatasUpdate')->get();
        $towerDatas = TowerData::where('chipid', $chipid)->groupBy('relation_id')->orderBy('id', 'DESC')->first();
        $data['towerDatas'] = TowerData::where('relation_id', $towerDatas->relation_id)->where('tower_item_id', '!=', 0)->groupBy('unique_id')->orderBy('tower_item_id', 'ASC')->get();
        $data['company'] = Company::where('id', $tower->company_id)->first();
        // return  $data['towerDatas'] ;

        return view('company.tower.company_wise_tower_single_data_details', $data);
    }

    public function towerDataDetailsChipidItemIdRelationID(Request $request, $toweritem, $relationid)
    {


        $data['towerdatas'] = $towerdatas = TowerDatas::where(['tower_item_id' => $toweritem, 'relation_id' => $relationid])->groupBy('unique_id')->orderBy('unique_id', 'ASC')->get();
        $data['towerDateTime'] = TowerDatas::where(['tower_item_id' => $toweritem, 'relation_id' => $relationid])->first();
        $data['toweritem'] = $toweritem = TowersItems::where('id', $toweritem)->first();

        $data['tower'] = $item = Towers::where('id', $toweritem->tower_id)->first();
        $data['company'] = $company = Company::where('id', $item->company_id)->first();

        //return $towerdatas;
        return view('company.tower.tower_item_wise_tower_data_details', $data);
    }


    public function companyWiseTowerItemDetails($tower)
    {
        $data = [];
        $data['tower'] = $item = Towers::where('id', $tower)->first();
        $data['toweritems'] = $toweritems = TowersItems::where('tower_id', $tower)->with('lastTowerDatasUpdate')->get();
        $data['company'] = $company = Company::where('id', $item->company_id)->first();
        //return $toweritems;
        return view('company.tower.tower_wise_device_details', $data);
    }

    public function companyWiseTowerItemCommand(Request $request, $toweritemid)
    {
        $data = [];
        $data['pages'] = "";
        $data['to'] = "";
        $data['from'] = "";
        $data['tower_id'] = "";
        $data['toweritem'] = $toweritem = TowersItems::with('towerDatas')->find($toweritemid);
        $data['tower'] = $tower = Towers::where('id', $toweritem->tower_id)->select('id', 'company_id', 'name', 'last_connected_at')->first();
        $data['company'] = $company = Company::where('id', $tower->company_id)->first();
        $data['towerItemCommands'] = $towerItemCommands = TowerItemsCommands::
        where(['tower_item_id' => $toweritemid, 'chipid' => $toweritem->chipid])
            //->with('groupDatas')
            ->get();

        $paginate = 20;
        $data['towerdatas'] = $towerdatas = TowerDatas::where(['tower_item_id' => $toweritemid, 'chipid' => $toweritem->chipid])
            ->groupBy('relation_id')
            ->orderBy('created_at', 'DESC')
            ->paginate($paginate);

        return view('company.tower.toweritem_wise_itemcommand_details', $data)
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
        //return $company;
    }

    public function companyWiseTowerDataFiltering(Request $request, $company)
    {
        $data = [];
        $data['pages'] = "";
        $data['to'] = "";
        $data['from'] = "";
        $data['tower_id'] = "";
        //  $data['company'] = $company;
        $data['tower'] = $tower = Towers::where('company_id', $company)->with('towerdatas')->first();
        // return $tower;
        $data['towers'] = Towers::where('company_id', $company)->get();
        $data['company'] = Company::where('id', $tower->company_id)->first();
        //return $sarbsrectifires;

        return view('company.tower.tower_data_filter', $data);
    }

    public function companyWiseTowerDigitalInputData(Company $company, Towers $tower)
    {
        $data = [];

        $data['company'] = $company;
        $data['tower'] = $tower;
        $data['items'] = $tower->dgInputData()->orderBy('created_at', 'desc')->paginate(20);

        return view('company.tower.digital_input_data', $data);
    }

    public function companyWiseTowerDigitalInputDataAlarms(Company $company)
    {
        $data = [];

        $data['company'] = $company;

        $data['items'] = TowerDigitalInputDatas::whereIn('tower_id', Towers::where('company_id', $company->id)->pluck('id'))
            ->groupBy('tower_id')
            ->latest()
            ->where('created_at', '>', now()->subMinutes(4))
            ->paginate(20);

        return view('company.tower.digital_input_data_alarms', $data);
    }


    public function activeDevices(Company $company, Tower $tower)
    {

        $active_devices = ActiveDevice::with('device')->where('tower_id', $tower->id)->get();
//        foreach ($active_devices as $active_device){
//            $td = TowerData::select(explode(',',$active_device->active_column))->latest()->first();
//            dd($td);
//        }
        return view('company.tower.active_device.index', compact('active_devices', 'tower', 'company'));
    }

    public function activeDeviceDetails(Company $company, Tower $tower, ActiveDevice $active_device)
    {


        $data = TowerData::where('tower_id',$tower->id)->select(explode(',', $active_device->active_column))->orderBy('created_at')->paginate(10);
        return view('company.tower.active_device.details', compact('active_device', 'tower', 'company', 'data'));
    }
    public function rmsDataExport(Request $request,Company $company, Tower $tower)
    {
        $siteId = $tower->mno_site_id;
        if($request->type == 'rms'){
           $td= TowerData::where('tower_id',$tower->id)
            ->join("towers", "towers.id", "=", "tower_data.tower_id")
            ->join('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
            ->select(
                "tower_data.created_at"
                ,"upazilas.name as upazila"
                ,"towers.mno_site_id as siteid"
                ,"tower_data.voltage_phase_a"
                ,"tower_data.voltage_phase_b"
                ,"tower_data.voltage_phase_c"
                ,"tower_data.current_phase_a"
                ,"tower_data.current_phase_b"
                ,"tower_data.current_phase_c"
                ,"tower_data.frequency"
                ,"tower_data.power_factor"
                ,"tower_data.cumilative_energy"
                ,"tower_data.power"
                ,"tower_data.dc_voltage"
                ,"tower_data.tanent_load"
                ,"tower_data.cumilative_dc_energy"
                ,"tower_data.power_dc"
                ,"tower_data.tenant_name"
                )
            ->orderBy('tower_data.created_at', "DESC")
            ->take($request->row)
            ->get();
            return Excel::download(new RmsDataExport($td), 'rms_data_of_'.$siteId.'.xlsx');
        }
        if($request->type == 'bms'){
           $td= TowerData::where('tower_id',$tower->id)
            ->join("towers", "towers.id", "=", "tower_data.tower_id")
            ->join('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
            ->select(
                        "tower_data.created_at",
                        "upazilas.name as upazila",
                        "towers.mno_site_id as siteid",
                        'tower_data.current',
                        'tower_data.voltage_of_pack',
                        'tower_data.soc',
                        'tower_data.soh',
                        'tower_data.cell_voltage_1',
                        'tower_data.cell_voltage_2',
                        'tower_data.cell_voltage_3',
                        'tower_data.cell_voltage_4',
                        'tower_data.cell_voltage_5',
                        'tower_data.cell_voltage_6',
                        'tower_data.cell_voltage_7',
                        'tower_data.cell_voltage_8',
                        'tower_data.cell_voltage_9',
                        'tower_data.cell_voltage_10',
                        'tower_data.cell_voltage_11',
                        'tower_data.cell_voltage_12',
                        'tower_data.cell_voltage_13',
                        'tower_data.cell_voltage_14',
                        'tower_data.cell_voltage_15',
                        'tower_data.cell_temperature_1',
                        'tower_data.cell_temperature_3',
                        'tower_data.cell_temperature_4'
                )
            ->orderBy('tower_data.created_at', "DESC")
            ->take($request->row)
            ->get();
            return Excel::download(new BmsDataExport($td), 'bms_data_of_'.$siteId.'.xlsx');
        }
        if($request->type == 'tower'){
            $td = Tower::where('company_id', $company->id)
                ->join('tower_data', function ($join) {
                    $join->on('towers.id', '=', 'tower_data.tower_id')
                        ->where('tower_data.created_at', function ($query) {
                            $query->select(DB::raw('MAX(created_at)'))
                                ->from('tower_data')
                                ->whereColumn('tower_id', 'towers.id');
                        });
                })
                ->join('upazilas', 'upazilas.id', '=', 'towers.upazila_id')
                ->orderBy('towers.id', "DESC")
                ->select(
                    'towers.id',
                    'towers.last_connected_at',
                    'towers.name',
                    'towers.mno_site_id',
                    'towers.company_id',
                    'tower_data.mains_fail',
                    'tower_data.dc_low_voltage',
                    'tower_data.module_fault',
                    'tower_data.llvd_fault',
                    'tower_data.smoke_alarm',
                    'tower_data.fan_fault',
                    'tower_data.high_tem',
                    'tower_data.door_alarm',
                    'upazilas.name as upazila_name'
                )
            ->orderBy('towers.name', "DESC")
            ->get();
            dd($td);

            return Excel::download(new BmsDataExport($td), 'bms_data_of_'.$siteId.'.xlsx');
        }
    }
    public function companyTowerStatusExport(Request $request,Company $company)
    {

            $td = Tower::where('company_id', $company->id)
                ->join('tower_data', function ($join) {
                    $join->on('towers.id', '=', 'tower_data.tower_id')
                        ->where('tower_data.created_at', function ($query) {
                            $query->select(DB::raw('MAX(created_at)'))
                                ->from('tower_data')
                                ->whereColumn('tower_id', 'towers.id');
                        });
                })
                ->join('upazilas', 'upazilas.id', '=', 'towers.upazila_id')
                ->orderBy('towers.id', "DESC")
                ->select(
                    'towers.last_connected_at',
                    'towers.name',
                    'towers.mno_site_id',
                    'upazilas.name as upazila_name',
                    'tower_data.mains_fail',
                    'tower_data.dc_low_voltage',
                    'tower_data.module_fault',
                    'tower_data.llvd_fault',
                    'tower_data.smoke_alarm',
                    'tower_data.fan_fault',
                    'tower_data.high_tem',
                    'tower_data.door_alarm'
                )
            ->orderBy('towers.name', "DESC")
            ->get();

            return Excel::download(new CompanyTowersStatusExport($td), 'towers_status.xlsx');

    }

}

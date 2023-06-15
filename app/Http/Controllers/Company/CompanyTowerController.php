<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyTenant;
use App\Models\District;
use App\Models\Division;
use App\Models\RfidEmployeeInfo;
use App\Models\RfidEmployeeLogs;
use App\Models\Tower;
use App\Models\TowerAlarmData;
use App\Models\TowerData;
use App\Models\TowerWiseTenant;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompanyTowerController extends Controller
{
    public function lists(Company $company, Request $request)
    {
        menuSubmenu('company-towers', 'allRms');
        $data = [];
        $paginate = 100;
        $data['company'] = $company;
        $data['status'] = $request->status ?: '';
        if ($request->status and $request->status == 'online') {
            $data['towers'] = $items = Tower::where('company_id', $company->id)
                ->join('tower_data', function ($join) {
                    $join->on('towers.id', '=', 'tower_data.tower_id')
                        ->where('tower_data.created_at', function ($query) {
                            $query->select(DB::raw('MAX(created_at)'))
                                ->from('tower_data')
                                ->whereColumn('tower_id', 'towers.id');
                        });
                })
                ->join('upazilas', 'upazilas.id', '=', 'towers.upazila_id')
                ->where('last_connected_at', '>', now()->subMinutes(4))
                ->orderBy('id', "DESC")
                ->select(
                    'towers.smu_lock',
                    'towers.has_bms',
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
                ->paginate($paginate);
            menuSubmenu('company-towers', 'onlineRms');
        } elseif ($request->status and $request->status == 'offline') {
            $data['towers'] = $items = Tower::where('towers.company_id', $company->id)
                ->join('tower_data', function ($join) {
                    $join->on('towers.id', '=', 'tower_data.tower_id')
                        ->where('tower_data.created_at', function ($query) {
                            $query->select(DB::raw('MAX(created_at)'))
                                ->from('tower_data')
                                ->whereColumn('tower_id', 'towers.id');
                        });
                })
                    ->join('upazilas', 'upazilas.id', '=', 'towers.upazila_id')
                ->where(function($q){
                    $q->where('towers.last_connected_at', '<', now()->subMinutes(4));
                    $q->orWhere('towers.last_connected_at', null);
                })
                ->orderBy('id', "DESC")
                ->select(
                    'towers.smu_lock',
                    'towers.has_bms',
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
                ->paginate($paginate);
            menuSubmenu('company-towers', 'offlineRms');
        } else {
            $data['towers'] = $items = Tower::where('company_id', $company->id)
                ->join('tower_data', function ($join) {
                    $join->on('towers.id', '=', 'tower_data.tower_id')
                        ->where('tower_data.created_at', function ($query) {
                            $query->select(DB::raw('MAX(created_at)'))
                                ->from('tower_data')
                                ->whereColumn('tower_id', 'towers.id');
                        });
                })
                ->join('upazilas', 'upazilas.id', '=', 'towers.upazila_id')
                ->orderBy('id', "DESC")
                ->select(
                    'towers.smu_lock',
                    'towers.has_bms',
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
                ->paginate($paginate);
        }
//        dd($items);

        return view('company.tower.index', $data)
            ->with('i', ($request->input('page', 1) - 1) * $paginate);;
    }

    public function active(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('towers')->where('id', $request->id)->update(['active' => 1]);
        } else {
            DB::table('towers')->where('id', $request->id)->update(['active' => 0]);
        }
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    public function create(Company $company)
    {
        menuSubmenu('company-towers', 'create-company-towers');
        return view('company.tower.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
//        return $request->all();

        $this->validate($request, [
            'name' => 'required|string',
            'chipid' => 'unique:towers,chipid',
            'sim_number' => 'nullable',
            'address' => 'nullable|string',
        ]);

        $tower = new Tower();
        $tower->company_id = $company->id;
        $tower->name = $request->name;
        $tower->chipid = $request->chipid;
        $tower->sim_number = $request->sim_number;
        $tower->address = $request->address;
        $tower->save();
        activity()->log('Tower Created');
        return redirect()->route('tower.lists', $company)->with('success', 'Successfully created tower');

    }

    public function edit(Company $company, Tower $tower)
    {
        $data['tower'] = Tower::with(['company.clusters','company.regions','company.vendors'])->find($tower->id);
        $data['company'] = $company;
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['thanas'] = Upazila::all();
        $data['companytenants'] = $companytenants = CompanyTenant::where("company_id", $tower->company_id)->get();
        $data['towertenant'] = $towertenant = TowerWiseTenant::where("tower_id", $tower->id)->get();

        return view('company.tower.edit', $data);
    }

    public function update(Request $request, Company $company, Tower $tower)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'chipid' => 'unique:towers,chipid,' . $tower->id,
            'sim_number' => 'nullable',
            'address' => 'nullable|string',

        ]);
        $tower->name = $request->name;
        $tower->chipid = $request->chipid;
        $tower->sim_number = $request->sim_number;
        $tower->address = $request->address;
        $tower->division_id = $request->division;
        $tower->district_id = $request->district;
        $tower->upazila_id = $request->thana;
        $tower->mno_site_id = $request->mno_site_id ?? null;
        $tower->ftb_site_id = $request->ftb_site_id ?? null;

        $tower->region_id = $request->region ?: $tower->region_id;
        $tower->zone_id = $request->zone ?: $tower->zone_id;
        $tower->sitecode_id = $request->sitecode ?: $tower->sitecode_id;
        $tower->cluster_id = $request->cluster ?: $tower->cluster_id;
        $tower->vendor_id = $request->vendor ?: $tower->vendor_id;

        $tower->dc_low_voltage_value = $request->dc_low_voltage_value;
        $tower->llvd_fail_voltage_value = $request->llvd_fail_voltage_value;

        $tower->save();

        if ($request->max_loard != "" && $request->con == 1) {
            foreach ($request->max_loard as $ten => $val) {
                $tTena = new TowerWiseTenant;
                $tTena->tower_id = $tower->id;
                $tTena->chipid = $request->chipid;
                $tTena->company_id = $company->id;
                $tTena->tenant_id = $request->tenant_id[$ten];
                $c_teanant = CompanyTenant::find($tTena->tenant_id);
                if ($c_teanant) {
                    $tTena->tenant_name = $c_teanant->title;
                }
                $tTena->max_load = $request->max_loard[$ten];
                $tTena->save();
            }
        } else {
            if ($request->max_loard != "" && $request->con == 0) {
                $ids = $request->ttid;
                foreach ($request->ttid as $ten => $val) {
                   $prev_tenent =  TowerWiseTenant::find($val);
                    $prev_tenent->tower_id = $tower->id;
                    $prev_tenent->chipid = $request->chipid;
                    $prev_tenent->company_id = $company->id;
                    $prev_tenent->tenant_id = $request->tenant_id[$ten];
                    $c_teanant = CompanyTenant::find($prev_tenent->tenant_id);
                    if ($c_teanant) {
                        $prev_tenent->tenant_name = $c_teanant->title;
                    }
                    $prev_tenent->max_load = $request->max_loard[$ten];
                    $prev_tenent->save();
//
//                        ->update([
//                            'tower_id' => $tower->id,
//                            // 'company_id' => $request->company_id,
//                            'chipid' => $request->chipid,
//                            'tenant_id' => $request->tenant_id[$ten],
//                            'max_load' => $request->max_loard[$ten],
//                        ]);
                }
            }
        }


        return redirect()->route('tower.lists', $company)->with('success', 'Successfully updated tower');

    }

    public function destroy(string $company_id, $id)
    {
        Tower::DestroyTower($id);
        return redirect()->route('tower.lists', $company_id)->with('success', 'Successfully deleted tower');

    }
    public function towerWiseRmsData(Company $company, Tower $tower){

        $data['company'] = $company;
        $data['tower'] = $tower;
        $data['datas'] = TowerData::where('tower_id',$tower->id)
            ->join("towers", "towers.id", "=", "tower_data.tower_id")
            ->join('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
            ->select(
                 "upazilas.name as upazila"
                ,"towers.mno_site_id as siteid"
                ,"tower_data.tower_name"
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
                ,"tower_data.created_at")
            ->orderBy('tower_data.created_at', "DESC")
            ->paginate(15);
        return view('company.tower.rms_data',$data);
    }
    public function towerWiseAlarmData(Company $company, Tower $tower){
        $data['company'] = $company;
        $data['tower'] = $tower;

        $data['datas'] = TowerAlarmData::with('tower')->where('tower_id',$tower->id)
            ->orderBy('live', "DESC")
            ->paginate(15);

        return view('company.tower.alarms',$data);
    }
    public function towerWiseSMUData(Company $company, Tower $tower){

        $data['company'] = $company;
        $data['tower'] = $tower;
        $data['employees'] = RfidEmployeeInfo::where('company_id', $company->id)->where('status', 1)->get();
        $data['datas'] = RfidEmployeeLogs::where('chipid',$tower->chipid)
            ->orderBy('created_at', "DESC")
            ->paginate(15);

        return view('company.tower.smu',$data);
    }
    public function towerWiseBMSData(Company $company, Tower $tower){

        $data['company'] = $company;
        $data['tower'] = $tower;
        $data['data'] = TowerData::where('tower_id', $tower->id)
        ->select(
            'created_at',
            'chipid',
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
            )
            ->orderBy('created_at','DESC')
            ->paginate(20);


        return view('company.tower.bms_data',$data);
    }


}

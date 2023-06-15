<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyTenant;
use App\Models\District;
use App\Models\Division;
use App\Models\Tower;
use App\Models\TowerWiseTenant;
use App\Models\Upazila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        menuSubmenu('admin-company-towers','admin-company-towers');
        $paginate = 100;
        $data['status'] = $request->status ?: '';
        if ($request->status and $request->status == 'online') {
            $data['towers'] = $items = Tower::with('division', 'district', 'upazila')
                ->where('last_connected_at', '>', now()->subMinutes(4))
                ->orderBy('id', "DESC")
                ->paginate($paginate);

            menuSubmenu('admin-company-towers', 'adminOnlineRms');
        } elseif ($request->status and $request->status == 'offline') {

            $data['towers'] = $items = Tower::with('division', 'district', 'upazila')
                ->where(function($q){
                    $q->where('last_connected_at', '<', now()->subMinutes(4));
                    $q->orWhere('last_connected_at', null);
                })
                ->orderBy('id', "DESC")
                ->paginate($paginate);
            menuSubmenu('admin-company-towers', 'adminOfflineRms');
        } else {
            $data['towers'] = $items = Tower::with('division', 'district', 'upazila')
                ->orderBy('id', "DESC")->paginate($paginate);
        }
        return view('admin.tower.index',$data);
    }

    public function active(Request $request){
        if($request->mode=='true'){
            DB::table('towers')->where('id',$request->id)->update(['active'=>1]);
        }
        else{
            DB::table('towers')->where('id',$request->id)->update(['active'=>0]);
        }
        return response()->json(['msg'=>'Successfully updated status','status'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        menuSubmenu('towers','create-tower');
        $data['companies']=Company::where('active',1)->latest()->get();

        return view('admin.tower.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tower $tower)
    {
        $this->validate($request,[
            'name'=>'required|string',
            'company_id'=>'required|numeric',
            'chipid'=>'unique:towers,chipid',
            'sim_number'=>'nullable',
            'address'=>'nullable|string',
        ]);

        $tower->company_id=$request->company_id;
        $tower->name=$request->name;
        $tower->chipid=$request->chipid;
        $tower->sim_number=$request->sim_number;
        $tower->address=$request->address;
        $tower->save();
        return redirect()->route('towers.index')->with('success','Successfully created tower');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tower $tower)
    {

        $data['tower'] = Tower::with(['company.clusters','company.regions','company.vendors'])->find($tower->id);

        $data['companies'] = Company::where('active',1)->latest()->get();
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['thanas'] = Upazila::all();
        $data['companytenants'] = $companytenants = CompanyTenant::where("company_id", $tower->company_id)->get();

        $data['towertenant'] = $towertenant = TowerWiseTenant::where("tower_id", $tower->id)->get();
        return view('admin.tower.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tower $tower)
    {

        $this->validate($request,[
            'name'=>'required|string',
            'company_id'=>'required',
            'chipid'=>'unique:towers,chipid,'.$tower->id,
            'sim_number'=>'nullable',
            'address'=>'nullable|string',
            'division' => 'required',
            'district' => 'required',
            'thana' => 'required',
        ]);

        $tower->company_id=$request->the_company_id;
        $tower->name=$request->name;
        $tower->chipid=$request->chipid;
        $tower->sim_number=$request->sim_number;
        $tower->address=$request->address;
        $tower->sim_data_expired_date=$request->sim_data_expired_date;
        $tower->division_id=$request->division;
        $tower->district_id=$request->district;
        $tower->upazila_id=$request->thana;
        $tower->mno_site_id = $request->mno_site_id ?: null;
        $tower->ftb_site_id = $request->ftb_site_id ?: null;

        $tower->region_id = $request->region ?: $tower->region_id;
        $tower->zone_id = $request->zone ?: $tower->zone_id;
        $tower->sitecode_id = $request->sitecode ?: $tower->sitecode_id;
        $tower->cluster_id = $request->cluster ?: $tower->cluster_id;
        $tower->vendor_id = $request->vendor ?: $tower->vendor_id;

        $tower->dc_low_voltage_value = $request->dc_low_voltage_value;
        $tower->llvd_fail_voltage_value = $request->llvd_fail_voltage_value;
        $tower->smu_lock = $request->smu_lock ? 1 :0;
        $tower->has_bms = $request->has_bms ? 1 :0;

        $tower->alarm_1 = $request->alarm_1 ? 0 : 1;
        $tower->alarm_3 = $request->alarm_3 ? 0 : 1;
        $tower->alarm_5 = $request->alarm_5 ? 0 : 1;
        $tower->alarm_6 = $request->alarm_6 ? 0 : 1;
        $tower->alarm_7 = $request->alarm_7 ? 0 : 1;
        $tower->alarm_8 = $request->alarm_8 ? 0 : 1;

        $tower->save();
        // Tower Wise Tenant
        $tTena = new TowerWiseTenant;

        if ($request->max_loard != "" && $request->con == 1) {
            foreach ($request->max_loard as $ten => $val) {
                $tTena = new TowerWiseTenant;
                $tTena->tower_id = $tower->id;
                $tTena->chipid = $request->chipid;
                $tTena->company_id = $request->company_id;
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
                    $prev_tenent->company_id = $request->company_id;
                    $prev_tenent->tenant_id = $request->tenant_id[$ten];
                    $c_teanant = CompanyTenant::find($prev_tenent->tenant_id);
                    if ($c_teanant) {
                        $prev_tenent->tenant_name = $c_teanant->title;
                    }
                    $prev_tenent->max_load = $request->max_loard[$ten];
                    $prev_tenent->save();

//                    TowerWiseTenant::where("id", $val)
//                        ->update([
//                            'tower_id' => $tower->id,
//                            // 'company_id' => $request->company_id,
//                            'chipid' => $request->chipid,
//                            'tenant_id' => $request->tenant_id[$ten],
//                            'max_loard' => $request->max_loard[$ten],
//                        ]);
                }
            }
        }


        return redirect()->back()->with('success','Successfully updated tower');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tower::DestroyTower($id);
        return redirect()->route('towers.index')->with('success','Successfully deleted tower');

    }
}

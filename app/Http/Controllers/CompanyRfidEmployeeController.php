<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\RfidEmployeeInfo;
use App\Models\RfidEmployeeLogs;
use App\Models\Tower;
use Illuminate\Http\Request;

class CompanyRfidEmployeeController extends Controller
{
    public function index(Request $request ,Company $company)
    {
        menuSubmenu('rfidUsers','');
        $data['company'] = $company;
        $paginate = 100;
        $data['items'] = $items = RfidEmployeeInfo::where('company_id',$company->id)->paginate($paginate);
        // return $items;
        return view('company.rfid_users.rfidUsers',$data) ->with('i', ($request->input('page', 1) - 1) * $paginate);;
    }
    public function add(Request $request ,Company $company)
    {
        menuSubmenu('rfidUsers','');
        return view('company.rfid_users.addRfidUser',compact('company'));
    }
    public function store(Request $request,Company $company)
    {

        $allData = new RfidEmployeeInfo;
        $allData->company_id = $company->id;
        $allData->rfid = $request->rfid;
        $allData->employee_id = $request->employee_id;
        $allData->name = $request->name;
        $allData->mobile_no = $request->mobile_no;
        $allData->email = $request->email;
        $allData->blood_group = $request->blood_group;
        $allData->nid = $request->nid;
        $allData->doe = $request->doe;
        $allData->status = $request->status;
        $allData->save();
        return redirect()->route('company.rfid.users',$company)->with('success','New Rfid User Added Successfully.');

    }
    public function edit(Company $company,$id)
    {
        $data['item'] = $item = RfidEmployeeInfo::find($id);

        $data['company'] =$company;

        return view('company.rfid_users.editRfidUser',$data);
    }
    public function update(Request $request,Company $company,$id)
    {
        $allData = RfidEmployeeInfo::find($id);
        $request->validate([
            'rfid'=>'required',
        ]);
        $allData->rfid = $request->rfid;
        $allData->employee_id = $request->employee_id;
        $allData->name = $request->name;
        $allData->mobile_no = $request->mobile_no;
        $allData->email = $request->email;
        $allData->blood_group = $request->blood_group;
        $allData->nid = $request->nid;
        $allData->doe = $request->doe;
        $allData->status = $request->status;
        $allData->save();
        return redirect()->route('company.rfid.users',$company)->with('success','Rfid user Updated Successfully.');

    }
    public function userWiseSmuDetails(Company $company,$id){
        $rfid_user = RfidEmployeeInfo::find($id);
        if(!$rfid_user) abort(405);
        $data['company'] = $company;
        $data['rfid_user'] = $rfid_user;
        $data['items'] = RfidEmployeeLogs::where('rfid_employee_id',$rfid_user->rfid)->orderBy('id','DESC')->paginate(100);
        return view('company.rfid_users.rfidWiseSmuData',$data);
    }

    public function towerLockUnlockData(Request $request){
        menuSubmenu('smuLock', $request->type ? $request->type."smuLock" : 'allsmuLock' );
        $company = Company::find($request->company);
        $data['type'] = $request->type;
        $data['company'] = $company;

        if($request->type == 'total'){
            $data['lockUnlockTowers'] =Tower::where('company_id',$request->company)->whereHas('lockUnlockData')->paginate(20);
        }
        elseif($request->type == 'open'){
            $data['lockUnlockTowers'] =Tower::where('company_id', $request->company)->whereHas('lockUnlockData', function ($q) {
                $q->where('door_open_at', '!=', null);
                $q->where('door_closed_at', null);
            })->paginate(20);

        }elseif ($request->type == 'close'){
            $data['lockUnlockTowers'] = Tower::where('company_id', $request->company)->whereHas('lockUnlockData', function ($q) {
                $q->where('door_open_at', '!=', null);
                $q->where('door_closed_at','!=', null);
            })->paginate(20);

        }
        return  view('company.rfid_users.lockUnlockData',$data);
    }
    public function towerWiseLockUnlockData(Request $request){
        $data['type'] = $request->type;
        $data['company'] = $company = Company::find($request->company);
        $data['tower'] = Tower::where('chipid',$request->chipid)->first();
        $data['items'] = RfidEmployeeLogs::with('tower')->where('chipid',$request->chipid)->orderBy('id','DESC')->paginate(50);
        $data['employees'] = RfidEmployeeInfo::where('company_id', $company->id)->where('status', 1)->get();
        return  view('company.rfid_users.lockUnlockDataList',$data);

    }
}

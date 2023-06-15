<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActiveDevice;
use App\Models\Device;
use App\Models\Tower;
use App\Models\TowerData;
use Illuminate\Http\Request;

class ActiveDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,Tower $tower)
    {

        $devices = Device::orderBy('device_name')->get();
        $active_devices = ActiveDevice::with('device')->where('tower_id',$tower->id)->get();
        return view('admin.tower.active_device.active_device',compact('tower','devices','active_devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request,Tower $tower)
    {

        $devices = Device::whereNotIn('id',$tower->activeDevices()->pluck('device_id'))->orderBy('device_name')->get();
        return view('admin.tower.active_device.add_active_device',compact('tower','devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Tower $tower)
    {
        $request->validate([
            'device_name'=>'required'
        ]);
        if($request->active_column == null){
            return redirect()->back()->with('warning','Must Need To active Column Name');
        }
        $other_field = implode(',',['created_at','chipid']);
        $active_column = implode(',',$request->active_column);
        $final_active_column = $other_field.",".$active_column;

        $active_device = new ActiveDevice;
        $active_device->tower_id = $tower->id;
        $active_device->device_id = $request->device_name;
        $active_device->active_column = $final_active_column;
        $active_device->save();

        return redirect()->route('admin.tower.active_device.index',$tower)->with('success','Device Active Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActiveDevice $active_device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActiveDevice $active_device, Tower $tower)
    {
        $devices = Device::orderBy('device_name')->get();
        return view('admin.tower.active_device.edit_active_device',compact('tower','devices','active_device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActiveDevice $active_device, Tower $tower)
    {
        $request->validate([
            'device_name'=>'required'
        ]);
        if($request->active_column == null){
            return redirect()->back()->with('warning','Must Need To active Column Name');
        }
        $other_field = implode(',',['created_at','chipid']);
        $active_column = implode(',',$request->active_column);
        $final_active_column = $other_field.",".$active_column;


        $active_device->tower_id = $tower->id;
        $active_device->device_id = $request->device_name;
        $active_device->active_column = $final_active_column;
        $active_device->save();

        return redirect()->route('admin.tower.active_device.index',$tower)->with('success','Device Updated Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActiveDevice $active_device, Tower $tower)
    {

        $active_device->delete();
        return redirect()->route('admin.tower.active_device.index',$tower)->with('success','Device Deleted Successful');
    }
}

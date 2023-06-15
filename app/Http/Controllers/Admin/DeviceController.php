<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       menuSubmenu('device','device');
        $devices = Device::orderBy('created_at','DESC')->get();
       return view('admin.device.addDevice',compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_name'=>'required'
        ]);

        $device = new Device();
//        $device->column_name = implode(',',$request->input_name);
        $device->device_name = $request->device_name;
        $device->save();
        return redirect()->back()->with('success','Device Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'device_name'=>'required'
        ]);

//        $device->column_name = implode(',',$request->input_name);
        $device->device_name = $request->device_name;
        $device->save();
        return redirect()->back()->with('success','Device Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TowerAlarmInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlarmInfoController extends Controller
{
    public function index()
    {
        menuSubmenu('alarm', 'alarm');
        $datas = TowerAlarmInfo::orderBy('category')->paginate(100);
        return view('admin.alarmInfo.allAddedTowerAlarms', [
            'datas' => $datas,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'alarm_type' => ['required'],
            'category' => ['required'],
            'title' => ['required'],
            'alarm_numbers' => ['required'],
            'active' => ['nullable'],
        ]);

        $data = new TowerAlarmInfo;
        $data->alarm_type = $request->alarm_type;
        $data->category = $request->category;
        $data->title = $request->title;
        $data->alarm_numbers = $request->alarm_numbers;
        $data->active = $request->active ? true : false;
        $data->addedby_id = Auth::id();
        $data->save();

        return back()->with('success', 'Alarm info successfully added.')->withInput();
    }

    public function edit(Request $request, TowerAlarmInfo $alarm)
    {
        return view('admin.alarmInfo.editTowerAlarmDataEdit',[
            'data' => $alarm,
            'oldNumbers' => $alarm->alarm_numbers,
        ]);

    }

    public function update(Request $request, TowerAlarmInfo $alarm)
    {
        $request->validate([
            'alarm_type' => ['required'],
            'category' => ['required'],
            'title' => ['required'],
            'alarm_numbers' => ['required'],
            'active' => ['nullable'],
        ]);

        $alarm->alarm_type = $request->alarm_type;
        $alarm->category = $request->category;
        $alarm->title = $request->title;
        $alarm->alarm_numbers = $request->alarm_numbers;
        $alarm->active = $request->active ? true : false;
        $alarm->addedby_id = Auth::id();
        $alarm->save();

        return redirect()->route('alarms.index')->with('success', 'Alarm info successfully added.')->withInput();
    }
    public function destroy(TowerAlarmInfo $alarm){
        return back()->with('warning', 'you are not able to delete.')->withInput();
        $alarm->delete();
        return back()->with('success', 'Alarm info successfully Deleted.')->withInput();
    }
}

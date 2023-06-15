<?php

namespace App\Http\Controllers;

use App\Models\Tower;
use App\Models\TowerData;
use Illuminate\Http\Request;

class GridDataController extends Controller
{
    public function index(Request $request)
    {
        menuSubmenu('','grid_data');
        $tower = Tower::where('chipid',$request->chipid)->first();
        $grid_data = TowerData::where(function ($q) use($request){
            if ($request->chipid) {
                $q->where('chipid', $request->chipid);
            }
        })
        ->orderBy('created_at','DESC')
        ->paginate(20);
        return view('admin/gridData/grid_data_list',compact('grid_data','tower'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tower;
use App\Models\TowerData;
use Illuminate\Http\Request;

class TowerDataController extends Controller
{
    public function index(Request $request, Tower $tower)
    {
        menuSubmenu('','grid_data');
        $tower_data = TowerData::where('tower_id',$tower->id)->orderBy('created_at','DESC')
        ->paginate(10);
        return view('admin/tower_data/tower_data_list',compact('tower_data','tower'));
    }
}

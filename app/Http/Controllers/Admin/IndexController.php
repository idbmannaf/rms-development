<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PgmsDevice;
use App\Models\Tower;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $data['users']= User::all();
        $data['companies']= Company::all();
        $data['towers']= Tower::all();
        return view('admin.index',$data);
    }
}

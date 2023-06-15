<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function index($id){
        menuSubmenu('company-infos','');
        $company=Company::find($id);
        return view('company.company_infos.index',compact('company'));
    }
    public function edit(string $id){
        $company=Company::find($id);
        return view('company.company_infos.edit',compact('company'));
    }
    public function update(Request $request,string $id){
//        return $request->all();
        $this->validate($request,[
            'name'=>'required|string',
            'user_id'=>'required|numeric',
            'address'=>'nullable|string',
            'logo'=>'nullable|image|mimes:jpeg,webp,jpg,png',
        ]);
//        return $request->all();
        Company::UpdateCompany($request, $id);
        return redirect()->route('company-infos.index',$id)->with('success','Successfully updated');
    }
}

<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyTenant;
use Illuminate\Http\Request;

class CompanyTenantController extends Controller
{
    public function index(Request $request,Company $company){
        menuSubmenu('company_tenant','company_tenant');
        if ($request->method() == 'GET') {
            $company_tenants = CompanyTenant::with('company')->where('company_id',$company->id)->get();
            return view('company.tenant.company_tenant', compact('company','company_tenants'));
        } elseif ($request->method() =='POST') {
            $request->validate([
                'title'=>'required',
                'description'=>'nullable',
                'active'=>'nullable',
            ]);

            $tenant = new CompanyTenant;
            $tenant->company_id = $company->id;
            $tenant->title = $request->title;
            $tenant->description = $request->description;
            $tenant->active = $request->active ? 1 : 0;
            $tenant->save();
            return  redirect()->back()->with('success','Tenant Created Successfully');
        }
        abort(405);
    }

    public function update(Request $request, Company $company,CompanyTenant $tenant)
    {

        $tenant->title = $request->title;
        $tenant->description = $request->description;
        $tenant->active = $request->active ? 1 : 0;
        $tenant->save();
        return  redirect()->back()->with('success','Tenant Created Successfully');
    }
}

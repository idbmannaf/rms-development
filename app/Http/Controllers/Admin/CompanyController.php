<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyTenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        menuSubmenu('companies', 'all-companies');
        $companies = Company::latest()->simplePaginate(100);
        return view('admin.company.index', compact('companies'));
    }

    public function active(Request $request)
    {
        if ($request->mode == 'true') {
            DB::table('companies')->where('id', $request->id)->update(['active' => 1]);
        } else {
            DB::table('companies')->where('id', $request->id)->update(['active' => 0]);
        }
        return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        menuSubmenu('companies', 'create-company');
        $users = User::all();
        return view('admin.company.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|numeric',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,webp,jpg,png',
        ]);
        Company::CreateCompany($request);
        return redirect()->route('companies.index')->with('success', 'Successfully created company');
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
    public function edit(string $id)
    {
        $users = User::all();
        $company = Company::find($id);
        return view('admin.company.edit', compact(['users', 'company']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|numeric',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,webp,jpg,png',
        ]);
//        return $request->all();
        Company::UpdateCompany($request, $id);
        return redirect()->route('companies.index')->with('success', 'Successfully updated company');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Company::DeleteCompany($id);
        return redirect()->back()->with('success', 'Successfully Deleted');
    }

    public function companyTenant(Request $request, Company $company)
    {
        if ($request->method() == 'GET') {
            $company_tenants = CompanyTenant::with('company')->where('company_id',$company->id)->get();
            return view('admin.company.tenant', compact('company','company_tenants'));
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
    public function companyTenantUpdate(Request $request, Company $company,CompanyTenant $tenant)
    {

            $tenant->title = $request->title;
            $tenant->description = $request->description;
            $tenant->active = $request->active ? 1 : 0;
            $tenant->save();
            return  redirect()->back()->with('success','Tenant Created Successfully');
    }
}

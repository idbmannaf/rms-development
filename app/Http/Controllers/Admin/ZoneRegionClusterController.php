<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Company;
use App\Models\CompanyCluster;
use App\Models\CompanyVendor;
use App\Models\Region;
use App\Models\SiteCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneRegionClusterController extends Controller
{
    public function zoneRegionCluster(Company $company)
    {
        $regions = Region::where('company_id', $company->id)->latest()->paginate(200);
        $zones = Zone::where('company_id', $company->id)->latest()->paginate(25);
        $SiteCodes = SiteCode::where('company_id', $company->id)->latest()->paginate(25);
        $clusters = CompanyCluster::where('company_id', $company->id)->latest()->paginate(50);
        $vendors = CompanyVendor::where('company_id', $company->id)->latest()->paginate(50);

        return view('admin.company.zone_region_cluster', [
            'company' => $company,
            'regions' => $regions,
            'zones' => $zones,
            'sitecodes' => $SiteCodes,
            'clusters' => $clusters,
            'vendors' => $vendors,
        ]);
    }

    public function addregion(Company $company, Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        }

        $region = new Region;
        $region->company_id = $company->id;
        $region->title = $request->title;
        $region->description = $request->description;
        $region->active = $request->active ? 1 : 0;
        $region->save();

        return back()->with('success', 'Region Addedd Successfully.');
    }
    public function ediitRegionDetails(Company $company, Region $region)
    {
        return view('admin.company.regions.editRegion', [
            'company' => $company,
            'region' => $region,
        ]);
    }
    public function updateRegion(Company $company, Region $region)
    {
        $request = request();
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if ($validation->fails()) {
            return back()
                ->withInput()
                ->withErrors($validation);
        }

        $region->title = $request->title;
        $region->description = $request->description;
        $region->active = $request->active ? 1 : 0;
        $region->save();
        return redirect()->route('zoneRegionCluster', $company)->with('success', 'Region Updated Successfully.');
    }


    public function addNewZone(Company $company, Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
                'region' => ['required']
            ]);

        if ($validation->fails()) {

            return back()
                ->with('info', 'Somting went to wrong.');
        }

        $zone = new Zone;
        $zone->company_id = $company->id;
        $zone->region_id = $request->region;
        $zone->title = $request->title;
        $zone->description = $request->description;
        $zone->active = $request->active ? 1 : 0;
        $zone->save();
        return back()->with('success', 'Zone Added Successfully.');

    }
    public function editZone(Company $company, Zone $zone)
    {
        $regions = $company->regions()->where('active', 1)->latest()->get();
        return view('admin.company.regions.editZone', [
            'company' => $company,
            'zone' => $zone,
            'regions' => $regions
        ]);
    }
    public function updateZone(Company $company, Zone $zone, Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
                'region' => ['required']
            ]);

        if ($validation->fails()) {

            return back()
                ->with('info', 'Somting went to wrong.');
        }

        $zone->company_id = $company->id;
        $zone->region_id = $request->region;
        $zone->title = $request->title;
        $zone->description = $request->description;
        $zone->active = $request->active ? 1 : 0;
        $zone->save();

        return redirect()->route('zoneRegionCluster', $company)->with('success', 'Zone Update Successfully.');
    }


    public function addNewSiteCode(Company $company, Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
                'region' => ['required'],
                'zone' => ['required'],
            ]);

        if ($validation->fails()) {

            return back()
                ->with('info', 'Somting went to wrong.');
        }

        $siteCode = new SiteCode;
        $siteCode->company_id = $company->id;
        $siteCode->region_id = $request->region;
        $siteCode->zone_id = $request->zone;
        $siteCode->title = $request->title;
        $siteCode->description = $request->description;
        $siteCode->active = $request->active ? 1 : 0;
        $siteCode->save();
        return back()->with('success', 'SiteCode Added Successfully.');
    }
    public function updateSiteCode(Company $company, SiteCode $scode)
    {
        $regions = $company->regions()->where('active', 1)->latest()->get();
        $zones = $company->zones()->where('active', 1)->latest()->get();
        return view('admin.company.regions.updateSiteCode', [
            'company' => $company,
            'zones' => $zones,
            'regions' => $regions,
            'scode' => $scode
        ]);
    }
    public function updatepostsiteCode(Company $company, SiteCode $scode, Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
                'region' => ['required'],
                'zone' => ['required'],
            ]);

        if ($validation->fails()) {

            return back()
                ->with('info', 'Somting went to wrong.');
        }
        // dd( $request->all());
        $scode->company_id = $company->id;
        $scode->region_id = $request->region;
        $scode->zone_id = $request->zone;
        $scode->title = $request->title;
        $scode->description = $request->description;
        $scode->active = $request->active ? 1 : 0;
        $scode->save();

        return redirect()->route('zoneRegionCluster', $company)->with('success', 'SiteCode update Successfully.');
    }

    public function addCluster(Request $request, Company $company)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        }

        $cluster = new CompanyCluster;
        $cluster->company_id = $company->id;
        $cluster->title = $request->title;
        $cluster->description = $request->description;
        $cluster->active = $request->active ? 1 : 0;
        $cluster->save();

        return back()->with('success', 'Cluster Addedd Successfully.');
    }

    public function editClusterDetails(Company $company, CompanyCluster $cluster)
    {

        return view('admin.company.regions.editCluster', [
            'company' => $company,
            'cluster' => $cluster,
        ]);
    }
    public function updateCluster(Company $company, CompanyCluster $cluster)
    {
        $request = request();
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255','min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if($validation->fails())
        {
            return back()
                ->withInput()
                ->withErrors($validation);
        }
        $cluster->title = $request->title;
        $cluster->description = $request->description;
        $cluster->active = $request->active ? 1 : 0;
        $cluster->save();
        return redirect()->route('zoneRegionCluster', $company)->with('success','Cluster Updated Successfully.');
    }


    public function addVendor(Request $request, Company $company)
    {
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if ($validation->fails()) {

            return back()
                ->withInput()
                ->withErrors($validation);
        }

        $vendor = new CompanyVendor;
        $vendor->company_id = $company->id;
        $vendor->title = $request->title;
        $vendor->description = $request->description;
        $vendor->active = $request->active ? 1 : 0;
        $vendor->save();

        return back()->with('success', 'Vendors Addedd Successfully.');
    }
    public function editVendorDetails(Company $company, CompanyVendor $vendor)
    {
        return view('admin.company.regions.editVendor', [
            'company' => $company,
            'vendor' => $vendor,
        ]);
    }
    public function updateVendor(Company $company, CompanyVendor $vendor)
    {
        $request = request();
        $validation = Validator::make($request->all(),
            [
                'title' => ['required', 'string', 'max:255','min:2'],
                'description' => ['nullable', 'string', 'max:255'],
            ]);

        if($validation->fails())
        {
            return back()
                ->withInput()
                ->withErrors($validation);
        }

        $vendor->title = $request->title;
        $vendor->description = $request->description;
        $vendor->active = $request->active ? 1 : 0;
        $vendor->save();


        return  redirect()->route('zoneRegionCluster', $company)->with('success','Vendor Updated Successfully.');
    }

}

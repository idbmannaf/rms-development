<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory;

    private static $company;
    private static $logo, $logoName, $logoExtension,$directory;

    public static function getLogoUrl($request){
        if($request->file('logo')){
            self::$logo=$request->file('logo');
            self::$logoExtension=self::$logo->getClientOriginalExtension();
            self::$logoName=time().'.'.self::$logoExtension;
            self::$directory='assets/admin/images/company/';
            self::$logo->move(self::$directory,self::$logoName);
            return self::$directory.self::$logoName;
        }
        return '';
    }
    public static function CreateCompany($request){
        self::saveBasicInfo(new Company(),$request,self::getLogoUrl($request));
    }

    public static function UpdateCompany($request, $id){
        self::$company=Company::find($id);
        if ($request->file('logo')){
            if (file_exists(self::$company->logo)){
                unlink(self::$company->logo);
            }
            self::$logo=self::getLogoUrl($request);
        }
        else{
            self::$logo=self::$company->logo;
        }
        self::SaveBasicInfo(self::$company, $request, self::$logo);
    }
    private static function SaveBasicInfo($company, $request, $getLogo){
        $company->user_id=$request->user_id;
        $company->name=$request->name;
        $company->address=$request->address;
        $company->logo=$getLogo;
        if($request->added_by_id){
            $company->added_by_id=$request->added_by_id;
        }

        if($request->edited_by_id){
            $company->edited_by_id=$request->edited_by_id;
        }

        $company->save();
    }

    public static function DeleteCompany($id){
        self::$company=Company::find($id);
        if(file_exists(self::$company->logo)){
            unlink(self::$company->logo);
        }
        self::$company->delete();
        DB::table('towers')->where('company_id',$id)->delete();
        DB::table('pgms_devices')->where('company_id',$id)->delete();
        DB::table('pgms_data')->where('company_id',$id)->delete();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


    public function clusters()
    {
        return $this->hasMany(CompanyCluster::class, 'company_id');
    }

    public function vendors()
    {
        return $this->hasMany(CompanyVendor::class, 'company_id');
    }

    public function regions()
    {
        return $this->hasMany(Region::class, 'company_id');
    }


    public function zones()
    {
        return $this->hasMany(Zone::class, 'company_id');
    }

    public function siteCodes()
    {
        return $this->hasMany(SiteCode::class, 'company_id');
    }


}

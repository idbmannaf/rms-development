<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    private static $user_role;

    public static function CreateUserRole($request){
        self::$user_role=new UserRole();
        self::$user_role->user_id=$request->user_id;

        if($request->role_name=='admin'){
            self::$user_role->role_name='admin';
            self::$user_role->role_value='Admin';
        }
        if($request->role_name=='super_admin'){
            self::$user_role->role_name='super_admin';
            self::$user_role->role_value='SuperAdmin';
        }
        if($request->role_name=='company_admin'){
            self::$user_role->role_name='company_admin';
            self::$user_role->role_value='CompanyAdmin';
        }

        if($request->added_by_id){
            self::$user_role->added_by_id=$request->added_by_id;
        }
        self::$user_role->save();
    }

    public static function UpdateUserRole($request, $id){
        self::$user_role=UserRole::find($id);
        self::$user_role->user_id=$request->user_id;

        if($request->role_name=='admin'){
            self::$user_role->role_name='admin';
            self::$user_role->role_value='Admin';
        }
        if($request->role_name=='super_admin'){
            self::$user_role->role_name='super_admin';
            self::$user_role->role_value='SuperAdmin';
        }
        if($request->role_name=='company_admin'){
            self::$user_role->role_name='company_admin';
            self::$user_role->role_value='CompanyAdmin';
        }

        if($request->edited_by_id){
            self::$user_role->edited_by_id=$request->edited_by_id;
        }
        self::$user_role->save();
    }
    public static function DestroyUser($id){
        self::$user_role=UserRole::find($id);
        self::$user_role->delete();
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}

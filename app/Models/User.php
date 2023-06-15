<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private static $user;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public static function UserCreate($request)
    {
        self::$user = new User();
        self::SaveBasicInfo(self::$user, $request);
    }
    public static function UserUpdate($request, $id)
    {
        self::$user = User::find($id);
        self::SaveBasicInfo(self::$user, $request);
    }
    private static function SaveBasicInfo($user, $request)
    {
        $user->name = $request->name;

        if ($request->username) {
            $user->username = $request->username;
        }
        if ($request->email) {
            $user->email = $request->email;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->mobile = $request->mobile;
        $user->save();
    }
    public static function DestroyUser($id)
    {
        self::$user = User::find($id);
        self::$user->delete();
        DB::table('user_roles')->where('user_id', $id)->delete();
        DB::table('companies')->where('user_id', $id)->delete();
    }

    public function userRoles()
    {
        return $this->hasOne(UserRole::class, 'user_id');
    }

    public function hasUserRole($role)
    {
        return (bool) $this->userRoles()->where('role_name', $role)->count();
    }
    public function hasUserRoleId($user_id)
    {
        return (bool) $this->userRoles()->where('user_id', $user_id)->first();
    }
    public function isAdmin()
    {
        return (bool) $this->userRoles()->where('role_name', 'admin')->count();
    }
    public function company()
    {
        return $this->hasMany(Company::class, 'user_id');
    }
    public function companies()
    {
        return Company::where('user_id', auth()->user()->id)->get();
    }
    public function hasCompany()
    {
        return (bool) $this->company()->where('user_id', $this->id)->count();
    }
    public function hasCompanyId($user_id)
    {
        return (bool) $this->company()->where('user_id', $user_id)->count();
    }
    public function companyId($user_id)
    {
        return $this->company()->where('user_id', $user_id)->pluck('id')->first();
    }
    public static function ChangePassword($request, $id)
    {
        self::$user = User::find($id);
        self::$user->password = bcrypt($request->password);
        self::$user->save();
    }

}

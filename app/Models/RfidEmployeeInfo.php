<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfidEmployeeInfo extends Model
{
    public function rfidlogs()
    {
        return $this->hasMany(RfidEmployeeLogs::class,'rfid_employee_id','rfid')->where('door_closed_at','=','')->count();
    }
    public function employeeAlreadyExit()
    {
        return $this->hasMany(RfidEmployeeEntries::class,'rfid','rfid')->where('exit_date_time',Null);
    }

    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
    public function employeeOneAlreadyExit()
    {
        return $this->hasOne(RfidEmployeeEntries::class,'rfid','rfid')->where('exit_date_time',Null);
    }
}

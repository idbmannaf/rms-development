<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RfidEmployeeLogs extends Model
{
       public function tower(){
        return $this->belongsTo(Tower::class,'chipid','chipid');
    }

    public function employee()
    {
        return $this->belongsTo(RfidEmployeeInfo::class, 'rfid_employee_id', 'rfid');
    }
}

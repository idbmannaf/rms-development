<?php

namespace App\Models;
use App\Model\Towers;
use App\Model\company;
use App\Model\CompanyTenant;

use Illuminate\Database\Eloquent\Model;

class TowerWiseTenant extends Model
{
    protected $fillable = [

// 'tower_id', 'chipid', 'company_id', 'tenant_id', 'max_loard','addedby_id','editedby_id',''];
'tower_id', 'chipid', 'company_id', 'tenant_id', 'max_loard','addedby_id','editedby_id'];



    public function company()
    {

        return $this->belongsTo(Company::class);
    }
    public function companytenant()
    {

        return $this->belongsTo(CompanyTenant::class,'tenant_id');
    }

    public function tower()
    {
        return $this->belongsTo(Towers::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function zones()
    {
        return $this->hasMany('App\Models\Zone','region_id');
    }
    public function towers()
    {
        return $this->hasMany('App\Models\Tower','region_id');
    }

    // public function company()
    // {
    //     return $this->hasMany('App\Model\Company','company_id');
    // }
}

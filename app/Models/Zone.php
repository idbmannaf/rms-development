<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function sitecodes()
    {
        return $this->hasMany('App\Models\SiteCode','zone_id');

    }
    public function tower()
    {
        return $this->hasMany(Tower::class, 'zone_id');

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteCode extends Model
{
    public function zone()
    {
        return $this->belongsTo('App\Models\Zone','zone_id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region','region_id');
    }
}

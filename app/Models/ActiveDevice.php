<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveDevice extends Model
{
    use HasFactory;
    public function device(){
        return $this->belongsTo(Device::class,'device_id');
    }
    public function TowerData($tower_id){
        return TowerData::where('tower_id',$tower_id)->latest()->select($this->active_column)->first();
    }
}

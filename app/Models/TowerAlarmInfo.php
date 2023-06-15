<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TowerAlarmInfo extends Model
{

    public function catChildren()
    {
        return TowerAlarmInfo::where('category', $this->category)->get();
    }

    public function alarmDatas()
    {
        return $this->hasMany(TowerAlarmData::class, 'tower_alarm_info_id');
    }
    public function companyLiveCatAlarmCount($companyId)
    {
        return $this->alarmDatas()
            ->whereLive(1)
            ->where('company_id', $companyId)
            ->where('alarm_title', $this->title)
            ->count();
    }
    public function companyWiseTowerLiveCatAlarmCount($companyId,$tower_id)
    {
        return $this->alarmDatas()
            ->whereLive(1)
            ->where('company_id', $companyId)
            ->where('alarm_title', $this->title)
            ->where('tower_id', $tower_id)
            ->count();
    }


}

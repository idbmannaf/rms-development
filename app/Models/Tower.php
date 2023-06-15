<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    use HasFactory;

    public function latestTowerData()
    {
        return $this->hasOne(TowerData::class)->latest();
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id');
    }

    public function towerWiseTanents()
    {
        return $this->hasMany(TowerWiseTenant::class, 'tower_id');
    }

    public function firstTowerWiseTanent()
    {
        return $this->towerWiseTanents()->first();
    }

    public function secondTowerWiseTanent()
    {
        return $this->towerWiseTanents()->skip(1)->take(1)->first();
    }

    public function thridTowerWiseTanent()
    {
        return $this->towerWiseTanents()->skip(2)->take(1)->first();
    }

    public function fourthTowerWiseTanent()
    {
        return $this->towerWiseTanents()->skip(3)->take(1)->first();
    }

    public function lockUnlockData()
    {
        return $this->hasMany(RfidEmployeeLogs::class, 'chipid', 'chipid');
    }

    public function doorOpen()
    {
        return $this->lockUnlockData()->where('door_open_at', '!=', null)->where('door_closed_at', null)->latest()->first();
    }

    public function doorClose()
    {
        return $this->lockUnlockData()->where('door_open_at', '!=', null)->where('door_closed_at', '!=', null)->latest()->first();
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function siteCode()
    {
        return $this->belongsTo(SiteCode::class, 'sitecode_id');
    }

    public function cluster()
    {
        return $this->belongsTo(CompanyCluster::class, 'cluster_id');
    }

    public function vendor()
    {
        return $this->belongsTo(CompanyVendor::class, 'vendor_id');
    }

    public function towerDatas()
    {
        return $this->hasMany(TowerData::class, 'tower_id');
    }

    public function total_active_power_avg()
    {
        $startDate = \Carbon\Carbon::now()->subDays(3)->toDateString();
        $endDate = \Carbon\Carbon::now()->toDateString();
        return $this->towerDatas()->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->avg('tanent_load');
    }

    public function power_slave()
    {
        $startDate = \Carbon\Carbon::now()->subDays(30)->toDateString();
        $endDate = \Carbon\Carbon::now()->toDateString();
        return $this->towerDatas()
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('tanent_load', '>', $this->firstTowerWiseTanent()->max_load)
            ->count();
    }
    public function activeDevices(){
        return $this->hasMany(ActiveDevice::class,'tower_id');
    }
}

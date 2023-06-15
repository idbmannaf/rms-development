<?php

namespace App\Exports;

use App\Models\Tower;
use App\Models\TowerAlarmData;
use App\Models\TowerAlarmInfo;
use App\Models\TowerData;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlarmHistoryExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $towers;
    public $request;
    public function __construct($towers,$request)
    {
        $this->towers = $towers;
        $this->request = $request;
    }
    public function collection()
    {
        $request = $this->request;
        $tower_ids = $this->towers;
        $alarm = TowerAlarmInfo::where('title',$request->alarm_name)->first();
        return TowerAlarmData::with('tower','tower.zone','tower.cluster')->whereIn('tower_id',$tower_ids)
            ->where(function ($q) use($alarm){
                if($alarm){
                    $q->where('tower_alarm_info_id',$alarm->id);
                }
            })
            ->join("towers", "towers.id", "=", "tower_alarm_data.tower_id")
            ->join('zones', 'towers.zone_id', '=', 'zones.id')
            ->join('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
            ->select('towers.name',
                'tower_alarm_data.created_at',
                'towers.mno_site_id',
                'towers.chipid',
                'zones.title as tower_zone',
                'company_clusters.title',
                'tower_alarm_data.alarm_title',
                'tower_alarm_data.alarm_started_at',
                'tower_alarm_data.alarm_ended_at',
                DB::raw('TIMEDIFF(tower_alarm_data.alarm_started_at, tower_alarm_data.alarm_ended_at) AS duration'),
                DB::raw("(CASE WHEN tower_alarm_data.alarm_number = 2  OR tower_alarm_data.alarm_number = 4 THEN 'DC Meter' WHEN tower_alarm_data.alarm_number = 1  THEN 'AC Meter' WHEN tower_alarm_data.alarm_number = 3  THEN 'Rectifier' ELSE 'Digital Input' END) as ac_power_availibility_status")
            )
            ->orderBy('created_at','DESC')
            ->get();

    }
    public function headings(): array
    {
        return ["Towers/RMS","DateTime","Site Id","ChipId","Zone","Cluster",
            "Alarm Name",
            "Alarm Started",
            "Alarm Ended",
            "Alarm Duration",
            "Alarm Source"
            ];
    }
}

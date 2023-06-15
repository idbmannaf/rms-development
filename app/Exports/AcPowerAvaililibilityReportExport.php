<?php

namespace App\Exports;

use App\Models\Tower;
use App\Models\TowerData;
use App\Models\TowerDataLoad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AcPowerAvaililibilityReportExport implements FromCollection, WithHeadings
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
        return  TowerData::with('tower')
            ->where(function($q) use($request){
         if($request->start_date && $request->end_date ){
             $q->whereBetween('tower_data.created_at',[$request->start_date." 00:00:00",$request->end_date." 23:59:59"]);
         }elseif($request->start_date){
             $q->whereDate('tower_data.created_at',$request->start_date);
         }
     })
        ->join("towers", "towers.id", "=", "tower_data.tower_id")
        ->join('zones', 'towers.zone_id', '=', 'zones.id')
        ->join('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
        ->select('tower_data.tower_name',
        'tower_data.created_at',
        'tower_data.siteid',
        'zones.title as tower_zone',
        'company_clusters.title',
        'tower_data.voltage_phase_a',
        'tower_data.voltage_phase_b',
        'tower_data.voltage_phase_c',
        DB::raw("(CASE WHEN tower_data.mains_fail = 0  THEN 'AC Power Available' ELSE 'AC Power Unavailable' END) as ac_power_availibility_status")
        )->orderBy('tower_data.created_at',"DESC")->get();
        // dd()

    }
    public function headings(): array
    {
        return ["Tower Name","Date","Site Id","Zone", "Cluster","Voltage Grid Phase -A","Voltage Grid Phase -B","Voltage Grid Phase -C","Status"];
    }
}

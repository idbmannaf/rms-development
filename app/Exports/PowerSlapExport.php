<?php

namespace App\Exports;

use App\Models\TowerDataLoad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class PowerSlapExport implements FromCollection, WithHeadings
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
        return  TowerDataLoad::with('tower')->whereIn('tower_id', $tower_ids)->whereHas('tower', function ($qq) use ($request) {
                if ($request->cluster_id) {
                    $qq->where('cluster_id', $request->cluster_id);
                } elseif ($request->zone) {
                    $qq->where('zone_id', $request->zone);
                }

                if ($request->site_id) {
                    $qq->where('mno_site_id', $request->site_id);
                } elseif ($request->site_name) {
                    $qq->where('name', 'like', '%' . $request->site_name . '%');
                }
            })->where(function ($q) use ($request) {
                if ($request->start_date && $request->end_date) {
                    $q->whereBetween('tower_data_loads.created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                } elseif ($request->start_date) {
                    $q->whereDate('tower_data_loads.created_at', $request->start_date);
                }
            })
        ->where('relation_id','!=',null)
        ->where('total_active_power','>',2)
        ->join("towers", "towers.id", "=", "tower_data_loads.tower_id")
        ->join('zones', 'towers.zone_id', '=', 'zones.id')
        ->join('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
        ->select('towers.name as towername',
        'tower_data_loads.created_at',
        'towers.mno_site_id',
        'zones.title as tower_zone',
        'company_clusters.title',
        'tower_data_loads.total_active_power'
        )->orderBy('tower_data_loads.created_at',"DESC")->get();
        // dd()

    }
    public function headings(): array
    {
        return ["Tower Name","Date","Site Id","Zone", "Cluster","Total Active Power"];
    }
}

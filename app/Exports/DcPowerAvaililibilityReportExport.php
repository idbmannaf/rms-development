<?php

namespace App\Exports;

use App\Models\TowerData;
use App\Models\TowerDataLoad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
class DcPowerAvaililibilityReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
            ->whereIn('tower_data.tower_id',$tower_ids)
            ->where(function($q) use($request){
                if($request->start_date && $request->end_date ){
                    $q->whereBetween('tower_data.created_at',[$request->start_date." 00:00:00",$request->end_date." 23:59:59"]);
                }elseif($request->start_date){
                    $q->whereDate('tower_data.created_at',$request->start_date);
                }
            })
            ->where('tower_data.dc_voltage', '!=', 'n')
            ->join("towers", "towers.id", "=", "tower_data.tower_id")
            ->leftJoin('zones', 'towers.zone_id', '=', 'zones.id')
            ->leftJoin('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
            ->leftJoin('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
            ->select(
                'tower_data.created_at',
                'tower_data.siteid',
                'towers.name as tower_name',
                'upazilas.name as thana',
                'zones.title as tower_zone',
                'company_clusters.title',
                'tower_data.dc_voltage',
                DB::raw("(CASE WHEN tower_data.llvd_fault = 0 THEN 'DC Available' ELSE 'DC Unavailable' END) as dc_availability_status")
            )
            ->orderBy('tower_data.created_at',"DESC")
            ->get();

    }
    public function map($row): array
    {
        // Mapping logic for each row
        return [
            $row->created_at,
            $row->siteid,
            $row->tower_name,
            $row->thana,
            $row->tower_zone,
            $row->title,
            $row->dc_voltage,
            $row->dc_availability_status,
        ];
    }

    public function headings(): array
    {
        return ["DateTime","Site Id","Tower Name","Thana","Zone", "Cluster","DC Voltage",'Status'];
    }
    public function styles($sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,

            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

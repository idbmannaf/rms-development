<?php

namespace App\Exports;

use App\Models\Tower;
use App\Models\TowerData;
use App\Models\TowerDataLoad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompanyTowersStatusExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;
    public $serial = 1;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($td): array
    {
        $data[] = $td->last_connected_at;
        $data[] = $td->name;
        $data[] = $td->mno_site_id;
        $data[] = $td->upazila_name;
        $data[] = $td->mains_fail ? 'Yes' : 'No';
        $data[] = $td->dc_low_voltage ? 'Yes' : 'No';
        $data[] = $td->module_fault ? 'Yes' : 'No';
        $data[] = $td->llvd_fault ? 'Yes' : 'No';
        $data[] = $td->smoke_alarm ? 'Yes' : 'No';
        $data[] = $td->fan_fault == 1 ? 'Yes' : 'No';
        $data[] = $td->high_tem ? 'Yes' : 'No';
        $data[] = $td->door_alarm ? 'Yes' : 'No';
        return $data;
    }

    public function headings(): array
    {
        return [
            "Last Connected",
            "Site Name",
            "Site ID",
            "Thana",
            "Mains Fail",
            "DC Low Voltage",
            "Module Fault",
            "llvd Fault",
            "Smoke Alarm",
            "Fan Fault",
            "High Temp.",
            "Door Alarm",

        ];
    }
}

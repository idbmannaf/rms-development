<?php

namespace App\Exports;

use App\Models\Tower;
use App\Models\TowerData;
use App\Models\TowerDataLoad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BmsDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;

    }
    public function headings(): array
    {
        return [
           "DateTime",
           "Thana",
           "SiteID",
           "current (A)",
           " Voltage of pack (V)",
           "SOC (%)",
           "SOH (%) ",
           "Cell Voltage 01 (mv)",
           "Cell Voltage 02 (mv)",
           "Cell Voltage 03 (mv)",
           "Cell Voltage 04 (mv)",
           "Cell Voltage 05 (mv)",
           "Cell Voltage 06 (mv)",
           "Cell Voltage 07 (mv)",
           "Cell Voltage 08 (mv)",
           "Cell Voltage 09 (mv)",
           "Cell Voltage 10 (mv)",
           "Cell Voltage 11 (mv)",
           "Cell Voltage 12 (mv)",
           "Cell Voltage 13 (mv)",
           "Cell Voltage 14 (mv)",
           "Cell Voltage 15 (mv)",
           "Cell Temperature 01 (°C)",
           "Cell Temperature 03 (°C)",
           "Cell Temperature 04 (°C)",
        ];
    }
}

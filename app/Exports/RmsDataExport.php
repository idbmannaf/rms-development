<?php

namespace App\Exports;

use App\Models\Tower;
use App\Models\TowerData;
use App\Models\TowerDataLoad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RmsDataExport implements FromCollection, WithHeadings
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
            "Voltage Grid Phase -A (V)",
            "Voltage Grid Phase -B (V)",
            "Voltage Grid Phase -C (V)",
            "Current Grid Phase -A (A)",
            "Current Grid Phase -B (A)",
            "Current Grid Phase -C (A)",
            "Frequency (Hz)",
            "Power Factor ",
            "Cumilative Energy (kWh)",
            "Power (kW)",
            "DC Voltage (V)",
            "Tenent Load (A)",
            "Cumilative DC Energy (kWh)",
            "Power DC (kW)",
            "Tenant Name"
        ];
    }
}

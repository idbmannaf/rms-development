<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TowerData extends Model
{
    use HasFactory;
    protected $fillable = [
        'voltage_phase_a',
        'voltage_phase_b',
        'voltage_phase_c',
        'current_phase_a',
        'current_phase_b',
        'current_phase_c',
        'frequency',
        'power_factor',
        'cumilative_energy',
        'power',
        'dc_voltage',
        'tanent_load',
        'cumilative_dc_energy',
        'power_dc',
        'power_slab',
        'tenant_name',
        'tenant_id',
        'updated_at',
        'mains_fail',
        'dc_low_voltage',
        'module_fault',
        'llvd_fault',
        'smoke_alarm',
        'fan_fault',
        'high_tem',
        'door_alarm',
        'dc_low_voltage_value',
        'llvd_fail_voltage_value',
        'power_consume_total',
        'current',
        'voltage_of_pack',
        'soc',
        'soh',
        'cell_voltage_1',
        'cell_voltage_2',
        'cell_voltage_3',
        'cell_voltage_4',
        'cell_voltage_5',
        'cell_voltage_6',
        'cell_voltage_7',
        'cell_voltage_8',
        'cell_voltage_9',
        'cell_voltage_10',
        'cell_voltage_11',
        'cell_voltage_12',
        'cell_voltage_13',
        'cell_voltage_14',
        'cell_voltage_15',
        'cell_temperature_1',
        'cell_temperature_2',
        'cell_temperature_3',
        'cell_temperature_4'
    ];
    public function tower(){
        return $this->belongsTo(Tower::class,'tower_id');
    }
}

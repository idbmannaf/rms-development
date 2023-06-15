<?php

return [
    'operators' => [
        '1' => '+',
        '2' => '-',
        '3' => '*',
        '4' => '/',
        '5' => '%'
    ],

    'calculation_methods' => [

        'dectohex2reg',
        'proportional1reg',
        'ieee754_2reg',
        'signed2sComp1reg'
    ],

    'digital_inputs' => [

        'Mains Fail',
        'DC Low Voltage',
        'Module Fault',
        'LLVD Fail',
        'Smoke Alarm',
        'Fan Fault',
        'High Temp. Alarm',
        'Door Open Alarm'
    ],

    'alarm_cats' => [
        'AC & DC',
        'Sensor',
        'Power',
        // 'Battery'

    ],

    'alarm_numbers' => [

        '1' => 'Door Open Alarm',
        '2' => 'Smoke Alarm',
        '3' => 'Fan Fault',
        '4' => 'High Temp Alarm',
        '5' => 'Mains Fail',
        '6' => 'DC Low Voltage',
        '7' => 'Module Fault',
        '8' => 'LLVD Fail',
    ],

    'tower_report_type' => [
        'Active Load',
        'AC Power Availability',
        'DC Power Availability',
        'Mains Fail',
        'Power Consumption',
        'BMS History',
        'Power Slab',
        'Alarms History',
        'SMU Lock History',
    ]


];

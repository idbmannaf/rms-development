<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TowerAlarmData extends Model
{
    protected $fillable = [

        'live', 'alarm_ended_at'

    ];

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id');
    }

    public function alarmSource()
    {
        $a = '';
        if($this->alarm_number == 2 || $this->alarm_number == 4)
        {
            $a = 'DC Meter';
        }elseif($this->alarm_number == 1)
        {
            $a = 'AC Meter';
        }elseif($this->alarm_number == 3)
        {
            $a = 'Rectifier';
        }elseif ($this->alarm_number == 5 || $this->alarm_number == 6 || $this->alarm_number == 7 || $this->alarm_number == 8){
            $a = 'Digital Input';
        }

        return $a;
    }

}

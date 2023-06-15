<?php
namespace App\Models;

use App\Models\TowerWiseTenant;
use Illuminate\Database\Eloquent\Model;

class CompanyTenant extends Model
{
    protected $fillable = [
        'title', 'description','active', 'company_id',
    ];

    public function towerwisetenant()
    {
        return $this->hasMany(TowerWiseTenant::class);
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }


}

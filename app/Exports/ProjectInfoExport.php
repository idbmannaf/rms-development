<?php

namespace App\Exports;

use App\Models\ProjectInfo;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\DB ;

class ProjectInfoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('project_infos')
        ->join('users', 'project_infos.pro_manager_id', '=', 'users.id')
        ->join('customer_infos', 'project_infos.pro_customer_id', '=', 'customer_infos.id')
        ->select('project_infos.pro_name','project_infos.pro_code','project_infos.pro_type','users.name','project_infos.pro_starting_date','project_infos.pro_ending_date','project_infos.pro_summary','customer_infos.c_name')
        ->get();
    }
}

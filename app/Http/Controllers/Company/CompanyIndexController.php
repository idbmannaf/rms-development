<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PgmsDevice;
use App\Models\Tower;
use App\Models\TowerAlarmInfo;
use App\Models\TowerData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Spatie\Activitylog\Models\Activity;

class CompanyIndexController extends Controller
{
    public function index(Company $company)
    {
        menuSubmenu('company_dashboard', 'company_dashboard');
        $data['company'] = $company;
        $data['towers'] = $towers = Tower::where('company_id', $company->id)->get();
        $towerIds = Tower::where('company_id', $company->id)->pluck('id');

        //Average Power Consumption
        $startDate = \Carbon\Carbon::now()->subDays(3)->toDateString();
        $endDate = \Carbon\Carbon::now()->toDateString();

        $avg_power_consumption = TowerData::whereIn('tower_id', $towerIds)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->avg('power_dc');
        $data['avg_power_consumption'] = number_format($avg_power_consumption, '2', '.');


        //Average Power Slab For Last 30 Days
        $power_slab_startDate = \Carbon\Carbon::now()->subDays(30)->toDateString();
        $power_slab_endDate = \Carbon\Carbon::now()->toDateString();
        $powerSlab = DB::table('tower_data')
            ->whereIn('tower_id', $towerIds)
            ->whereDate('created_at', '>=', $power_slab_startDate)
            ->whereDate('created_at', '<=', $power_slab_endDate)
            ->selectRaw('COUNT(CASE WHEN power_slab = 0 THEN 1 END) AS not_power_slab')
            ->selectRaw('SUM(CASE WHEN power_slab = 0 THEN power_slab_duration  END) AS not_power_slab_sum')
            ->selectRaw('COUNT(CASE WHEN power_slab = 1 THEN 1 END)  AS power_slab')
            ->selectRaw('SUM(CASE WHEN power_slab = 1 THEN power_slab_duration  END)  AS power_slab_sum')
            ->first();
        $total_power_slab_count = $powerSlab->not_power_slab + $powerSlab->power_slab;
        $data['avg_power_slab'] = number_format($powerSlab->power_slab > 0 ? (($powerSlab->power_slab / $total_power_slab_count) * 100) : 0, 0);
        $data['avg_power_slab_seconds'] = $powerSlab->power_slab_sum;

        //DC Availability Power Slab
        $dc_avg = DB::table('tower_data')
            ->whereIn('tower_id', $towerIds)
            ->whereDate('created_at', '>=', $power_slab_startDate)
            ->whereDate('created_at', '<=', $power_slab_endDate)
            ->selectRaw('COUNT(CASE WHEN llvd_fault = 0 THEN 1 END) AS dc_available_percentage')
            ->selectRaw('SUM(CASE WHEN llvd_fault = 0 THEN llvd_fail_duration END) AS dc_available_second')
            ->selectRaw('COUNT(CASE WHEN llvd_fault = 1 THEN 1 END)  AS dc_not_available_percentage')
            ->selectRaw('SUM(CASE WHEN llvd_fault = 1 THEN llvd_fail_duration END)  AS dc_not_available_second')
            ->first();

        $total_count = $dc_avg->dc_available_percentage + $dc_avg->dc_not_available_percentage;
        $data['avg_dc_availibility'] = number_format($dc_avg->dc_available_percentage > 0 ? (($dc_avg->dc_available_percentage / $total_count) * 100) : 0, 0);
        $data['dc_available_second'] = $dc_avg->dc_available_second;

        $data['totalRms'] = $totalRms = Tower::where('company_id', $company->id)->count();
        $data['onlineRms'] = $onlineRms = Tower::where('company_id', $company->id)
            ->where('last_connected_at', '>', now()->subMinutes(4))
            ->count();

        $data['totalLockTowers'] = $totalLockTowers = Tower::where('company_id', $company->id)->whereHas('lockUnlockData')->count();

        $data['towerOpenTowers'] = $towerOpenTowers = Tower::where('company_id', $company->id)->whereHas('lockUnlockData', function ($q) {
            $q->where('door_open_at', '!=', null);
            $q->where('door_closed_at', null);
        })->count();
        $data['towerCloseTowers'] = $towerCloseTowers = Tower::where('company_id', $company->id)->whereHas('lockUnlockData', function ($q) {
            $q->where('door_open_at', '!=', null);
            $q->where('door_closed_at', '!=', null);
        })->count();

        $data['alarmInfoCats'] = $alarmInfoCats = TowerAlarmInfo::groupBy('category')->orderBy('category')->get();
//        $data['avg_dc_availibility'] = $avg_dc_availibility = 100;
//        $data['avg_power_slab'] = $avg_power_slab = 10;


        $data['power_con'] = DB::table('tower_data')
            ->whereIn('tower_id', $towerIds)
            ->where('power_dc', '!=', 'n')
            ->whereDate('created_at', Carbon::today())
            ->select('siteid', DB::raw('AVG(power_dc) as average_power'))
            ->orderBy('tower_id')
            ->groupBy('siteid')
            ->get();

        $data['ac_dc'] = DB::table('tower_data')
            ->whereIn('tower_id', $towerIds)
            ->where('power_dc', '!=', 'n')
            ->whereDate('created_at', Carbon::today())
            ->select(
                'siteid',
                DB::raw('CAST((SUM(CASE WHEN mains_fail = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS ac_available'),
                DB::raw('CAST((SUM(CASE WHEN llvd_fault = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS dc_available')
            )
            ->groupBy('siteid')
            ->get();


        $data['p_slab'] = DB::table('tower_data')
            ->whereIn('tower_id', $towerIds)
            ->where('power_dc', '!=', 'n')
            ->whereDate('created_at', Carbon::today())
            ->select(
                'siteid',
                DB::raw('COUNT(CASE WHEN power_dc = 2 THEN 1 END) AS slot_1'),
                DB::raw('COUNT(CASE WHEN power_dc > 2 AND power_dc <= 2.5 THEN 1 END) AS slot_2'),
                DB::raw('COUNT(CASE WHEN power_dc > 2.5 AND power_dc <= 3 THEN 1 END) AS slot_3'),
                DB::raw('COUNT(CASE WHEN power_dc > 3 AND power_dc <= 3.5 THEN 1 END) AS slot_4'),
                DB::raw('COUNT(CASE WHEN power_dc > 3.5 AND power_dc <= 4 THEN 1 END) AS slot_5')
            )
            ->first();
//dd($data['p_slab']->kw_2);
//        dd($results);


        return view('company.index', $data);
    }

    public function powerConsumptionChartAjax(Request $request, Company $company)
    {
        $towerIds = Tower::where('company_id', $company->id)->pluck('id');

        if ($request->short_type == 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $data = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(DB::raw('AVG(power_dc) as average_power'))
                ->orderBy('tower_id')
                ->groupBy('siteid')
                ->get();
        } else {
            $data = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereDate('created_at', Carbon::today())
                ->select(DB::raw('AVG(power_dc) as average_power'))
                ->orderBy('tower_id')
                ->groupBy('siteid')
                ->get();
        }
        if (count($data)) {
            $arr = [];
            foreach ($data as $con) {
                $arr[] = number_format($con->average_power, 2, '.');
            }
            return response()->json([
                'success' => true,
                'data' => $arr
            ]);

        }

    }

    public function acDcChartAjax(Request $request, Company $company)
    {
        $towerIds = Tower::where('company_id', $company->id)->pluck('id');

        if ($request->short_type == 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $data = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    'siteid',
                    DB::raw('CAST((SUM(CASE WHEN llvd_fault = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS ac_available'),
                    DB::raw('CAST((SUM(CASE WHEN llvd_fault = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS dc_available'))
                ->groupBy('siteid')
                ->get();
        } else {
            $data = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereDate('created_at', Carbon::today())
                ->select(
                    'siteid',
                    DB::raw('CAST((SUM(CASE WHEN mains_fail = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS ac_available'),
                    DB::raw('CAST((SUM(CASE WHEN llvd_fault = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS dc_available')
                )
                ->groupBy('siteid')
                ->get();
        }
        if (count($data)) {
            $acData = [];
            $dcData = [];
            foreach ($data as $con) {
                $acData[] = $con->ac_available;
                $dcData[] = $con->dc_available;
            }
            return response()->json([
                'success' => true,
                'acData' => $acData,
                'dcData' => $dcData
            ]);

        }

    }

    public function powerSlabChartAjax(Request $request, Company $company)
    {
        $towerIds = Tower::where('company_id', $company->id)->pluck('id');

        if ($request->short_type == 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $p_slab = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    'siteid',
                    DB::raw('COUNT(CASE WHEN power_dc = 2 THEN 1 END) AS slot_1'),
                    DB::raw('COUNT(CASE WHEN power_dc > 2 AND power_dc <= 2.5 THEN 1 END) AS slot_2'),
                    DB::raw('COUNT(CASE WHEN power_dc > 2.5 AND power_dc <= 3 THEN 1 END) AS slot_3'),
                    DB::raw('COUNT(CASE WHEN power_dc > 3 AND power_dc <= 3.5 THEN 1 END) AS slot_4'),
                    DB::raw('COUNT(CASE WHEN power_dc > 3.5 AND power_dc <= 4 THEN 1 END) AS slot_5')
                )
                ->first();
        } else {
            $p_slab = DB::table('tower_data')
                ->whereIn('tower_id', $towerIds)
                ->where('power_dc', '!=', 'n')
                ->whereDate('created_at', Carbon::today())
                ->select(
                    'siteid',
                    DB::raw('COUNT(CASE WHEN power_dc = 2 THEN 1 END) AS slot_1'),
                    DB::raw('COUNT(CASE WHEN power_dc > 2 AND power_dc <= 2.5 THEN 1 END) AS slot_2'),
                    DB::raw('COUNT(CASE WHEN power_dc > 2.5 AND power_dc <= 3 THEN 1 END) AS slot_3'),
                    DB::raw('COUNT(CASE WHEN power_dc > 3 AND power_dc <= 3.5 THEN 1 END) AS slot_4'),
                    DB::raw('COUNT(CASE WHEN power_dc > 3.5 AND power_dc <= 4 THEN 1 END) AS slot_5')
                )
                ->first();
        }
        if ($p_slab) {

            return response()->json([
                'success' => true,
                'data' => [$p_slab->slot_1, $p_slab->slot_2, $p_slab->slot_3, $p_slab->slot_4, $p_slab->slot_5]
            ]);

        }

    }
}

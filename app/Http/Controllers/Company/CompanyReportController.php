<?php

namespace App\Http\Controllers\Company;

use App\Exports\AcPowerAvaililibilityReportExport;
use App\Exports\ActiveLoadReportExport;
use App\Exports\DcPowerAvaililibilityReportExport;
use App\Exports\AlarmHistoryExport;
use App\Exports\MainsFailExport;
use App\Exports\PowerConsumptionReportExport;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyCluster;
use App\Models\Tower;
use App\Models\TowerAlarmData;
use App\Models\TowerAlarmInfo;
use App\Models\TowerData;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CompanyReportController extends Controller
{
    public function report(Request $request, Company $company)
    {
        menuSubmenu('reports', '');
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $data = [];
        $data['company'] = $company;
        $data['zones'] = Zone::where('company_id', $company->id)->pluck('title', 'id');
        $data['site_ids'] = Tower::where('company_id', $company->id)->where('mno_site_id', '!=', null)->orderBy('mno_site_id', 'ASC')->get();
        $data['site_names'] = Tower::where('company_id', $company->id)->where('name', '!=', null)->orderBy('name', 'ASC')->get();
        $data['clusters'] = CompanyCluster::where('company_id', $company->id)->orderBy('title', 'ASC')->get();

        $data['has_bms'] = Tower::where('company_id', $company->id)->where('has_bms', 1)->orderBy('mno_site_id', 'ASC')->count();
        $data['towers_with_bms'] = Tower::where('company_id', $company->id)->where('has_bms', 1)->orderBy('mno_site_id', 'ASC')->get();

        if ($request->cluster_id) {
            $data['cluster'] = CompanyCluster::find($request->cluster_id);
        }
        if ($request->zone) {
            $data['zone'] = Zone::find($request->zone);
        }

        //Company Wise Tower Ids Start
        $data['towers'] = $tower_ids = Tower::where('company_id', $company->id)->where(function ($q) use ($request) {
            if ($request->report_type == 'BMS History') {
                $q->where('has_bms', 1);
            }
            if ($request->cluster_id) {
                $q->where('cluster_id', $request->cluster_id);
            } elseif ($request->zone) {
                $q->where('zone_id', $request->zone);
            }

            if ($request->site_id) {
                $q->whereIn('mno_site_id', $request->site_id);
            } elseif ($request->site_name) {
                $q->where('name', 'like', '%' . $request->site_name . '%');
            }

        })->pluck('id');

        //Company Wise Tower Ids Start

        if ($a = $request->report_type) {


            //Active Load Start
            if ($a == 'Active Load') {

                if ($request->export_type == 'active_load') {
                    return Excel::download(new ActiveLoadReportExport($tower_ids, $request), 'active_load_report.xlsx');
                }

                $data['datas'] = TowerData::with('tower.zone', 'tower.cluster')->whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('tower_data.created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('tower_data.created_at', $request->start_date);
                        }
                    })->orderBy('tower_data.created_at', 'DESC')
                    ->where('tower_data.power_dc', '!=', 'n')
                    ->join("towers", "towers.id", "=", "tower_data.tower_id")
                    ->join('zones', 'towers.zone_id', '=', 'zones.id')
                    ->join('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
                    ->leftJoin('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
                    ->select(
                        'tower_data.created_at',
                        'tower_data.siteid',
                        'tower_data.tower_name',
                        'upazilas.name as thana',
                        'zones.title as tower_zone',
                        'company_clusters.title as cluster_name',
                        'tower_data.power_dc'
                    )->orderBy('tower_data.created_at', "DESC")
                    ->paginate(50);
//                dd($data['datas']);

                $data['avarage_value'] = TowerData::whereIn('tower_id', $tower_ids)
                    ->where('power_dc', '!=', 'n')
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })
                    ->where('power_dc', '!=', 'n')
                    ->select('id')
                    ->avg('power_dc');

                return view('company.reports.companyTowerReport', $data);
            }
            //Active Load End

            //AC Power Availability Start
            if ($a == 'AC Power Availability') {

                if ($request->export_type == 'ac_power_availibility') {
                    return Excel::download(new AcPowerAvaililibilityReportExport($tower_ids, $request), 'ac_power_availibility.xlsx');
                }
                $data['datas'] = TowerData::whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })->orderBy('created_at', "DESC")
                    ->where('voltage_phase_a', '!=', 'n')
                    ->join("towers", "towers.id", "=", "tower_data.tower_id")
                    ->leftJoin('zones', 'towers.zone_id', '=', 'zones.id')
                    ->leftJoin('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
                    ->leftJoin('upazilas', 'towers.upazila_id', '=', 'upazilas.id')

                    ->select(
                        'tower_data.created_at',
                        'tower_data.siteid',
                        'upazilas.name as thana',
                        'zones.title as tower_zone',
                        'company_clusters.title',
                        'tower_data.voltage_phase_a',
                        'tower_data.voltage_phase_b',
                        'tower_data.voltage_phase_c',

                        'towers.name as tower_name',

                        'zones.title as tower_zone',
                        'company_clusters.title as cluster',
                        'tower_data.dc_voltage',
                        'tower_data.llvd_fault'
                    )
                    ->orderBy('tower_data.created_at',"DESC")
                    ->paginate(50);


                $ac_avg = DB::table('tower_data')
                    ->whereIn('tower_id', $tower_ids)
                    ->where('voltage_phase_a', '!=', 'n')
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 0 THEN 1 END) AS ac_available')
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 0 THEN mains_fail_duration END) AS ac_available_second')
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 1 THEN 1 END) AS ac_un_available')
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 1 THEN mains_fail_duration END) AS ac_un_available_second')
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })
                    ->first();

                $data['total_count'] = $total_count = $ac_avg->ac_available + $ac_avg->ac_un_available;
                $data['available'] = number_format($ac_avg->ac_available > 0 ? (($ac_avg->ac_available / $total_count) * 100) : 0, 0);
                $data['unavailable'] = number_format($ac_avg->ac_un_available > 0 ? (($ac_avg->ac_un_available / $total_count) * 100) : 0, 0);


//                dump($ac_avg->ac_un_availability)
                return view('company.reports.companyTowerReport', $data);
            }
            //AC Power Availability End

            //DC Power Availability Start
            if ($a == 'DC Power Availability') {

                if ($request->export_type == 'dc_power_availibility') {
                    return Excel::download(new DcPowerAvaililibilityReportExport($tower_ids, $request), 'dc_power_availibility.xlsx');
                }
                $data['datas'] = TowerData::with('tower')
                    ->whereIn('tower_data.tower_id', $tower_ids)
                    ->where('tower_data.dc_voltage', '!=', 'n')
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('tower_data.created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('tower_data.created_at', $request->start_date);
                        }
                    })
                    ->where('tower_data.dc_voltage', '!=', 'n')
                    ->join("towers", "towers.id", "=", "tower_data.tower_id")
                    ->leftJoin('zones', 'towers.zone_id', '=', 'zones.id')
                    ->leftJoin('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
                    ->leftJoin('upazilas', 'towers.upazila_id', '=', 'upazilas.id')
                    ->select(
                        'towers.name as tower_name',
                        'tower_data.created_at',
                        'tower_data.siteid',
                        'upazilas.name as thana',
                        'zones.title as tower_zone',
                        'company_clusters.title as cluster',
                        'tower_data.dc_voltage',
                        'tower_data.llvd_fault'
                    )
                    ->orderBy('tower_data.created_at',"DESC")
                    ->paginate(50);


                $dc_avg = DB::table('tower_data')
                    ->whereIn('tower_id', $tower_ids)
                    ->where('dc_voltage', '!=', 'n')
                    ->selectRaw('CAST((SUM(CASE WHEN llvd_fault = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS dc_available_percentage')
                    ->selectRaw('SUM(CASE WHEN llvd_fault = 0 THEN llvd_fail_duration END) AS dc_available_second')
                    ->selectRaw('CAST((SUM(CASE WHEN llvd_fault = 1 THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS DECIMAL(10,2)) AS dc_not_available_percentage')
                    ->selectRaw('SUM(CASE WHEN llvd_fault = 1 THEN llvd_fail_duration END)  AS dc_not_available_second')
                    ->first();

//                $data['total_count']=$total_count = $dc_avg->dc_available_percentage + $dc_avg->dc_not_available_percentage;
                $data['avg_dc_available'] = number_format($dc_avg->dc_available_percentage, 2);
                $data['avg_dc_available_sum'] = getSecondToHours($dc_avg->dc_available_second);
                $data['avg_dc_un_available'] = number_format($dc_avg->dc_not_available_percentage, 2);
                $data['avg_dc_un_available_sum'] = getSecondToHours($dc_avg->dc_not_available_second);

                return view('company.reports.companyTowerReport', $data);
            }
            //DC Power Availability End

            //Mains Fail Start
            if ($a == 'Mains Fail') {
                if ($request->export_type == 'mains_fail') {
                    return Excel::download(new MainsFailExport($tower_ids, $request), 'mains_fail.xlsx');
                }
                $data['datas'] = TowerData::with('tower')
                    ->whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })
                    ->where('mains_fail', 1)
                    ->orderBy('created_at', "DESC")
                    ->select('id', 'tower_id', 'tower_name', 'created_at', 'siteid', 'voltage_phase_a', 'voltage_phase_b', 'voltage_phase_c', 'current_phase_a', 'current_phase_b', 'current_phase_c')
                    ->paginate(50);


                $ac_avg = DB::table('tower_data')
                    ->whereIn('tower_id', $tower_ids)
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 1 THEN 1 END) AS mains_fail')
                    ->selectRaw('SUM(CASE WHEN  mains_fail = 1 THEN mains_fail_duration END) AS mains_fail_duration')
                    ->selectRaw('COUNT(CASE WHEN  mains_fail = 0 THEN 1 END) AS mains_not_fail')
                    ->selectRaw('SUM(CASE WHEN  mains_fail = 0 THEN mains_fail_duration END) AS mains_not_fail_duration')
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })
                    ->first();

                $data['total_count'] = $total_count = $ac_avg->mains_fail + $ac_avg->mains_not_fail;
                $data['mains_fail'] = number_format($ac_avg->mains_fail > 0 ? (($ac_avg->mains_fail / $total_count) * 100) : 0, 0);
                $data['mains_fail_sum'] = getSecondToHours($ac_avg->mains_fail_duration);

                return view('company.reports.companyTowerReport', $data);
            }
            //Mains Fail End

            //Power Consumption Start
            if ($a == 'Power Consumption') {

                if ($request->export_type == 'power_consumption') {
                    return Excel::download(new PowerConsumptionReportExport($tower_ids, $request), 'power_consumption.xlsx');
                }
                $data['datas'] = TowerData::with('tower')->whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })
                    ->orderBy('created_at', 'DESC')->paginate(50);


                $data['all_data'] = $getData = TowerData::with('tower')->whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('created_at', $request->start_date);
                        }
                    })->where(function ($q) {
                        $q->where('power_dc', '!=', 'n');
                    })
                    ->orderBy('created_at', 'DESC')->get();

// dd($getData);
                $data['load_one_avg'] = $L1 = $getData->avg('power_dc');


                return view('company.reports.companyTowerReport', $data);
            }
            //Power Consumption End

            //BMS History Start
            if ($a == 'BMS History') {
                $data['datas'] = TowerData::with('tower')->whereIn('tower_id', $tower_ids)
                    ->join("towers", "towers.id", "=", "tower_data.tower_id")
                    ->join('zones', 'towers.zone_id', '=', 'zones.id')
                    ->join('company_clusters', 'towers.cluster_id', '=', 'company_clusters.id')
                    ->select(
                        'tower_data.tower_name',
                        'tower_data.siteid as siteid',
                        'zones.title as tower_zone',
                        'company_clusters.title as cluster_name',
                        'tower_data.created_at',
                        'tower_data.chipid',
                        'tower_data.current',
                        'tower_data.voltage_of_pack',
                        'tower_data.soc',
                        'tower_data.soh',
                        'tower_data.cell_voltage_1',
                        'tower_data.cell_voltage_2',
                        'tower_data.cell_voltage_3',
                        'tower_data.cell_voltage_4',
                        'tower_data.cell_voltage_5',
                        'tower_data.cell_voltage_6',
                        'tower_data.cell_voltage_7',
                        'tower_data.cell_voltage_8',
                        'tower_data.cell_voltage_9',
                        'tower_data.cell_voltage_10',
                        'tower_data.cell_voltage_11',
                        'tower_data.cell_voltage_12',
                        'tower_data.cell_voltage_13',
                        'tower_data.cell_voltage_14',
                        'tower_data.cell_voltage_15',
                        'tower_data.cell_temperature_1',
                        'tower_data.cell_temperature_2',
                        'tower_data.cell_temperature_3',
                        'tower_data.cell_temperature_4'
                    )
                    ->where(function ($q) use ($request) {
                        if ($request->start_date && $request->end_date) {
                            $q->whereBetween('tower_data.created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                        } elseif ($request->start_date) {
                            $q->whereDate('tower_data.created_at', $request->start_date);
                        }
                    })
                    ->orderBy('tower_data.created_at', 'DESC')
                    ->paginate(50);
                // dd($data['datas'] );
                return view('company.reports.companyTowerReport', $data);
            }
            //BMS History End

            //Power Slab Start
            if ($a == 'Power Slab') {

                if ($request->export_type == 'power_slap') {
                    return Excel::download(new PowerSlapExport($tower_ids, $request), 'power_slave.xlsx');
                }

                $data['datas'] = TowerDataLoad::with('tower')->whereIn('tower_id', $tower_ids)->whereHas('tower', function ($qq) use ($request) {
                    if ($request->cluster_id) {
                        $qq->where('cluster_id', $request->cluster_id);
                    } elseif ($request->zone) {
                        $qq->where('zone_id', $request->zone);
                    }

                    if ($request->site_id) {
                        $qq->where('mno_site_id', $request->site_id);
                    } elseif ($request->site_name) {
                        $qq->where('name', 'like', '%' . $request->site_name . '%');
                    }
                })->where(function ($q) use ($request) {
                    if ($request->start_date && $request->end_date) {
                        $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                    } elseif ($request->start_date) {
                        $q->whereDate('created_at', $request->start_date);
                    }
                })
                    ->where('relation_id', '!=', null)
                    ->where('chip_id', '!=', null)->orderBy('tower_id')->orderBy('created_at', "DESC")->whereIn('id', $meaning_ids)->paginate(50);

                // dd($data['datas'] );


                //Power Slap
                return view('company.reports.companyTowerReport', $data);
            }
            //Power Slab End

            //Alarms History Start
            if ($a == 'Alarms History') {
                if ($request->export_type == 'alarm_history') {
                    return Excel::download(new AlarmHistoryExport($tower_ids, $request), 'alarm_history.xlsx');
                }
                $alarm = TowerAlarmInfo::where('title', $request->alarm_name)->first();
                $data['datas'] = TowerAlarmData::with('tower', 'tower.zone', 'tower.cluster')->whereIn('tower_id', $tower_ids)
                    ->where(function ($q) use ($alarm) {
                        if ($alarm) {
                            $q->where('tower_alarm_info_id', $alarm->id);
                        }
                    })
                    ->orderBy('created_at', 'DESC')
                    ->paginate(30);
                //data grid fail related
                return view('company.reports.companyTowerReport', $data);
            }
            //Alarms History End


            //SMU Lock History Start

            //SMU Lock History End



        }

        return view('company.reports.companyTowerReport', $data);
    }
}

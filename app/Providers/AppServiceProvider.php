<?php

namespace App\Providers;


use App\Models\Company;
use App\Models\TowerAlarmInfo;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrap();
        $web_companies =Company::orderBy('id','asc')->get();
        view::share('web_companies', $web_companies);
        $global_company=Company::find(Session::get('company_id'));
        view::share('global_company', $global_company);


        $alarmInfos = TowerAlarmInfo::groupBy('category')->get();
        view()->share('alarmInfoCats',$alarmInfos);
    }
}

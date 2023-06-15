
<?php
  if(is_object(request()->company)){
        $company = request()->company;
    }else{
        $company = \App\Models\Company::find(request()->company);
    }
$totalLockTowers = App\Models\Tower::where('company_id', $company->id)->whereHas('lockUnlockData')->count();

$towerOpenTowers = App\Models\Tower::where('company_id', $company->id)->whereHas('lockUnlockData', function ($q) {
    $q->where('door_open_at', '!=', null);
    $q->where('door_closed_at', null);
})->count();
$towerCloseTowers = App\Models\Tower::where('company_id', $company->id)->whereHas('lockUnlockData', function ($q) {
    $q->where('door_open_at', '!=', null);
    $q->where('door_closed_at', '!=', null);
})->count();

$total_tower = App\Models\Tower::where('company_id', $company->id)->count();
$online_tower = App\Models\Tower::where('company_id', $company->id)
    ->where('last_connected_at', '>', now()->subMinutes(4))
    ->count();

$total_tower = App\Models\Tower::where('company_id', $company->id)->count();
$online_tower = App\Models\Tower::where('company_id', $company->id)
    ->where('last_connected_at', '>', now()->subMinutes(4))
    ->count();

?>

<div class="sidebar" style="background-color: #096ba6">


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
{{--        Companies--}}

            <li class="nav-item {{ session('lsbm') == 'company_dashboard'? ' menu-open ' : ''}}">
                <a href="{{route('company.home',$company)}}" class="nav-link {{ session('lsbm') == 'company-infos'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
{{--            <li class="nav-item {{ session('lsbm') == 'company-infos'? ' menu-open ' : ''}}">--}}
{{--                <a href="{{route('company-infos.index',$company)}}" class="nav-link {{ session('lsbm') == 'company-infos'? ' active ' : ''}}">--}}
{{--                    <i class="nav-icon fas fa-chalkboard-teacher"></i>--}}
{{--                    <p>--}}
{{--                        Dashboard--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item {{ session('lsbm') == 'company_tenant'? ' menu-open ' : ''}}">
                <a href="{{route('company.tenant',$company)}}" class="nav-link {{ session('lsbm') == 'company_tenant'? ' active ' : ''}}">
                    <i class="nav-icon  fas fa-wifi"></i>
                    <p>
                       Tenants
                    </p>
                </a>
            </li>
            <li class="nav-item {{ session('lsbm') == 'rfidUsers'? ' menu-open ' : ''}}">
                <a href="{{route('company.rfid.users',$company)}}" class="nav-link {{ session('lsbm') == 'rfid_users'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-user-alt"></i>
                    <p>
                        Rfid Users
                    </p>
                </a>
            </li>
            {{--        Towers--}}
            <li class="nav-item {{ session('lsbm') == 'company-towers'? ' menu-open ' : ''}}">
                <a href="#" class="nav-link {{ session('lsbm') == 'company-towers'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-broadcast-tower"></i>
                    <p>
                        Towers
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('tower.lists',['company'=>$company])}}"
                           class="nav-link {{ session('lsbsm') == 'allRms' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Towers @if($total_tower > 0)<span class="badge badge-warning right">{{ $total_tower }}</span> @endif</p>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{route('tower.lists',['company'=>$company,'status'=>'online'])}}"
                           class="nav-link {{ session('lsbsm') == 'onlineRms' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Online Towers @if($online_tower > 0)<span class="badge badge-warning right">{{ $online_tower }}</span> @endif</p>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{route('tower.lists',['company'=>$company,'status'=>'offline'])}}"
                           class="nav-link {{ session('lsbsm') == 'offlineRms' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Offline RMS @if(($total_tower -$online_tower ) > 0)<span class="badge badge-warning right">{{ $total_tower -$online_tower }}</span> @endif</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ session('lsbm') == 'smuLock' ? ' menu-open ' : '' }}">
                <a href=""
                   class="nav-link ">
                    <i class="nav-icon fas fa-lock"></i>
                    <p>{{ __('SMU Lock') }} <i class="fas fa-angle-left right"></i></p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'total','company'=>$company]) }}"
                           class="nav-link {{ session('lsbsm') == 'allsmuLock' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Locks  @if($totalLockTowers > 0)<span class="badge badge-warning right">{{ $totalLockTowers }}</span> @endif</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'close','company'=>$company]) }}"
                           class="nav-link {{ session('lsbsm') == 'closesmuLock' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Close Locks  @if($towerCloseTowers > 0) <span class="badge badge-warning right">{{ $towerCloseTowers }}</span>@endif</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'open','company'=>$company]) }}"
                           class="nav-link {{ session('lsbsm') == 'opensmuLock' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Open Locks  @if($towerOpenTowers > 0) <span class="badge badge-warning right">{{ $towerOpenTowers }}</span>@endif</p>
                        </a>
                    </li>


                </ul>
            </li>

            <li class="nav-item {{ session('lsbm') == 'alarmsAll' ? ' menu-open ' : '' }}">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-bell"></i>
                    <p>{{ __('Alarms') }} <i class="fas fa-angle-left right"></i></p>
                </a>

                <ul class="nav nav-treeview">
                    @foreach ($alarmInfoCats as $cat)
                        @foreach ($cat->catChildren() as $child)
                            <?php $alert_count = $child->companyLiveCatAlarmCount($company->id); ?>
                            <li class="nav-item ">
                                <a href="{{ route('company.companyTowerAlarms', ['company' => $company, 'title' => $child->title]) }}"
                                   class="nav-link {{ request()->title == $child->title ? ' active ' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $child->title }} <span
                                            class="badge badge-warning right">{{ $alert_count }}</span> </p>
                                </a>
                            </li>
                        @endforeach
                    @endforeach

                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ route('company.reports', $company) }}"
                   class="nav-link {{ session('lsbm') == 'reports' ? ' active ' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>{{ __('Reports') }}</p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>

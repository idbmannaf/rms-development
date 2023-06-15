<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
{{--    <div class="user-panel mt-3 pb-3 mb-3 d-flex">--}}
{{--        <div class="image">--}}
{{--            <img src="{{asset('/')}}assets/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
{{--        </div>--}}
{{--        <div class="info">--}}
{{--            <a href="#" class="d-block">{{ env('APP_NAME') }}</a>--}}
{{--        </div>--}}
{{--    </div>--}}


<!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item {{ session('lsbm') == 'users'? ' menu-open ' : ''}}">
                <a href="#" class="nav-link {{ session('lsbm') == 'users'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        User
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('users.index')}}"
                           class="nav-link {{session('lsbsm') =='all-users'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users.create')}}"
                           class="nav-link {{session('lsbsm') =='create-users'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create User</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{--            User Role--}}
            <li class="nav-item {{ session('lsbm') == 'user-roles'? ' menu-open ' : ''}}">
                <a href="#" class="nav-link {{ session('lsbm') == 'user-roles'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-diagnoses"></i>
                    <p>
                        User Role
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('user-roles.index')}}"
                           class="nav-link {{session('lsbsm') =='all-user-roles'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All User Role</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('user-roles.create')}}"
                           class="nav-link {{session('lsbsm') =='create-user-roles'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create User Role</p>
                        </a>
                    </li>
                </ul>
            </li>
            {{--        Companies--}}
            <li class="nav-item {{ session('lsbm') == 'companies'? ' menu-open ' : ''}}">
                <a href="#" class="nav-link {{ session('lsbm') == 'companies'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>
                        Company
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('companies.index')}}"
                           class="nav-link {{session('lsbsm') =='all-companies'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Companies</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('companies.create')}}"
                           class="nav-link {{session('lsbsm') =='create-company'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create Company</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{--        Towers--}}
            <li class="nav-item {{ session('lsbm') == 'admin-company-towers'? ' menu-open ' : ''}}">
                <a href="#" class="nav-link {{ session('lsbm') == 'admin-company-towers'? ' active ' : ''}}">
                    <i class="nav-icon fas fa-building"></i>
                    <p>
                        Tower
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('towers.index')}}"
                           class="nav-link {{session('lsbsm') =='admin-company-towers'?'active':''}}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Towers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('towers.index',['status'=>'online'])}}"
                           class="nav-link {{ session('lsbsm') == 'adminOnlineRms' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Online Towers</p>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="{{route('towers.index',['status'=>'offline'])}}"
                           class="nav-link {{ session('lsbsm') == 'adminOfflineRms' ? 'active ' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Offline Towers</p>
                        </a>
                    </li>
                    <a href="{{route('towers.create')}}"
                       class="nav-link {{session('lsbsm') =='create-tower'?'active':''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Tower</p>
                    </a>
                    </li>
                </ul>
            </li>

            {{--            Tower Data --}}
            {{--            <li class="nav-item">--}}
            {{--                <a href="{{route('grid_data')}}" class="nav-link {{session('lsbsm') =='grid_data'?'active':''}}">--}}
            {{--                    <i class="fas fa-th nav-icon"></i>--}}
            {{--                    <p>Grid Data</p>--}}
            {{--                </a>--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a href="{{route('alarms.index')}}" class="nav-link {{session('lsbsm') =='alarm'?'active':''}}">
                    <i class="fas fa-bell nav-icon"></i>
                    <p>Alarm</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('device.index')}}" class="nav-link {{session('lsbsm') =='device'?'active':''}}">
                    <i class="fas fa-dev nav-icon"></i>
                    <p>Device</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>

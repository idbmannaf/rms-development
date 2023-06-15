<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RMS- @stack('title') </title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/logo/rms.jpg')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/plugins/summernote/summernote-bs4.min.css">
    {{--switch--}}
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    {{--Notification--}}
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/toastifyNotification/toastify.min.css">
    {{------}}
    {{--    select2--}}
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.css" rel="stylesheet"/>
{{--    ---------------------}}

    @stack('css')
    <style>
        .main-sidebar.sidebar-dark-primary.elevation-4 {
            background-color: #096ba6!important;
        }
        .bg-card-header{
            background: #096ba6 !important;
            color: #fff;
        }
        .btn-sarbs-one{
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: none;
        }
        .btn-sarbs-one:hover{
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .blink_me {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .td-center{
            text-align: center; /* Horizontal centering */
            vertical-align: middle; /* Vertical centering */
        }
    </style>

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">

    <!-- Preloader -->
{{--    <div class="preloader flex-column justify-content-center align-items-center">--}}
{{--        <img class="animation__shake" src="{{asset('/')}}assets/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">--}}
{{--    </div>--}}

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">--}}
{{--                    <i class="fas fa-th-large"></i>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" role="button">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    @if(Auth::user()->hasUserRole('admin'))
                        <a class="dropdown-item" href="{{route('admin.home')}}">
                            <i class="fas fa-user-alt"></i> Admin Dashboard
                        </a>
                        @foreach($web_companies as $company)
                            <a class="dropdown-item" href="{{route('company.home',$company->id)}}">
                                <i class="fas fa-leaf"></i> {{$company->name}}
                            </a>
                        @endforeach
                    @endif

                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalLong">
                        <i class="fas fa-lock"></i> Change Password
                    </a>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                        <i class="fas fa-power-off"></i> Logout
                    </a>
                    <form action="{{route('logout')}}" method="POST" id="logoutForm">
                        @csrf
                    </form>


                </div>

            </li>
        </ul>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pt-2 pb-2 bg-info">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.change-password')}}" id="change-password" method="POST">
                        @csrf
{{--                        <div class="form-group mb-2">--}}
{{--                            <label for="" class="mb-2">Old Password:</label>--}}
{{--                            <input required id="old_password" type="password" class="form-control" name="old_password">--}}
{{--                            <div class="d-none" id="verify_old_password"></div>--}}
{{--                        </div>--}}
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">New Password:</label>
                            <input required id="password" type="password" class="form-control" name="password">
                            @error('password')
                            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="mb-2">Confirm Password:</label>
                            <input required id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                            <div class="d-none" id="verify_confirm_password"></div>

                        </div>
                        <div class="form-group mb-2">
                            <input type="submit" class="form-control bg-success" name="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('admin.home')}}" class="brand-link">
            <img src="{{asset('/')}}assets/logo/rms.jpg" alt="RMS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>

        <!-- Sidebar -->
        @include('admin.layout.left_sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @yield('body')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2023 <a href="#">{{ env('APP_NAME') }}</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/')}}assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/')}}assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/')}}assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('/')}}assets/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{asset('/')}}assets/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{asset('/')}}assets/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/')}}assets/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{asset('/')}}assets/admin/plugins/moment/moment.min.js"></script>
<script src="{{asset('/')}}assets/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/')}}assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{asset('/')}}assets/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/')}}assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('/')}}assets/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
{{--<script src="{{asset('/')}}assets/admin/dist/js/demo.js"></script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/')}}assets/admin/dist/js/pages/dashboard.js"></script>

{{--switch--}}
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

{{--Notification--}}
<script src="{{asset('/')}}assets/admin/toastifyNotification/toastify.js"></script>
{{------}}
{{--select--}}
<script src="https://rawgit.com/select2/select2/master/dist/js/select2.full.js"></script>
{{-------------}}
<script>
    @if(Session::has('success'))
    Toastify({ text: "{{ Session::get('success') }}", duration: 2000,
        style: { background:'#3e935c' },
    }).showToast();

    @elseif(Session::has('warning'))
    Toastify({ text: "{{ Session::get('warning') }}", duration: 2000,
        // style: { background: "linear-gradient(to right, #00b09b, #96c93d)" }
        style: { background:'#d7ab16' },
    }).showToast();

    @elseif(Session::has('error'))
    Toastify({ text: "{{ Session::get('error') }}", duration: 2000,
        // style: { background: "linear-gradient(to right, #00b09b, #96c93d)",
        //     color:'#f51804'
        // }
        style: { background:'#de0a0a' },
    }).showToast();
    @endif
</script>

<script>
    $(".my-select").select2({
        // containerCssClass: "pink",
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass($(data.element).attr("class"));
            }
            return data.text;
        }
    });
</script>

<script>
    $(document).on('input','#old_password',function () {
        var old_password=$(this).val();
        // console.log(old_password);
        $('#verify_old_password').removeClass('d-none');

        $.ajax({
            {{--url:"{{route('admin.password-verify')}}",--}}
            type:"GET",
            data:{
                old_password:old_password,
            },
            success:function(response){
                if(response.status){
                    let content=''
                    // document.getElementById('verify_old_password').removeClass('d-none');
                    // $('#verify_old_password').removeClass('d-none');
                    if(response.msg=='1'){
                        content_v =`<p class="font-weight-bold text-success">Password Matched</p>`
                        document.getElementById('verify_old_password').innerHTML=content_v;
                    }
                    else{
                        content_v = `<p class="font-weight-bold text-danger">Password Does Not Match</p>`
                        document.getElementById('verify_old_password').innerHTML=content_v;
                    }
                    // console.log(response.msg);
                }
                else{
                    alert('please try again');
                }
            },
            error:function (err) {
                console.log(err);
            }
        });
    })
    // $("#password_confirmation")
    $(document).on('input','#password_confirmation',function () {
        let password=$("#password").val();
        $('#verify_confirm_password').removeClass('d-none');
        let confirm_pass=$(this).val();
        let content_v='';
        if(password==confirm_pass){
            content_v = `<p class="font-weight-bold text-success">Confirm Password</p>`
            document.getElementById('verify_confirm_password').innerHTML=content_v;
        }else{
            console.log(password,confirm_pass);
            content_v = `<p class="font-weight-bold text-danger">Do not Confirm Password</p>`
            document.getElementById('verify_confirm_password').innerHTML=content_v;
        }
    })
</script>
@stack('script')
</body>
</html>

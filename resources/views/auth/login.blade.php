<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ env('APP_NAME') }} </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('se/assets/img/favicon.ico') }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <link rel="stylesheet" href="{{asset('se/assets/css/bootstrap.min.css')}}"> --}}

    <link rel="stylesheet" href="{{ asset('assets/auth/css/w3.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/auth/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/auth/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/auth/dist/css/adminlte.min.css') }}">
    {{--Notification--}}
    <link rel="stylesheet" href="{{asset('/')}}assets/admin/toastifyNotification/toastify.min.css">
    {{------}}
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}"
          rel="stylesheet">
    <style>
        .login-page {
            background: linear-gradient(90deg, rgba(5, 130, 153, 0.84), #295d99);
        }

        .login-logo a, .register-logo a {
            color: #f8f9fa;
        }

    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo w3-border w3-round bg-blue">
        <a class="w3-border p-2 w3-round bg-blue font-weight-bold" href="{{ url('/') }}">   {{ env('APP_NAME') }} </a>
    </div>
    <!-- /.login-logo -->
    <div class="card rounded-lg" style="box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 8px 12px -6px #2196f3;">
        <div class="card-body login-card-body rounded">
            <p class="login-box-msg"><i class="fa fa-lock"></i> Secure Login </p>

            <form action="{{route('login')}}"  method="POST">
                @csrf
                @method("POST")
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                           value="{{ old('username') }}" required autocomplete="username" autofocus
                           placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           autocomplete="current-password" placeholder="Password" required="" id="id_password">

                    <div class="input-group-text">
                        <i class="fa fa-eye" id="togglePassword"></i>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="input-group mb-3">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-primary btn-block"><b>Login</b></button>
                </div>


            </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('assets/auth/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/auth/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/auth/dist/js/adminlte.min.js') }}"></script>
{{--Notification--}}
<script src="{{asset('/')}}assets/admin/toastifyNotification/toastify.js"></script>
{{------}}
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
        style: { background:'rgba(241,37,10,0.79)', color:'#fafafa'},
    }).showToast();
    @endif
</script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>


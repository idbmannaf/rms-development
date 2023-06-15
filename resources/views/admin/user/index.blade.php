@extends('admin.layout.master')
@push('title')
    Admin | Users
@endpush
@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card p-0">
                        <div class="card-header bg-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">All Users</h3>
                                <a href="{{route('users.create')}}" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th width="20">SL NO</th>
                                    <th width="100">Action</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
{{--                                    <th>Active</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = (($users->currentPage() - 1) * $users->perPage() + 1); ?>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-success dropdown-toggle no-print" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu dropdown-index-" aria-labelledby="dropdownMenuButton">
{{--                                                    <a class="dropdown-item" href="">view</a>--}}
                                                    <a class="dropdown-item" href="{{route('users.edit',$user->id)}}">Edit</a>

                                                    <form action="{{route('users.destroy',$user->id)}}" method="POST" id="deleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item" onclick="return confirm('Are you sure?');">Delete</button>
                                                    </form>
{{--                                                    <a class="dropdown-item" href="">Change Password</a>--}}
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#password-change{{$user->id}}">Change Password
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->mobile}}</td>
{{--                                        <td>--}}
{{--                                            <input type="checkbox" name="toogle" value="" data-toggle="toggle" data-size="sm" data-on="On"  data-off="Off" data-onstyle="success" data-offstyle="danger">--}}
{{--                                        </td>--}}
                                    <!-- Modal -->
                                        <div class="modal fade" id="password-change{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header pt-2 pb-2 bg-info">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.user.change-password',$user->id)}}" id="change-password" method="POST">
                                                            @csrf
                                                            {{--                        <div class="form-group mb-2">--}}
                                                            {{--                            <label for="" class="mb-2">Old Password:</label>--}}
                                                            {{--                            <input required id="old_password" type="password" class="form-control" name="old_password">--}}
                                                            {{--                            <div class="d-none" id="verify_old_password"></div>--}}
                                                            {{--                        </div>--}}
                                                            <div class="form-group mb-2">
                                                                <label for="" class="mb-2">New Password:</label>
                                                                <input required id="user_password" type="password" class="form-control" name="password">
                                                                @error('password')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <label for="" class="mb-2">Confirm Password:</label>
                                                                <input required id="user_password_confirmation" type="password" class="form-control" name="password_confirmation">
                                                                <div class="d-none" id="user_verify_confirm_password"></div>

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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="float-right mr-3 mt-3 small" style="font-size:12px"  >
                                {{$users->links()}}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('script')
    <script>
        $(document).on('input','#user_password_confirmation',function () {
            let password=$("#user_password").val();
            $('#user_verify_confirm_password').removeClass('d-none');
            let confirm_pass=$(this).val();
            let content_v='';
            if(password==confirm_pass){
                content_v = `<p class="font-weight-bold text-success">Confirm Password</p>`
                document.getElementById('user_verify_confirm_password').innerHTML=content_v;
            }else{
                console.log(password,confirm_pass);
                content_v = `<p class="font-weight-bold text-danger">Do not Confirm Password</p>`
                document.getElementById('user_verify_confirm_password').innerHTML=content_v;
            }
        })
    </script>
@endpush


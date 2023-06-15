@extends('admin.layout.master')
@push('title')
    Admin | User Role
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card p-0">
                        <div class="card-header bg-info">
                            <h3 class="card-title">All User Roles</h3>
                        </div>

                        <div class="card-body p-0 m-0">
                            <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th width="20">SL NO</th>
                                    <th width="100">Action</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Role Name</th>
                                    <th>Role Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = (($user_roles->currentPage() - 1) * $user_roles->perPage() + 1); ?>
                                @foreach($user_roles as $user_role)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-success dropdown-toggle no-print" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu dropdown-index-" aria-labelledby="dropdownMenuButton">
{{--                                                    <a class="dropdown-item" href="">view</a>--}}
                                                    <a class="dropdown-item" href="{{route('user-roles.edit',$user_role->id)}}">Edit</a>
                                                    <form action="{{route('user-roles.destroy',$user_role->id)}}" method="POST" id="deleteForm">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item" onclick="return confirm('Are you sure?');">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$user_role->user->username}}</td>
                                        <td>{{$user_role->user->email}}</td>
                                        <td>{{$user_role->role_name}}</td>
                                        <td>{{$user_role->role_value}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="float-right mr-3 mt-3 small" style="font-size:12px"  >
{{--                                {{$users->links()}}--}}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection


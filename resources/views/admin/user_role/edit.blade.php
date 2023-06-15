@extends('admin.layout.master')
@push('title')
    Admin | User Role Create
@endpush
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px)!important;
        }
    </style>
@endpush
@section('body')
    <section class="pt-3">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">User Role Edit</h3>
            </div>
            <form action="{{route('user-roles.update',$user_role->id)}}" method="POST">
                @csrf
                @method("PUT")
                <div class="card-body pb-0">
                    <div class="form-group">
                        <label for="">User Name</label>
                        <input type="text" class="form-control" value="Name: {{$user_role->user->username}}, Email: {{$user_role->user->email}}" readonly>
                        <input type="hidden" class="form-control" name="user_id" value="{{$user_role->user_id}}" >

                        @error('user_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Role Value</label>
                        <select name="role_name" class="form-control" required>
                            <option disabled >--  Select Role --</option>
                            <option value="admin" {{$user_role->role_name=='admin'? 'selected':''}}>Admin</option>
{{--                            <option value="super_admin" {{$user_role->role_name=='super_admin'? 'selected':''}}>Super Admin</option>--}}
                            <option value="company_admin" {{$user_role->role_name=='company_admin'? 'selected':''}}>Company Admin</option>
                        </select>
                        @error('role_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success form-control" value="Update User's Role">
                </div>
            </form>
        </div>
    </section>
@endsection

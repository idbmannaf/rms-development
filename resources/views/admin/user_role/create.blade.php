@extends('admin.layout.master')
@push('title')
    Admin | User Role Create
@endpush
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
    </style>
@endpush
@section('body')
    <section class="pt-3">
        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">User Role Create</h3>
                    </div>
                    <form action="{{ route('user-roles.store') }}" method="post">
                        @csrf
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="">User Name</label>
                                <select name="user_id" id="" class="form-control select2 my-select" required>
                                    <option disabled>-- Select User Name --</option>
                                    @foreach ($users as $user)
                                        @if ($user->hasUserRoleId($user->id))
                                            <option disabled value="{{ $user->id }}">UserName: {{ $user->username }} &
                                                Email:
                                                {{ $user->email }} </option>
                                        @else
                                            <option value="{{ $user->id }}">UserName: {{ $user->username }} & Email:
                                                {{ $user->email }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Role Value</label>
                                <select name="role_name" class="form-control" required>
                                    <option disabled>-- Select Role --</option>
                                    <option selected value="admin">Admin</option>
{{--                                    <option vIndexController alue="company_admin">Company Admin</option>--}}
                                </select>
                                @error('role_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-success form-control" value="Create New User's Role">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

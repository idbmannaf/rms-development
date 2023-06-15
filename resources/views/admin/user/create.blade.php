@extends('admin.layout.master')
@push('title')
    Admin | Create Users
@endpush

@section('body')
    <section class="pt-3">
        <div class="card card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create Users</h3>
                    <a href="{{route('users.index')}}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                </div>
            </div>
            <form action="{{route('users.store')}}" method="post">
                @csrf
                <div class="card-body pb-0">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control mb-2" value="{{old('name')}}" required placeholder="Enter Name">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">User Name</label>
                        <input type="text" name="username" class="form-control mb-2" value="{{old('username')}}" required placeholder="Enter User Name">
                        @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control mb-2" value="{{old('email')}}" required placeholder="Enter Email">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Mobile</label>
                        <input type="text" name="mobile" class="form-control mb-2" value="{{old('mobile')}}" placeholder="Enter mobile">
                        @error('mobile')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control mb-2" value="{{old('password')}}" required placeholder="Enter Password">
                        @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success form-control" value="Create New User">
                </div>
            </form>
        </div>
    </section>
@endsection

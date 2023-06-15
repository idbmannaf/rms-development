@extends('company.layout.master')
@push('title')
    Company | Edit
@endpush
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px)!important;
        }
        input.form-control-file {
            height: calc(2.25rem + 2px);
            padding: 0.205rem .2rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
        }
    </style>
@endpush
@section('body')
    <section class="pt-3">
        <div class="card card-info">
            <div class="card-header bg-card-header">
                <h5 class=""> Edit</h5>
            </div>
            <form action="{{route('company-infos.update',$company->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body pb-0">
                    <div class="form-group">
                        <label for="">User Name</label>

                        <input type="text" class="form-control" value="{{$company->user->username??old('user_id')}}" readonly>
                        <input type="hidden" name="user_id" class="form-control" value="{{$company->user->id??old('user_id')}}">

                        @error('user_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Company Name</label>
                        <input type="text" name="name" class="form-control" value="{{$company->name??old('name')}}" placeholder="Enter Company Name...">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" value="{{$company->address??old('address')}}" placeholder="Enter Address...">
                        @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">Company Logo</label>
                        <input type="file" class="form-control-file" name="logo" value="{{old('logo')}}">
                        @if($company->logo)
                            <img src="{{asset('/')}}{{$company->logo}}" alt="" class="my-2" height="150" width="150">
                        @endif
                        @error('logo')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="number" name="edited_by_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}" hidden>

                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-sarbs-one form-control" value="Update">
                </div>
            </form>
        </div>
    </section>
@endsection

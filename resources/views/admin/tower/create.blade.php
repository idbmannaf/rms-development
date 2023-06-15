@extends('admin.layout.master')
@push('title')
    Admin | Create Tower
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
        <div class="row">
            <div class="col-12 col-md-6 m-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create Tower</h3>
                            <a href="{{route('towers.index')}}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <form action="{{route('towers.store')}}" method="post">
                        @csrf
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="">Company Name</label>
                                <select name="company_id" id="" class="form-control select2 my-select" required>
                                    <option disabled >--  Select Company Name --</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Tower Name</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter Tower Name...">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Chipid</label>
                                <input type="text" name="chipid" class="form-control" value="{{old('chipid')}}" placeholder="Enter Chipid...">
                                @error('chipid')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Sim Number</label>
                                <input type="text" name="sim_number" class="form-control" value="{{old('sim_number')}}" placeholder="Enter sim number...">
                                @error('sim_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="Enter Address...">
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="number" name="added_by_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}" hidden>
                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-success form-control" value="Create New Tower">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

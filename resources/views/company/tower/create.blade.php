@extends('company.layout.master')
@push('title')
    Company | Tower Create
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
                        <h3 class="card-title">Tower Create</h3>
                    </div>
                    <form action="{{route('company.tower.store',$company)}}" method="post">
                        @csrf
                        <div class="card-body pb-0">
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

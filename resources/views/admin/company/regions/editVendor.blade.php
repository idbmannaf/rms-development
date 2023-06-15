@extends('admin.layout.master')
@push('title')
    Admin | Vendor Edit
@endpush

@section('body')
    <section class="content">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Vendor
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('updateVendor',['company'=>$company,'vendor'=>$vendor])}}" class="form-group" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" id="" value="{{$vendor->title}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Description</label>
                                        <input type="text" class="form-control" name="description" value="{{$vendor->description}}" id="">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <label for=""><input type="checkbox"  name="active" id="" {{$vendor->active == 1 ? "checked" : ''}}></label> Active

                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

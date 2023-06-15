@extends('admin.layout.master')
@push('title')
    Admin | Cluster Edit
@endpush
@push('css')
@endpush

@section('body')
    <section class="content">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Cluster
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('updateCluster',['company'=>$company,'cluster'=>$cluster])}}" class="form-group" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" id="" value="{{$cluster->title}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Description</label>
                                        <input type="text" class="form-control" name="description" value="{{$cluster->description}}" id="">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <label for=""><input type="checkbox"  name="active" id="" {{$cluster->active == 1 ? "checked" : ''}}></label> Active

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

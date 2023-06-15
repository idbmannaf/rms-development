@extends('admin.layout.master')
@push('title')
    Admin | Edit Region
@endpush
 @push('css')
     <!-- Select2 -->
     <link rel="stylesheet" href="{{ asset('cp/plugins/select2/css/select2.min.css') }}">
     <link rel="stylesheet" href="{{ asset('cp/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
 @endpush
@section('body')
    <section class="content">
        <br>

        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header bg-card-header">
                    <h3 class="card-title">
                        Edit Region
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('updateRegion',['company'=>$company,'region'=>$region])}}" class="form-group" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" id="" value="{{$region->title}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Description</label>
                                        <input type="text" class="form-control" name="description" value="{{$region->description}}" id="">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <label for=""><input type="checkbox"  name="active" id="" {{$region->active == 1 ? "checked" : ''}}></label> Active

                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="submit" class="btn btn-sm btn-sarbs-one">Submit</button>
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

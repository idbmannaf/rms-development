@extends('admin.layout.master')
@push('title')
    Admin | Edit SiteCode
@endpush
@push('css')
@endpush

@section('body')
    <section class="content">

        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        Zone
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('updatepostsiteCode',['company'=>$company,'scode'=>$scode])}}" class="form-group" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Region</label>
                                        <select name="region" id="" class="form-control">
                                            <option value="{{$scode->region_id}}" selected>{{$scode->region ? $scode->region->title : ''}}</option>
                                            @if (isset($regions))
                                            @foreach ($regions as $re)
                                                <option value="{{$re->id}}">{{$re->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="">Zone</label>
                                        <select name="zone" id="" class="form-control">
                                            <option value="{{$scode->zone_id}}" selected>{{$scode->zone ? $scode->zone->title : ''}}</option>

                                            @if (isset($zones))
                                            @foreach ($zones as $re)
                                                <option value="{{$re->id}}">{{$re->title}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Title</label>
                                        <input type="text" class="form-control" name="title" id="" value="{{$scode->title}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Description</label>
                                        <input type="text" class="form-control" name="description" value="{{$scode->description}}" id="">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <label for=""><input type="checkbox"  name="active" id="" {{$scode->active == 1 ? "checked" : ''}}></label> Active

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

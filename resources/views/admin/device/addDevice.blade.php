@extends('admin.layout.master')
@push('title')
    Admin | Active Devices
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
            <div class="col-12 m-auto">
                <div class="card card-info">
                    <div class="card-header bg-card-header">
                       <div class="d-flex justify-content-between align-items-center">
                           <h5>All Device</h5>
                           <a href="" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#addDevice" data-whatever="@fat">Add Device</a>
                       </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th>Action</th>
                                    <th>Device Name</th>
                                    <th>Active Tower</th>
                                </tr>
                                @foreach($devices as $device)
                                    <tr>
                                        <td> <a href="" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#edit{{$device->id}}" data-whatever="@fat"><i class="fas fa-edit"></i></a></td>
                                    <td>{{$device->device_name}}</td>
                                    <td>NA</td>
                                    </tr>

{{--                                ///Edit--}}
                                    <div class="modal fade" id="edit{{$device->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-sarbs-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Device</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('device.update',$device)}}" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="">Device Name</label>
                                                            <input type="text" name="device_name" class="form-control" value="{{$device->device_name ?: old('device_name')}}" placeholder="Enter Device Name...">
                                                        </div>
                                                        @php
                                                            $dataArray= explode(',',$device->column_name);
                                                        @endphp
                                                        <div class="form-group">
                                                        <input type="submit" class="btn btn-success">
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </table>
                        </div>
                    </div>
{{--                    ADDDD --}}
                    <div class="modal fade" id="addDevice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-sarbs-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Device</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('device.store')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Device Name</label>
                                            <input type="text" name="device_name" class="form-control" value="{{old('device_name')}}" placeholder="Enter Device Name...">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@extends('admin.layout.master')
@push('title')
    Admin | Active Devices
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
            <div class="col-12  m-auto">
                <div class="card">
                    <div class="card-header bg-card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="">Active Devices Of Tower: {{$tower->name}}</h5>
                            <a href="{{route('admin.tower.active_device.create',$tower)}}" class="btn btn-sarbs-one">Add Device</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderd table-sm">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Action</th>
                                        <th>Device Name</th>
                                        <th>Active Field</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                ?>
                                @foreach($active_devices as $dev)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <a href="{{route('admin.tower.active_device.edit',[$dev,$tower])}}" class="btn btn-xs btn-sarbs-one"> <i class="fas fa-edit"></i> </a>
                                            <a href="{{route('admin.tower.active_device.delete',[$dev,$tower])}}" onclick="event.preventDefault(); document.getElementById('delete_device{{$dev->id}}').submit();" class="btn btn-xs btn-warning"> <i class="fas fa-trash"></i> </a>
                                            <form action="{{route('admin.tower.active_device.delete',[$dev,$tower])}}" method="POST" id="delete_device{{$dev->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                        <td>{{$dev->device ? $dev->device->device_name : ''}}</td>
                                        <td>
                                        @foreach(explode(',',$dev->active_column) as $column_name)
                                            <span class="badge badge-success">{{$column_name}}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('.select2').select2({
            placeholder: 'select Device'
        });
    </script>
@endpush

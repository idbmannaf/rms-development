@extends('company.layout.master')
@push('title')
    Company | Tower
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-0">
                        <div class="card-header bg-card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Active Device Of Tower/RMS: {{$tower->name}}
                                    ({{$tower->mno_site_id}})</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($active_devices as $active_device)
                                    <div class="col-12 col-md-3">
                                        <a href="{{route('company.activeDevice.details',[$company,$tower,$active_device])}}" class="card" style="background-color: #3670d4 !important; color:#fff;">
                                            <div class="card-body text-center">
                                                {{$active_device->device->device_name}}
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')

@endpush


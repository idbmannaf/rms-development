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
                                <h3 class="card-title">{{ucfirst($status)}} Towers</h3>
                                <div>
                                    <a class="btn btn-sarbs-one btn-sm" href="{{route('company.companyTowerStatusExport',[$company])}}">Export</a>
                                    <a href="{{route('company.tower.create',$company)}}" class="btn btn-sm btn-warning"><i
                                            class="fas fa-plus"></i> Add</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <div class="table-responsive">
                                <table class="table table-sm  table-bordered table-striped text-nowrap">
                                    <thead>
                                    <tr>
                                        <th width="20">#SL</th>
                                        <th width="100">Action</th>
                                        <th>Status</th>
                                        <th>Last Connected</th>
                                        <th>MNO Site ID</th>
                                        <th>Mains Fail</th>
                                        <th>DC Low Voltage</th>
                                        <th>Module Fault</th>
                                        <th>llvd Fault</th>
                                        <th>Smoke Alarm</th>
                                        <th>Fan Fault</th>
                                        <th>High Temp.</th>
                                        <th>Door Alarm</th>
                                        <th>Site Name</th>
                                        <th>Thana</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = (($towers->currentPage() - 1) * $towers->perPage() + 1); ?>
                                    @forelse($towers as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>
                                                <a href="{{route('company.tower.edit',[$company,$item->id])}}" title="Edit" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="{{route('company-towers.towerWiseRmsData',[$company,$item])}}" title="Data" class="btn btn-outline-warning btn-sm"><i class="fas fa-th"></i></a>
                                                <a href="{{route('company-towers.towerWiseAlarmData',[$company,$item])}}" title="Alarms" class="btn btn-outline-secondary btn-sm"><i class="fas fa-bell"></i></a>
                                                <a href="{{route('company.activeDevices',[$company,$item])}}" title="Active Device" class="btn btn-outline-success btn-sm"><i class="fas fa-microchip"></i></a>
                                                @if($item->smu_lock)
                                                    <a href="{{route('company-towers.towerWiseSMUData',[$company,$item->id])}}" title="SMU" class="btn btn-outline-danger btn-sm"><i class="fas fa-lock"></i></a>
                                                @endif
                                                @if($item->has_bms)
                                                    <a href="{{route('company-towers.towerWiseBMSData',[$company,$item->id])}}" title="BMS" class="btn btn-outline-warning btn-sm"><i class="fas fa-battery-full"></i></a>
                                                @endif
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->last_connected_at > now()->subMinutes(4))
                                                 <i class="fas fa-circle blink_me text-success"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif

                                            </td>
                                            <td>{{ $item->last_connected_at  }}</td>
                                            <td>{{ $item->mno_site_id  }}</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->mains_fail)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->dc_low_voltage)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->module_fault)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->llvd_fault)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->smoke_alarm)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->fan_fault)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->high_temp)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->door_alarm)
                                                <i class="fas fa-circle blink_me text-danger"></i>
                                                @else
                                                    <i class="fas fa-circle  text-secondary"></i>
                                                @endif
                                            </td>

                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->upazila_name}}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-danger text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{$towers->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')
    <script>
        $(document).on('change', 'input[name=toggle]', function(){
            // alert(1);
            var mode=$(this).prop('checked');
            var id=$(this).val()
            $.ajax({
                url:"{{route('company-towers.active')}}",
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    mode:mode,
                    id:id,
                },
                success:function(response){
                    if(response.status){
                        alert(response.msg);
                        // swal({
                        //     title: "Good job!",
                        //     text: response['msg'],
                        //     icon: "success",
                        //     button: "OK!",
                        // });
                    }
                    else{
                        alert('please try again');
                    }
                }
            })
        });
    </script>
@endpush


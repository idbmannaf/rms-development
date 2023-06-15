<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12">
            <!--<div class="card">-->
            <!--    <div class="card-body">-->
            <!--        <canvas id="myChart"></canvas>-->
            <!--    </div>-->
            <!--</div>-->


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ request()->report_type }} Report
                        @if(request()->start_date && request()->end_date)
                            <strong>DATE: {{request()->start_date}} To {{request()->end_date}}</strong>
                        @elseif(request()->start_date )
                            <strong>DATE: {{request()->start_date}}</strong>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url()->full() . '&export_type=dc_power_availibility' }}"
                           class="btn btn-outline-success">Export</a>
                        {{-- <button id="csvreport">csv</button> --}}
                    </div>

                </div>
                <div class="card-body">


                    <div class="row">
                        <div class="col-12 col-md-4 ">
                            <div class="percent">
                                <svg>
                                    <circle cx="100" cy="100" r="80"></circle>
                                    <circle cx="100" cy="100" r="80"
                                            style="--percent: {{$avg_dc_available}}"></circle>
                                </svg>
                                <div class="number">
                                    <h4 style="font-weight:700;">{{$avg_dc_available}}<span>%</span></h4>
                                </div>
                                <div class="d-flex justify-content-center align-items-center"
                                     style="padding: 34px 15px;">
                                    <div class="rise">
                                        <div class="rise_text">DC Availability</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="percent last">
                                <svg>
                                    <circle cx="100" cy="100" r="80"></circle>
                                    <circle cx="100" cy="100" r="80"
                                            style="--percent: {{$avg_dc_un_available}}"></circle>
                                </svg>
                                <div class="number">
                                    <h4 style="font-weight:700; color:red;">{{$avg_dc_un_available}}<span>%</span></h4>
                                </div>
                                <div class="d-flex justify-content-center align-items-center"
                                     style="padding: 34px 15px;">
                                    <div class="rise">
                                        <!--<div class="rise_text">DC Power Unvailability</div>-->
                                        <div class="rise_text">AC Power Unavailability</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="d-flex flex-column align-items-center mt-3">
                                <div class="time_mother">
                                    <div class="time_position">
                                        <h1>{{$avg_dc_un_available_sum}}</h1>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center"
                                     style="padding: 33px 15px;">
                                    <div class="rise">
                                        <!--<div class="rise_text">DC Power Unvailability</div>-->
                                        <div class="rise_text">DC Unavailable Time</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="showData">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <th>DateTime</th>
                                <th>Site Id</th>
                                <th>Towers/RMS</th>
                                <th>Thana</th>
                                <th>Zone</th>
                                <th>Cluster</th>
                                <th>DC Voltage</th>
                                {{--                                    <th>LLVD Fail Voltage Value</th>--}}
                                <th>DC Availability</th>
                                </thead>
                                <tbody>

                                @forelse ($datas as  $data)
                                    <tr>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->siteid }}</td>
                                        <td>{{ $data->tower_name}}</td>
                                        <td>{{ $data->thana}}</td>
                                        <td>{{ $data->tower_zone}}
                                        </td>
                                        <td>{{ $data->cluster}}
                                        </td>
                                        <td>{{ $data->dc_voltage }}</td>
                                        {{--                                                <td>{{ $data->llvd_fail_voltage_value }}</td>--}}
                                        <td>
                                            @if($data->llvd_fault )
                                                <span class="text-danger">Un Available</span>
                                            @else
                                                <span class="text-success">Available</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{$datas->appends(request()->all())->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

{{--<script>--}}
{{--    var ctx = document.getElementById('myChart').getContext('2d');--}}
{{--    const bg_color = [@foreach ($all_data as $datum) '{{ $datum->llvd_fault  ? 'red' : 'green' }}'@if($all_data->last()) , @endif @endforeach];--}}
{{--    var chart = new Chart(ctx, {--}}
{{--        type: 'bar',--}}
{{--        data: {--}}
{{--            labels: [@foreach ($all_data as $datum) '{{ $datum->created_at }}', @endforeach],--}}
{{--            datasets: [{--}}
{{--                label: 'DC Voltage',--}}
{{--                data: [@foreach ($all_data as $datum) {{ $datum->dc_voltage }}, @endforeach],--}}
{{--                backgroundColor: bg_color,--}}
{{--                borderColor: bg_color,--}}
{{--                borderWidth: 1--}}
{{--            }]--}}
{{--        },--}}
{{--        options: {--}}
{{--            scales: {--}}
{{--                yAxes: [{--}}
{{--                    ticks: {--}}
{{--                        beginAtZero: true--}}
{{--                    }--}}
{{--                }]--}}
{{--            }--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}

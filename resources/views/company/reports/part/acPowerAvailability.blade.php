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
                        <strong>DATE: {{request()->start_date}}  To {{request()->end_date}}</strong>
                        @elseif(request()->start_date )
                        <strong>DATE: {{request()->start_date}}</strong>
                        @endif

                    </h3>
                    <div class="card-tools">
                        <a href="{{url()->full()."&export_type=ac_power_availibility"}}" class="btn btn-outline-success">Export</a>
                        {{-- <button id="csvreport">csv</button> --}}
                    </div>
                </div>
                    <div class="card-body">


                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="percent">
                                    <svg>
                                        <circle cx="100" cy="100" r="80"></circle>
                                        <circle cx="100" cy="100" r="80" style="--percent: {{$available}}"></circle>
                                    </svg>
                                    <div class="number">
                                        <h4 style="font-weight:700;">{{$available}}<span>%</span></h4>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center" style="padding: 34px 15px;">
                                        <div class="rise">
                                            <div class="rise_text">AC Power Availability</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="percent last">
                                    <svg>
                                        <circle cx="100" cy="100" r="80"></circle>
                                        <circle cx="100" cy="100" r="80" style="--percent: {{$unavailable}}"></circle>
                                    </svg>
                                    <div class="number">
                                        <h4 style="font-weight:700; color:red;">{{$unavailable}}<span>%</span></h4>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center" style="padding: 34px 15px;">
                                        <div class="rise">
                                            <div class="rise_text">AC Power Unavailability</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                         <div class="showData">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <th>Towers/RMS</th>
                                        <th>Date</th>
                                        <th>Site Id</th>
                                        <th>Zone</th>
                                        <th>Cluster</th>
                                        <th>Voltage Grid Phase -A</th>
                                        <th>Voltage Grid Phase -B</th>
                                        <th>Voltage Grid Phase -C</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>

                                        @forelse ($datas as  $data)
                                        <tr>
                                            <td>{{$data->tower_name}} </td>
                                            <td>{{$data->created_at}}</td>
                                            <td>{{$data->siteid}}</td>
                                            <td>{{$data->tower &&  $data->tower->zone ? $data->tower->zone->title : ''}}</td>
                                            <td>{{$data->tower &&  $data->tower->cluster ? $data->tower->cluster->title : ''}}</td>
                                            <td>{{$data->voltage_phase_a}}</td>
                                            <td>{{$data->voltage_phase_b}}</td>
                                            <td>{{$data->voltage_phase_c}}</td>
                                            <td>
                                            @if($data->voltage_phase_a || $data->voltage_phase_b || $data->voltage_phase_c)
                                            <span class="text-success">AC Power Available</span>
                                            @else
                                            <span class="text-danger">AC Power Unvailable</span>
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
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>--}}

{{--<script>--}}
{{--var ctx = document.getElementById('myChart').getContext('2d');--}}
{{--var chart = new Chart(ctx, {--}}
{{--    type: 'bar',--}}
{{--    data: {--}}
{{--        labels: [@foreach ($all_data as $datum) '{{ $datum->created_at }}', @endforeach],--}}
{{--        datasets: [{--}}
{{--            label: 'Voltage Grid Phase -A',--}}
{{--            data: [@foreach ($all_data as $datum) {{ $datum->voltage_phase_a }}, @endforeach],--}}
{{--            backgroundColor: 'green',--}}
{{--            borderColor: 'green',--}}
{{--            borderWidth: 1--}}
{{--        },--}}
{{--        {--}}
{{--            label: 'Voltage Grid Phase -B',--}}
{{--            data: [@foreach ($all_data as $datum) {{ $datum->voltage_phase_b }}, @endforeach],--}}
{{--            backgroundColor: 'blue',--}}
{{--            borderColor: 'blue',--}}
{{--            borderWidth: 1--}}
{{--        },--}}
{{--        {--}}
{{--            label: 'Voltage Grid Phase -C',--}}
{{--            data: [@foreach ($all_data as $datum) {{ $datum->voltage_phase_c }}, @endforeach],--}}
{{--            backgroundColor: 'yellow',--}}
{{--            borderColor: 'yellow',--}}
{{--            borderWidth: 1--}}
{{--        },--}}

{{--        ]--}}
{{--    },--}}
{{--    options: {--}}
{{--        scales: {--}}
{{--            yAxes: [{--}}
{{--                ticks: {--}}
{{--                    beginAtZero: true--}}
{{--                }--}}
{{--            }]--}}
{{--        }--}}
{{--    }--}}
{{--});--}}
{{--</script>--}}




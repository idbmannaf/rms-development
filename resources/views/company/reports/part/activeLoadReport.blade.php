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
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title">
                            {{ request()->report_type }} Report
                            @if (request()->start_date && request()->end_date)
                                <strong>DATE: {{ request()->start_date }} To {{ request()->end_date }}</strong>
                            @elseif(request()->start_date)
                                <strong>DATE: {{ request()->start_date }}</strong>
                            @endif
                        </h3>
                        <div class="btn btn-warning"><strong>Average Active Load:</strong> {{ number_format($avarage_value,'4') }}
                        </div>
                        <div class="card-">
                            <a href="{{ url()->full() . '&export_type=active_load' }}"
                                class="btn btn-sarbs-one">Export</a>
                            {{-- <button id="csvreport">csv</button> --}}
                        </div>
                    </div>
                </div>
                {{-- =========== --}}
                <div class="card-body">
                    <div class="showData">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>DateTime</th>
                                    <th>Site Id</th>
                                    <th>Towers/RMS</th>
                                    <th>Thana</th>
                                    <th>Zone</th>
                                    <th>Cluster</th>
                                    <th>Active Load (Kw)</th>
                                </thead>
                                <tbody>
                                    @forelse ($datas as  $data)
                                        <tr>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->siteid }}</td>
                                            <td>{{ $data->tower_name }}</td>
                                            <td>{{ $data->thana }}
                                            <td>{{ $data->tower_zone }}
                                            </td>
                                            <td>{{ $data->cluster_name }}
                                            </td>
                                            <td>{{ $data->power_dc }}</td>

                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="float-right">
                            {{ $datas->appends(request()->all())->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>--}}

{{--<script>--}}
{{--    var ctx = document.getElementById('myChart').getContext('2d');--}}
{{--    var chart = new Chart(ctx, {--}}
{{--        type: 'bar',--}}
{{--        data: {--}}
{{--            labels: [--}}
{{--                @foreach ($all_data as $datum)--}}
{{--                    '{{ $datum->created_at }}',--}}
{{--                @endforeach--}}
{{--            ],--}}
{{--            datasets: [{--}}
{{--                label: 'Active Load (Kw)',--}}
{{--                data: [--}}
{{--                    @foreach ($all_data as $datum)--}}
{{--                        {{ $datum->power_dc }},--}}
{{--                    @endforeach--}}
{{--                ],--}}
{{--                backgroundColor: 'red',--}}
{{--                borderColor: 'red',--}}
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

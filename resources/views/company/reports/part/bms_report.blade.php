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
                        <!--<div class="card-">-->
                        <!--    <a href="{{ url()->full() . '&export_type=bms_data' }}"-->
                        <!--        class="btn btn-outline-success">Export</a>-->
                        <!--    {{-- <button id="csvreport">csv</button> --}}-->
                        <!--</div>-->
                    </div>


                </div>
                {{-- =========== --}}
                <div class="card-body">
                    <div class="showData">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Towers/RMS</th>
                                    <th>Date</th>
                                    <th>Site Id</th>
                                    <th>Zone</th>
                                    <th>Cluster</th>
                                    
                                            <th>current (A)</th>
                                        <th>Voltage of pack (V)</th>
                                        <th>SOC (%)</th>
                                        <th>SOH (%)</th>
                                        <th>Cell Voltage 01 (mv)</th>
                                        <th>Cell Voltage 02 (mv)</th>
                                        <th>Cell Voltage 03 (mv)</th>
                                        <th>Cell Voltage 04 (mv)</th>
                                        <th>Cell Voltage 05 (mv)</th>
                                        <th>Cell Voltage 06 (mv)</th>
                                        <th>Cell Voltage 07 (mv)</th>
                                        <th>Cell Voltage 08 (mv)</th>
                                        <th>Cell Voltage 09 (mv)</th>
                                        <th>Cell Voltage 10 (mv)</th>
                                        <th>Cell Voltage 11 (mv)</th>
                                        <th>Cell Voltage 12 (mv)</th>
                                        <th>Cell Voltage 13 (mv)</th>
                                        <th>Cell Voltage 14 (mv)</th>
                                        <th>Cell Voltage 15 (mv)</th>
                                        <th>Cell Temperature 01 (째C)</th>
                                        <th>Cell Temperature 03 (째C)</th>
                                        <th>Cell Temperature 04 (째C)</th>
                                </thead>
                                <tbody>
                                    @forelse ($datas as  $data)
                                        <tr>
                                            <td>{{ $data->tower_name }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->siteid }}</td>
                                            <td>{{ $data->tower_zone }}
                                            </td>
                                            <td>{{ $data->cluster_name }}
                                            </td>
                                            <td>{{ $data->current }}</td>
                                            <td>{{ $data->voltage_of_pack }}</td>
                                            <td>{{ $data->soc }}</td>
                                            <td>{{ $data->soh }}</td>
                                            <td>{{ $data->cell_voltage_1 }}</td>
                                            <td>{{ $data->cell_voltage_2 }}</td>
                                            <td>{{ $data->cell_voltage_3 }}</td>
                                            <td>{{ $data->cell_voltage_4 }}</td>
                                            <td>{{ $data->cell_voltage_5 }}</td>
                                            <td>{{ $data->cell_voltage_6 }}</td>
                                            <td>{{ $data->cell_voltage_7 }}</td>
                                            <td>{{ $data->cell_voltage_8 }}</td>
                                            <td>{{ $data->cell_voltage_9 }}</td>
                                            <td>{{ $data->cell_voltage_10 }}</td>
                                            <td>{{ $data->cell_voltage_11 }}</td>
                                            <td>{{ $data->cell_voltage_12 }}</td>
                                            <td>{{ $data->cell_voltage_13 }}</td>
                                            <td>{{ $data->cell_voltage_14 }}</td>
                                            <td>{{ $data->cell_voltage_15 }}</td>
                                            <td>{{ $data->cell_temperature_1 }}</td>
                                            <td>{{ $data->cell_temperature_3 }}</td>
                                            <td>{{ $data->cell_temperature_4 }}</td>

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
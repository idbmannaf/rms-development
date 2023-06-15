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
                                <h3 class="card-title">BMS Data for Tower/RMS: {{$tower->name}} ({{$tower->mno_site_id}})</h3>
                                <div class="dropdown">
                                  <button class="btn btn-sarbs-one dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',20])}}">20 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',50])}}">50 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',100])}}">100 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',200])}}">200 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',400])}}">400 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',800])}}">800 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',1200])}}">1200 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'bms',2000])}}">2000 Rows</a>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <div class="table-responsive">
                                <table class="table table-sm  table-bordered table-striped text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>Date Time</th>
                                        <th>chipid</th>
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
                                        <th>Cell Temperature 01 (°C)</th>
                                        <!--<th>Cell Temperature 02 (°C)</th>-->
                                        <th>Cell Temperature 03 (°C)</th>
                                        <th>Cell Temperature 04 (°C)</th>
                                        

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = (($data->currentPage() - 1) * $data->perPage() + 1); ?>
                                    @forelse($data as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->chipid }}</td>
                                            <td>{{ $item->current }}</td>
                                            <td>{{ $item->voltage_of_pack }}</td>
                                            <td>{{ $item->soc }}</td>
                                            <td>{{ $item->soh }}</td>
                                            <td>{{ $item->cell_voltage_1 }}</td>
                                            <td>{{ $item->cell_voltage_2 }}</td>
                                            <td>{{ $item->cell_voltage_3 }}</td>
                                            <td>{{ $item->cell_voltage_4 }}</td>
                                            <td>{{ $item->cell_voltage_5 }}</td>
                                            <td>{{ $item->cell_voltage_6 }}</td>
                                            <td>{{ $item->cell_voltage_7 }}</td>
                                            <td>{{ $item->cell_voltage_8 }}</td>
                                            <td>{{ $item->cell_voltage_9 }}</td>
                                            <td>{{ $item->cell_voltage_10 }}</td>
                                            <td>{{ $item->cell_voltage_11 }}</td>
                                            <td>{{ $item->cell_voltage_12 }}</td>
                                            <td>{{ $item->cell_voltage_13 }}</td>
                                            <td>{{ $item->cell_voltage_14 }}</td>
                                            <td>{{ $item->cell_voltage_15 }}</td>
                                            <td>{{ $item->cell_temperature_1 }}</td>
                                            <!--<td>{{ $item->cell_temperature_2 }}</td>-->
                                            <td>{{ $item->cell_temperature_3 }}</td>
                                            <td>{{ $item->cell_temperature_4 }}</td>
                                            

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-danger text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{$data->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')

@endpush


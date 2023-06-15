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
                                <h3 class="card-title">Data Of Tower/RMS: {{$tower->name}} ({{$tower->mno_site_id}})</h3>
                                <div class="dropdown">
                                  <button class="btn btn-sarbs-one dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Export
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',20])}}">20 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',50])}}">50 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',100])}}">100 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',200])}}">200 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',400])}}">400 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',800])}}">800 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',1200])}}">1200 Rows</a>
                                    <a class="dropdown-item" href="{{route('company.rmsDataExport',[$company,$tower->id,'rms',2000])}}">2000 Rows</a>
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
                                        <th>Site Id</th>
                                        <th>Thana</th>
                                        <th>Voltage Phase -A (V)</th>
                                        <th>Voltage Phase -B (V)</th>
                                        <th>Voltage Phase -C (V)</th>
                                        <th>Current Phase -A (A)</th>
                                        <th>Current Phase -B (A)</th>
                                        <th>Current Phase -C (A)</th>
                                        <th>Frequency (Hz)</th>
                                        <th>Power Factor</th>
                                        <th>Cumilative Energy (kWh)</th>
                                        <th>Power (kW)</th>
                                        <th>DC Voltage (V)</th>
                                        <th>Tenent Load (A)</th>
                                        <th>Cumilative DC Energy (kWh)</th>
                                        <th>Power DC (kW)</th>
                                        <th>Tenant Name</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = (($datas->currentPage() - 1) * $datas->perPage() + 1); ?>
                                    @forelse($datas as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->siteid }}</td>
                                            <td>{{ $item->upazila }}</td>
                                            <td>{{ $item->voltage_phase_a }}</td>
                                            <td>{{ $item->voltage_phase_b }}</td>
                                            <td>{{ $item->voltage_phase_c }}</td>
                                            <td>{{ $item->current_phase_a }}</td>
                                            <td>{{ $item->current_phase_b }}</td>
                                            <td>{{ $item->current_phase_c }}</td>
                                            <td>{{ $item->frequency }}</td>
                                            <td>{{ $item->power_factor }}</td>
                                            <td>{{ $item->cumilative_energy }}</td>
                                            <td>{{ $item->power }}</td>
                                            <td>{{ $item->dc_voltage }}</td>
                                            <td>{{ $item->tanent_load }}</td>
                                            <td>{{ $item->cumilative_dc_energy }}</td>
                                            <td>{{ $item->power_dc }}</td>
                                            <td>{{ $item->tenant_name }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-danger text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{$datas->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')

@endpush


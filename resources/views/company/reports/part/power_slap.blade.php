<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12">
            

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
                        <a href="{{ url()->full() . '&export_type=power_slap' }}"
                            class="btn btn-outline-success">Export</a>
                        {{-- <button id="csvreport">csv</button> --}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="showData">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <th>Towers/RMS</th>
                                    <th>Date</th>
                                    <th>Site Id</th>
                                    <th>Zone</th>
                                    <th>Cluster</th>
                                    <th>Total Active Power</th>
                                </thead>
                                <tbody>

                                    @forelse ($datas as  $data)
                                  
                                        <tr>
                                            <td>{{ $data->tower ? $data->tower->name : '' }} {{ $data->id }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->tower ? $data->tower->mno_site_id : '' }}</td>
                                            <td>{{ $data->tower && $data->tower->zone ? $data->tower->zone->title : '' }}
                                            </td>
                                            <td>{{ $data->tower && $data->tower->cluster ? $data->tower->cluster->title : '' }}
                                            </td>
                                            <td>{{ $data->total_active_power }} (Kw)</td>


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



<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title">
                        {{ request()->report_type }} Report
                        @if(request()->start_date && request()->end_date)
                        <strong>DATE: {{request()->start_date}}  To {{request()->end_date}}</strong>
                        @elseif(request()->start_date )
                        <strong>DATE: {{request()->start_date}}</strong>
                        @endif
                    </h3>
                    <a href="{{ url()->full() . '&export_type=power_consumption' }}"
                        class="btn btn-outline-success">Export</a>
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
                                    <th>Tenant Name</th>
                                    <th>Power Dc {Kw}</th>
                                </thead>
                                <tbody>


                                    @forelse ($datas as  $data)

                                        <tr>
                                            <td>{{ $data->tower_name }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->siteid}}</td>
                                            <td>{{ $data->tower && $data->tower->zone ? $data->tower->zone->title : '' }}
                                            </td>
                                            <td>{{ $data->tower && $data->tower->cluster ? $data->tower->cluster->title : '' }}
                                            </td>
                                            <td>{{$data->tenant_name}}</td>
                                            <td>{{$data->power_dc}}</td>


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



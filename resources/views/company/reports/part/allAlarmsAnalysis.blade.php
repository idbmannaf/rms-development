<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ request()->report_type }} Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url()->full() . '&export_type=alarm_history' }}"
                           class="btn btn-outline-success">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th>Towers/RMS</th>
                            <th>Site Id</th>
                            <th>ChipId</th>
                            <th>Zone</th>
                            <th>Cluster</th>
                            <th>Alarm Name</th>
                            <th>Alarm Started</th>
                            <th>Alarm Ended</th>
                            <th>Alarm Duration</th>
                            <th>Alarm Source</th>
                            </thead>
                            <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td>{{ $data->tower ? $data->tower->name : '' }}
                                </td>
                                <td>{{ $data->tower ? $data->tower->mno_site_id : '' }} </td>
                                <td>{{ $data->tower ? $data->tower->chipid : '' }} </td>
                                <td>{{ $data->tower && $data->tower->zone ? $data->tower->zone->title : '' }} </td>
                                <td>{{ $data->tower && $data->tower->cluster ? $data->tower->cluster->title : '' }} </td>
                                <td>{{ $data->alarm_title }} </td>
                                <td>{{ $data->alarm_started_at }} </td>
                                <td>{{ $data->alarm_ended_at }} </td>
                                <td>{{ $data->alarm_ended_at }} </td>
                                <td>{{ $data->alarmSource() }} </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

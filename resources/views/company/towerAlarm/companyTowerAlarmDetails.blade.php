@extends('company.layout.master')
@push('title')
   Tower Alarm Details
@endpush
@push('css')
    <style>
        .blink_me {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
@endpush

@section('body')
<section class="content">

    <div class="row">

        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                      <div class="card-body p-2 shadow-lg">


                       <!--<i class="fas fa-broadcast-tower"></i> RMS: {{ $alarm->tower->name }} ({{ $alarm->tower->mno_site_id }}) | Alarm Duration: {{ $alarm->alarm_started_at }} - {{ $alarm->alarm_ended_at }} | Category:{{ $alarm->alarm_category }} | Source: {{ $alarm->alarmSource() }}-->
                       <i class="fas fa-broadcast-tower"></i> RMS: {{ $alarm->tower->name }} ({{ $alarm->tower->mno_site_id }}) |  Category:{{ $alarm->alarm_category }} | Source: {{ $alarm->alarmSource() }}

                      </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            This RMS Alarms:  <a class="btn btn-danger btn-xs" href="">{{ $alarm->alarm_title }} Details</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

        <div class="col-sm-12">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> <i class="fa fa-university px-2"></i>
                       {{$alarm->alarmSource()}} Alarms of  {{ $alarm->tower ?$alarm->tower->mno_site_id : '' }}
                    </h3>
                    <!--<div class="card-tools">-->
                    <!--     <button class="btn btn-xs bg-sarbs-one float-right mx-1" onclick="exportTableToCSV('Alarm Details of {{ $alarm->tower->name }}')">Export To CSV</button>-->
                    <!--</div>-->

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table class="table table-bordered table-sm table-striped text-nowrap w3-white text-nowrap">
                        <thead>
                            <tr class="text-success-">
                                <th>SL</th>
                                <th>RMS</th>
                                 <th>Status</th>
                                <th>Alarm Started</th>
                                <th>Alarm Ended</th>
                                <th>Duration</th>
                                <th>Category</th>
                                <th>Alarm Name</th>
                                <th>Alarm Source</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $i = (($towerAlarmDatas->currentPage() - 1) * $towerAlarmDatas->perPage() + 1); ?>

                            @foreach($towerAlarmDatas as $item)
                            @if($item->live && $item->alarm_number == 1)
                            @else
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    {{ $item->tower ? $item->tower->name . ' ( '. $item->tower->mno_site_id .' )' : '' }}
                                </td>
                                <td>
                                    @if($item->live)
                                        <i class="fas fa-circle blink_me text-success"></i>
                                    @endif

                                    {{ $item->live ? 'Live' : 'History' }}
                                </td>
                                <td>
                                    {{ $item->alarm_started_at }}
                                </td>

                                <td>

                                    {{ $item->live ? 'Running' : $item->alarm_ended_at }}
                                </td>
                                <td> {{ diffTime($item->alarm_started_at, ($item->live ? \Carbon\Carbon::now() : $item->alarm_ended_at) )}}</td>
                                <td>
                                    {{ $item->alarm_category }}
                                </td>

                                <td>
                                    {{ $item->alarm_title }}
                                </td>
                                <td>
                                    {{ $item->alarmSource() }}
                                </td>

                            </tr>
                            @endif
                            @endforeach
                                    </tbody>

                                </table>
                    </div>

                            {{ $towerAlarmDatas->links() }}

                  </div>
                    </div>
                </div>
            </div>



        </div>
    </div>



        </section>
        @endsection


        @push('js')

        <script type="text/javascript">

                function exportTableToCSV(filename) {
                var csv = [];
                var rows = document.querySelectorAll("table tr");

                for (var i = 0; i < rows.length; i++) {
                    var row = [], cols = rows[i].querySelectorAll("td, th");

                    for (var j = 0; j < cols.length; j++)
                    row.push("\""+cols[j].innerText+"\"");

                    csv.push(row.join(","));
                }

                // Download CSV file
                downloadCSV(csv.join("\n"), filename);
            };


            function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}


        </script>
        @endpush

@extends('company.layout.master')
@push('title')
    Tower Alarm
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

                        <div class="card w3-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class='fas fa-bell w3-text-red'></i>
                                        {{ $company->title ?? '' }} | All Alarms
                                        @if(request()->status)
                                            ({{  ucfirst(request()->status)  }})
                                        @endif
                                        &nbsp; &nbsp;
                                    </h5>
                                    <div>
                                        <a class="btn btn-xs btn-success"
                                           href="{{ route('company.companyTowerAlarms', ['company'=>$company, 'status'=> 'live']) }}">

                                            Live Alarms</a>

                                        <a class="btn btn-xs btn-warning"
                                           href="{{ route('company.companyTowerAlarms', ['company'=>$company, 'status'=> 'history']) }}">History</a>
                                        <a class="btn btn-xs btn-info"
                                           href="javascript:void(0)" onclick="exportTableToCSV('{{ ucfirst(request()->status ?: 'All') }} Alarms')">Export To CSV</a>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body p-1 w3-light-gray">
                                <div class="table-responsive table-responsive-sm">
                                    <table
                                        class="table table-bordered table-sm table-striped text-nowrap w3-white text-nowrap">
                                        <thead>
                                        <tr class="text-success-">
                                            <th>SL</th>

                                             <th width="80">Action</th>
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
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                              <td>
                                          <div class="btn-group no-print">
                                              <a class="btn btn-outline-danger btn-xs"
                                                 href="{{ route('company.companyTowerAlarmDetails',[$company,$item]) }}">Details</a>
                                          </div>
                                              </td>
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


@push('script')

    <script type="text/javascript">

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push("\"" + cols[j].innerText + "\"");

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

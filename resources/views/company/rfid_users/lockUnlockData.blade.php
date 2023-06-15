@extends('company.layout.master')
@section('title', 'SMU Lock Unlock Data')

@push('css')
@endpush

@section('body')
    <section class="content">
        <div class="card">
            <div class="card-header bg-card-header">{{ $type == 'total'? 'All Lock Unlock' :ucfirst($type) }} Data</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderd table-sm">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Action</th>
                            <th>Tower Name</th>
                            <th>Chipid</th>
                            <th>Employee Name</th>
                            <th>Rfid</th>
                            <th>Door Opened At</th>
                            <th>Door Closed At</th>
                            <th>Duration</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1 ?>
                        @foreach($lockUnlockTowers as $tower)
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                <a title="View All {{$type}} Door Data" data-toggle="tooltip" target="_blank" class=" btn w3-deep-orange btn-xs no-print ml-1" href="{{route('company.rfid.towerWiseLockUnlockData',['type'=>$type,'company'=>$company,'chipid'=>$tower->chipid])}}"><i class="fa fa-th"></i>
                                </a>
                            </td>
                            <td>{{$tower->name}}</td>
                            <td>{{$tower->chipid}}</td>
                            <?php
                            if($type =='total'){
                                $data = $tower->lockUnlockData()->latest()->first();
                            }

                            elseif($type =='open'){
                                $data = $tower->doorOpen();
                            }

                            elseif($type=='close'){
                                $data = $tower->doorClose();
                            }

                            ?>

                            <td>{{$data && $data->employee ? $data->employee->name : ''}}</td>
                            <td>{{$data ? $data->rfid_employee_id : ''}}</td>
                            <td>{{$data ? $data->door_open_at : ''}}</td>
                            <td>{{$data ? $data->door_closed_at : ''}}</td>
                            <td>{{$data ? $data->dore_open_duration : ''}}</td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{$lockUnlockTowers->appends(request()->all())->render()}}
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

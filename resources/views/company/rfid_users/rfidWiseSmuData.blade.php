@extends('company.layout.master')
@section('title', 'Rfid Users Data')

@push('css')
@endpush

@section('body')
    <section class="content">
        <div class="card ">
            <div class="card-header bg-card-header">Smu Data of Rfid: {{$rfid_user->rfid}}

                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-warning btn-sm ">Back</a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderd table-sm">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Tower Name</th>
                            <th>Site Code</th>
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
                        @foreach($items as $item)
                            <tr>
                                <td>{{$i}}</td>

                                <td>{{$item->tower ? $item->tower->name : ''}}</td>
                                <td>{{$item->tower ? $item->tower->mno_site_id : ''}}</td>
                                <td>{{$item->chipid}}</td>
                                <td>{{$item->employee ? $item->employee->name : ''}}</td>
                                <td>{{$item->rfid_employee_id}}</td>
                                <td>{{$item->door_open_at}}</td>
                                <td>{{$item->door_closed_at}}</td>
                                <td>{{$item->dore_open_duration}}</td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$items->appends(request()->all())->render()}}
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

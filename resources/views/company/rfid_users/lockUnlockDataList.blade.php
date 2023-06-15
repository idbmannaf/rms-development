@extends('company.layout.master')
@section('title', 'SMU Lock Unlock Data')

@push('css')
@endpush

@section('body')
    <section class="content">
        <br>
        <div class="card">
            <div class="card-header bg-card-header">
                <div class="d-flex justify-content-between align-items-center">
                <h4>Door Open/Close Data for Tower: {{$tower->name}} Chipid: {{$tower->chipid}} </h4>
                    <div class="">
                        <a href="" class="btn  btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"
                           data-whatever="@fat">Add Remote Access</a>
                        <a href="{{ url()->previous() }}" class="btn btn-warning btn-sm"><i
                                class="fa fa-undo px-2"></i>Back</a>
                    </div>

                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderd table-sm">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Tower Name</th>
                            <th>Chipid</th>
                            <th>Emplyee Name</th>
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

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Give Door Open Access</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        action="{{ route('company.tower.towerDetailsEntryExitHistoryLogCreateByChipIdPost', [$company,$tower->chipid]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="select_employee">Employee</label>
                                            <select name="select_employee" id="select_employee" class="form-control">
                                                <option value="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->rfid }}">
                                                        {{ $employee->name ?? 'N/A' }}-{{ $employee->rfid }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success">
                                        </div>
                                    </form>
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

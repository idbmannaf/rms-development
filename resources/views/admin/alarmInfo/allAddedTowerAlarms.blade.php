@extends('admin.layout.master')
@push('title')
    Admin | Alarm Info
@endpush
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cp/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endpush

@section('body')
    <section class="content">
        <div class="row">

            <div class="col-sm-12">

                <div class="card card-widget ">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="fa fa-plus-square text-blue"></i> Add New Alarm Info
                        </h4>
                    </div>
                    <div class="card-body w3-light-gray p-2 ">

                        <form class="form-submit-post" method="post" action="{{ route('alarms.store') }}">

                            @csrf


                            <div class="card-deck">
                                <div class="card">

                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-12 col-md-11">
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="category">Alarm Category</label>
                                                            <select class="form-control  form-control-sm" name="category" id="category">
                                                                @if(old('category'))
                                                                    <option value="{{ old('category') }}">{{ old('category') }}</option>
                                                                @else
                                                                    <option value="">Select Alarm Category</option>
                                                                @endif

                                                                @foreach(config('parameter.alarm_cats') as $cat)
                                                                    <option>{{ $cat }}</option>

                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" value="{{ old('title') }}" name="title" id="title"
                                                                   class="form-control form-control-sm" placeholder="Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="alarm_numbers">Alarm Numbers</label>
                                                            <input type="number" name="alarm_numbers" id="alarm_numbers" value="{{old('alarm_numbers')}}" class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="alarm_type">Alarm Type</label>
                                                            <select name="alarm_type" id="alarm_type" required class="form-control form-control-sm">
                                                                <option value="">Select Alarm Type</option>
                                                                <option value="critical">Critical</option>
                                                                <option value="non-critical">Non-Critical</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1">
                                                <div class="form-group form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" name="active" checked>
                                                        Active
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-primary next-btn-with-loading">Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </form>


                    </div>
                </div>


                <div class="card card-primary mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-list"></i> All Alarm Infos
                        </h3>
                        <div class="card-tools d-none">
                            <button class="btn btn-sm btn-light" onclick="exportTableToCSV('allAddedAlarms.csv')">Export
                                To
                                CSV
                            </button>

                        </div>
                    </div>
                    <div class="card-body p-1">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th colspan="" rowspan="" headers="" scope="">SL</th>
                                    <th colspan="" rowspan="" headers="" scope="">Category</th>

                                    <th colspan="" rowspan="" headers="" scope="">Title</th>
                                    <th colspan="" rowspan="" headers="" scope="">Numbers</th>
                                    {{-- <th colspan="" rowspan="" headers="" scope="">Device Type</th> --}}
                                     <th colspan="" rowspan="" headers="" scope="">Alarm Type</th>
                                    <th colspan="" rowspan="" headers="" scope="">Status</th>
                                    <th colspan="" rowspan="" headers="" scope="">Action</th>
                                </tr>
                                </thead>
                                <tbody class="w3-small">
                                <?php $i = ($datas->currentPage() - 1) * $datas->perPage() + 1; ?>
                                @foreach ($datas as $data)
                                    <tr class="nowrap">
                                        <td>{{ $i }}</td>

                                        <td>{{ $data->category }}</td>

                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->alarm_numbers }}</td>
                                        {{-- <td>{{ $data->device_type }}</td> --}}
                                         <td>{{ $data->alarm_type }}</td>
                                        <td>
                                            @if ($data->active)
                                                Active
                                            @else
                                                Inactive

                                            @endif
                                        </td>

                                        <td>

                                            <div class="btn-group btn-group-sm m-0 p-0">
                                                <a title="Edit Alarm Info" class="btn btn-primary mr-1"
                                                   data-toggle="tooltip-" href="{{ route('alarms.edit', $data) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a title="Delete Alarm Info"
                                                   onclick="event.preventDefault(); document.getElementById('logoutForm{{$data->id}}').submit();"
                                                   data-toggle="tooltip-" class="btn btn-danger "
                                                   href="{{ route('alarms.destroy', $data) }}"><i
                                                        class="fa fa-times"></i></a>

                                                <form action="{{route('alarms.destroy', $data)}}" method="POST" id="logoutForm{{$data->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                            </div>

                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        {{ $datas->render() }}
                    </div>
                </div>


            </div>
        </div>

    </section>
@endsection

@push('script')


    <!-- Select2 -->
    <script src="{{ asset('cp/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                minimumInputLength: 1,
                tags: true,
                tokenSeparators: [',']
            });
        });


        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

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

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                    cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
    </script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

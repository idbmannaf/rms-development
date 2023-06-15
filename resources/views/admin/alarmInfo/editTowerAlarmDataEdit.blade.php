@extends('admin.layout.master')
@push('title')
    Admin | Alarm Info Edit
@endpush
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cp/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cp/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #6610f2;
        }
    </style>
@endpush

@section('body')
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary mb-1">
                    <div class="card-header">
                        <h3 class="card-title">
                            Alarm Data: <span
                                class="badge badge-default w3-deep-orange">{{ $data->category }} > {{ $data->title }}</span>
                        </h3>
                    </div>

                    <div class="card-body w3-light-gray p-2 ">

                        <form class="form-submit-post" method="post"
                              action="{{ route('alarms.update', $data) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-deck">
                                <div class="card">
                                    <div class="card-body p-2">

                                        <div class="row">
                                            <div class="col-12 col-md-11">
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="category">Alarm Category</label>
                                                            <select class="form-control  form-control-sm"
                                                                    name="category" id="category">
                                                                    <option value="">Select Alarm Category</option>

                                                                @foreach(config('parameter.alarm_cats') as $cat)
                                                                    <option {{$data->category==$cat ? 'selected' : ''}}>{{ $cat }}</option>

                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="title">Title</label>
                                                            <input type="text" value="{{ $data->title ?: old('title') }}" name="title"
                                                                   id="title"
                                                                   class="form-control form-control-sm"
                                                                   placeholder="Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="alarm_numbers">Alarm Numbers</label>
                                                            <input type="number" name="alarm_numbers" id="alarm_numbers"
                                                                   value="{{$data->alarm_numbers?:old('alarm_numbers')}}"
                                                                   class="form-control form-control-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="alarm_type">Alarm Type</label>
                                                            <select name="alarm_type" id="alarm_type" required
                                                                    class="form-control form-control-sm">
                                                                <option value="">Select Alarm Type</option>
                                                                <option {{$data->alarm_type == 'critical' ? 'selected' : ''}} value="critical">Critical</option>
                                                                <option {{$data->alarm_type == 'non-critical' ? 'selected' : ''}} value="non-critical">Non-Critical</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1">
                                                <div class="form-group form-check">
                                                    <label class="form-check-label">
                                                        <input {{$data->alarm_type ? 'checked' : ''}} class="form-check-input" type="checkbox" name="active"
                                                               checked>
                                                        Active
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-primary next-btn-with-loading">
                                                    Update
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')


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
    </script>
    <script>
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

        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }
    </script>
@endpush

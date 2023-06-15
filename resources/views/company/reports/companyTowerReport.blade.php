@extends('company.layout.master')
@push('title')
    Company | Tower Report
@endpush
@push('css')

    <style>
        .showData {
            width: 100%;
            /* height: 80vh;

            overflow: scroll; */
        }
    </style>
    <style>
        .card .percent {
            position: relative;
            text-align: center;
        }

        .card svg {
            position: relative;
            width: 210px;
            height: 210px;
            transform: rotate(-90deg);
        }

        .card svg circle {
            width: 100%;
            height: 100%;
            fill: none;
            stroke: #f0f0f0;
            stroke-width: 35;
            stroke-linecap: round;
        }

        .card svg circle:last-of-type {
            stroke-dasharray: 500px;
            stroke-dashoffset: calc(500px - (500px * var(--percent)) / 100);
            stroke: #3498db;
        }

        .timezone svg circle:first-child {
            stroke-dasharray: 500px;
            stroke-dashoffset: calc(500px - (500px * var(--percent)) / 100);
            stroke: #3498db !important;
        }

        .card .number {
            position: absolute;
            top: 37%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .card .number h3 {
            font-weight: 700;
            font-size: 31px;
        }

        .card .number h3 span {
            font-size: 2rem;
        }

        .card .title h2 {
            margin: 25px 0 0;
        }

        .card .title h2 {
            margin: 25px 0 0;
        }

        .card:nth-child(1) svg circle:last-of-type {
            stroke: #06BCC1;
        }

        .rise_dollar {
            font-style: normal;
            font-weight: 600;
            font-size: 40px;
            line-height: 40px;
            padding: 15px 0px;
            padding-top: 15px;
        }

        .rise_text {
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 16px;
        }

        .space_in {
            padding-top: 16px;
        }

        .card .percent.last svg circle:last-of-type {
            stroke: red;
        }

        @media only screen and (max-width: 600px) {
            .space_in {
                padding-top: 5px !important;
            }
        }

        .time_mother {
            width: 200px;
            height: 200px;
            border: 2px solid;
            border-width: 25px;
            border-color: #096ba6;
            border-radius: 50%;
            position: relative;
            text-align: center;
            margin: 0 auto;
        }

        .time_position {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
          href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('body')
    <section class="content">


        <div class="row">
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-header bg-card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5> Reports </h5>
                            <div class="card-tools">
                                <a href="{{ url()->previous() }}" class="btn btn-sarbs-one btn-sm ">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body w3-light-gray pb-0">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="card card-widget">
                                    <div class="card-body">
                                        <form method="get"
                                              action="{{ route('company.reports', $company) }}">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 reportT">
                                                    <div class="form-group">
                                                        <label for="">Report Type<span class="text-danger">*</span>
                                                        </label>
                                                        <br>
                                                        <select name="report_type" id="selection" required
                                                                class="form-control report_type">
                                                            <option value="">Select Type</option>
                                                            @foreach (config('parameter.tower_report_type') as $type)
                                                                <option
                                                                    {{ request()->report_type == $type ? 'selected' : '' }}
                                                                    value="{{ $type }}">{{ $type }}</option>
                                                            @endforeach
                                                            @if($has_bms)
                                                                <option
                                                                    {{ request()->report_type == 'BMS History' ? 'selected' : '' }}
                                                                    value="BMS History">BMS History
                                                                </option>
                                                            @endif


                                                        </select>
                                                    </div>
                                                    @error('reporttype')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                @if(request()->report_type =='Alarms History')
                                                    <div class="col-12 col-md-3 alarm_name">
                                                        <label for="">Alarm
                                                            Name</label>
                                                        <select name="alarm_name" id="" class="form-control">
                                                            <option value="">Select Alarm Name
                                                            </option> @foreach ($alarmInfoCats as $cat) @foreach ($cat->catChildren() as $child)
                                                                <option
                                                                    {{$child->title ==request()->alarm_name ? 'selected' : '' }} value="{{$child->title}}">{{$child->title}}</option> @endforeach @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Zone </label>
                                                        <select name="zone" id="zone"
                                                                class="form-control ">
                                                            <option value="" selected>Zone ID</option>
                                                            @if (!empty($zones))
                                                                @foreach ($zones as $id => $title)
                                                                    <option
                                                                        {{ request()->zone == $id ? 'selected' : '' }}
                                                                        value="{{ $id}}" class="">
                                                                        {{ $title }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('name')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Site ID </label>
                                                        <div class="select2-purple">
                                                            <select data-dropdown-css-class="select2-purple"
                                                                    name="site_id[]" style="width: 100%" id="siteid"
                                                                    class="select2" multiple>

                                                                @if(request()->report_type == 'BMS History')

                                                                    @if (!empty($towers_with_bms))
                                                                        @foreach ($towers_with_bms as $site_id)
                                                                            <option
                                                                                {{ is_array(request()->site_id) && in_array($site_id->mno_site_id,request()->site_id) ? 'selected' : '' }}
                                                                                value="{{ $site_id->mno_site_id  }}"
                                                                                class="">
                                                                                {{ $site_id->mno_site_id  }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                @else
                                                                    @if (!empty($site_ids))
                                                                        @foreach ($site_ids as $site_id)
                                                                            <option
                                                                                {{ is_array(request()->site_id) && in_array($site_id->mno_site_id,request()->site_id) ? 'selected' : '' }}
                                                                                value="{{ $site_id->mno_site_id  }}"
                                                                                class="">
                                                                                {{ $site_id->mno_site_id  }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @error('site_id')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-3 col-md-36">
                                                    <div class="form-group">
                                                        <label for="">Site Name </label>
                                                        <select name="site_name" id="site_name"
                                                                class="form-control sitename">
                                                            <option value="" selected>Site Name</option>
                                                            @if(request()->report_type == 'BMS History')
                                                                @if (!empty($towers_with_bms))
                                                                    @foreach ($towers_with_bms as $site_name)
                                                                        <option
                                                                            {{ request()->site_name == $site_name->name ? 'selected' : '' }}
                                                                            value="{{ $site_name->name  }}"
                                                                            class="">
                                                                            {{ $site_name->name  }}</option>
                                                                    @endforeach
                                                                @endif

                                                            @else
                                                                @if (!empty($site_names))
                                                                    @foreach ($site_names as $site_name)
                                                                        <option
                                                                            {{ request()->site_name == $site_name->name ? 'selected' : '' }}
                                                                            value="{{ $site_name->name  }}"
                                                                            class="">
                                                                            {{ $site_name->name  }}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('site_name')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Cluster </label>
                                                        <select name="cluster" id="Cluster"
                                                                class="form-control">
                                                            <option value="" selected>Cluster ID</option>
                                                            @if (!empty($clusters))
                                                                @foreach ($clusters as $cluster)
                                                                    <option
                                                                        {{ request()->cluster == $cluster ? 'selected' : '' }}
                                                                        value="{{ $company->id }}" class="">
                                                                        {{ $cluster->title  }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @error('cluster')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                                <div class="col-lg-3 col-md-3">
                                                    <div class="form-group">
                                                        <label for="start_date">Start Date <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" required name="start_date"
                                                               class="form-control"
                                                               placeholder="Enter Chip ID"
                                                               value="{{ old('start_date') ? old('start_date') :( request()->start_date ?  request()->start_date : \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                                               id="start_date">
                                                    </div>
                                                    @error('start_date')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3 col-md-3">
                                                    <div class="form-group">
                                                        <label for="end_date">End Date <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" required name="end_date"
                                                               class="form-control"
                                                               placeholder="Enter tower Name"
                                                               value="{{ old('end_date') ? old('end_date') :( request()->end_date ?  request()->end_date : \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                                               id="end_date">
                                                    </div>
                                                    @error('end_date')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-3 col-md-3 submit"
                                                     style="display: flex;justify-content: flex-start;flex-direction: column;align-items: center;">
                                                    <label for="start_date">&nbsp;</label>
                                                    <button class="btn btn-sarbs-one form-control">Show</button>
                                                </div>
                                            </div>


                                        </form>


                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="width:100%">
            @if ($a = request()->report_type)
                @if($a == 'Active Load')
                    @include('company.reports.part.activeLoadReport')
                @elseif($a == 'AC Power Availability')
                    @include('company.reports.part.acPowerAvailability')
                @elseif($a == 'DC Power Availability')
                    @include('company.reports.part.dcPowerAvailability')
                @elseif ($a == 'Mains Fail')
                    @include('company.reports.part.mainsFailReport')
                @elseif($a == 'Power Consumption')
                    @include('company.reports.part.companyPowerConsumptionReport')
                @elseif($a == 'BMS History')
                    @include('company.reports.part.bms_report')
                @elseif($a == 'Power Slab')
                    @include('company.reports.company.reports.part.power_slap')
                @elseif($a == 'Alarms History')
                    @include('company.reports.part.allAlarmsAnalysis')
                @elseif($a == 'SMU Lock History')
                    @include('company.reports.part.smartLockAccess')
                @endif

            @endif
        </div>
        </div>

    </section>
@endsection


@push('script')


    <!-- Select2 -->
    <script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2({
                placeholder: 'Select Site'
            })

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })


        // DropzoneJS Demo Code End
    </script>
    <script>
        $('.company_id').select2()
    </script>
    {{-- <script>
        let url = "https://example.com/site/";

document.getElementById('form').addEventListener('submit', (e) => {
    e.preventDefault();
  let selection = document.getElementById('selection').value;
  console.log(url + selection);
  window.location.href = url + selection;
});
    </script> --}}


    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <script>
        var html = '<div class="col-12 col-md-3 alarm_name"> <label for="">Alarm Name</label> <select name="alarm_name" id="" class="form-control"><option value="">Select Alarm Name</option> @foreach ($alarmInfoCats as $cat) @foreach ($cat->catChildren() as $child) <option value="{{$child->title}}">{{$child->title}}</option> @endforeach @endforeach </select></div>';
        var bms_html = '<select data-dropdown-css-class="select2-purple" name="site_id[]" style="width: 100%" id="siteid" class="select2" multiple> @if (!empty($towers_with_bms)) @foreach ($towers_with_bms as $site_id) <option  value="{{ $site_id->mno_site_id  }}" class=""> {{ $site_id->mno_site_id  }}</option> @endforeach @endif </select>'
        var bms_sitenames = '<option value="" selected>Site Name</option>@if (!empty($towers_with_bms)) @foreach ($towers_with_bms as $site_id) <option  value="{{ $site_id->name  }}" class=""> {{ $site_id->name  }}</option> @endforeach @endif';
        var site_ids = '<select data-dropdown-css-class="select2-purple" name="site_id[]" style="width: 100%" id="siteid" class="select2" multiple> @if (!empty($site_ids)) @foreach ($site_ids as $site_id) <option ] value="{{ $site_id->mno_site_id  }}" class=""> {{ $site_id->mno_site_id  }}</option> @endforeach @endif </select>'
        var site_names = '<option value="" selected>Site Name</option>@if (!empty($site_names)) @foreach ($site_names as $site_id) <option value="{{ $site_id->name  }}" class=""> {{ $site_id->name  }}</option> @endforeach @endif';
        $(document).on('change', '.report_type', function () {
            let that = $(this);
            if (that.val() === 'Alarms History') {

                $('.reportT').after(html)
            } else {
                $('.alarm_name').remove()

            }

            if (that.val() === 'BMS History') {
                $('.select2-purple').html(bms_html)

                $('#site_name').html(bms_sitenames)


            } else {
                $('.select2-purple').html(site_ids)
                $('#site_name').html(site_names)
            }

            $('.select2').select2({
                placeholder: 'Select Site'
            })
        })
    </script>
    <script>

        $(function () {
            $("#csvreport").on('click', function () {
                var data = "";
                var tableData = [];
                var rows = $("table tr");
                rows.each(function (index, row) {
                    var rowData = [];
                    $(row).find("th, td").each(function (index, column) {
                        rowData.push(column.innerText);
                    });
                    tableData.push(rowData.join(","));
                });
                data += tableData.join("\n");
                $(document.body).append('<a id="download-link" download="data.csv" href=' + URL
                    .createObjectURL(new Blob([data], {
                        type: "text/csv"
                    })) + '/>');
                $('#download-link')[0].click();
                $('#download-link').remove();
            });
        });
    </script>
@endpush

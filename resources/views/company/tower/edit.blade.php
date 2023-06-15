@extends('company.layout.master')
@push('title')
    Company | Tower Edit
@endpush
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
    </style>
@endpush
@section('body')
    <section class="pt-3">
        <div class="row">
            <div class="col-12 col-md-10 m-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create Tower</h3>
                            <a href="{{route('tower.lists',$company)}}" class="btn btn-sm btn-warning"><i
                                    class="fas fa-eye"></i></a>
                        </div>
                    </div>
                    <form action="{{route('company.tower.update',[$company,$tower])}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="">Tower Name</label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{$tower->name??old('name')}}" placeholder="Enter Tower Name...">
                                    @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="">Chipid</label>
                                    <input type="text" name="chipid" class="form-control" readonly
                                           value="{{$tower->chipid ?:old('chipid')}}" placeholder="Enter Chipid...">
                                    @error('chipid')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--                                <div class="col-12 col-md-6">--}}
                                {{--                                    <label for="">Sim Number</label>--}}
                                {{--                                    <input type="text" name="sim_number" class="form-control"--}}
                                {{--                                           value="{{$tower->sim_number ?:old('sim_number')}}"--}}
                                {{--                                           placeholder="Enter sim number...">--}}
                                {{--                                    @error('sim_number')--}}
                                {{--                                    <div class="alert alert-danger">{{ $message }}</div>--}}
                                {{--                                    @enderror--}}
                                {{--                                </div>--}}
                                {{--                                <div class="col-md-6">--}}
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label for="sim_data_expired_date">SIM Data expire Date </label>--}}

                                {{--                                        <input type="date" name="sim_data_expired_date"--}}
                                {{--                                               class="form-control @error('sim_data_expired_date') is-invalid  @enderror"--}}
                                {{--                                               placeholder="Sim Data Expire Date Time"--}}
                                {{--                                               value="{{ $tower->sim_data_expired_date ?? '' }}"--}}
                                {{--                                               id="sim_data_expired_date">--}}

                                {{--                                    </div>--}}
                                {{--                                    @error('sim_data_expired_date')--}}
                                {{--                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>--}}
                                {{--                                    @enderror--}}

                                {{--                                </div>--}}

                                <div class="col-12 col-md-12">
                                    <label for="">Address</label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{$tower->address??old('address')}}" placeholder="Enter Address...">
                                    @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mno_site_id">MNO Site ID </label>
                                        <input type="text" name="mno_site_id" class="form-control @error('mno_site_id')
                                            is-invalid @enderror" placeholder="Enter MNO Site ID"
                                               value="{{ $tower->mno_site_id ?? '' }}" id="mno_site_id">

                                    </div>
                                    @error('mno_site_id')
                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ftb_site_id">FTB Site ID </label>

                                        <input type="text" name="ftb_site_id"
                                               class="form-control @error('ftb_site_id') is-invalid @enderror"
                                               placeholder="Enter FTB Site ID"
                                               value="{{ $tower->ftb_site_id ?? '' }}" id="ftb_site_id">

                                    </div>
                                    @error('ftb_site_id')
                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="col-12">
                                    <div class="row div-dist-thana">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="division">Division <span
                                                        class="text-danger">*</span></label>
                                                <select name="division" id="division"
                                                        class="form-control division div-select @error('division') is-invalid @enderror"
                                                        required>
                                                    <option value="" selected>Select Division</option>
                                                    @if (!empty($divisions))
                                                        @foreach ($divisions as $division)
                                                            <option value="{{ $division->id }}"
                                                                    {{ $tower->division_id == $division->id ? 'selected' : '' }}
                                                                    class="">{{ $division->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @error('division')
                                            <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                            @enderror

                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="district">District <span
                                                        class="text-danger">*</span></label>
                                                <select name="district" id="district"
                                                        class="form-control district dist-select  @error('district') is-invalid @enderror"
                                                        required>
                                                    <option value="">Select District</option>

                                                    @if ($tower->district_id)
                                                        <option selected value="{{ $tower->district_id }}">
                                                            {{ $tower->district->name }}</option>
                                                    @endif

                                                </select>
                                            </div>
                                            @error('district')
                                            <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                            @enderror

                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="thana">Thana <span
                                                        class="text-danger">*</span></label>
                                                <select name="thana" id="thana"
                                                        class="form-control thana thana-select  @error('thana') is-invalid  @enderror"
                                                        required>
                                                    <option value="">Select Thana</option>

                                                    @if ($tower->upazila_id)
                                                        <option selected value="{{ $tower->upazila_id }}">
                                                            {{ $tower->upazila->name }}</option>
                                                    @endif

                                                </select>
                                            </div>
                                            @error('thana')
                                            <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-12">
                                            <div class="region-zone-sitecode row">
                                                <div class="col-sm-6">
                                                    <label for="region" class="">Region</label>
                                                    <select class="custom-select region-select" name="region"
                                                            id="region">
                                                        <option value="">Choose...</option>
                                                        @foreach ($tower->company->regions as $region)
                                                            <option
                                                                {{ $tower->region_id == $region->id ? 'selected' : '' }}
                                                                value="{{ $region->id }}">{{ $region->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="zone" class="">Zone</label>
                                                    <select class="custom-select zone-select" name="zone"
                                                            id="zone">
                                                        <option value="">Choose...</option>
                                                        @if ($tower->zone_id)
                                                            <option selected value="{{ $tower->zone_id }}">
                                                                {{ $tower->zone->title }}</option>
                                                        @endif

                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="sitecode"
                                                           class="">Sitecode</label>
                                                    <select class="custom-select sitecode-select" name="sitecode"
                                                            id="sitecode">
                                                        <option value="">Choose...</option>

                                                        @if ($tower->sitecode_id)
                                                            <option selected value="{{ $tower->sitecode_id }}">
                                                                {{ $tower->siteCode->title }}</option>
                                                        @endif

                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="vendor" class="">Vendor</label>
                                                    <select class="custom-select " name="vendor" id="vendor">
                                                        <option value="">Choose...</option>
                                                        @foreach ($tower->company->vendors as $vendor)
                                                            <option
                                                                {{ $tower->vendor_id == $vendor->id ? 'selected' : '' }}
                                                                value="{{ $vendor->id }}">{{ $vendor->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dc_low_voltage_value">DC Low Voltage Value <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" step="any" required name="dc_low_voltage_value" id="dc_low_voltage_value"
                                                               class="form-control"
                                                               value="{{$tower->dc_low_voltage_value}}">
                                                    </div>
                                                    @error('dc_low_voltage_value')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="llvd_fail_voltage_value">LLVD Voltage Value <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" step="any" required name="llvd_fail_voltage_value"
                                                               class="form-control" id="llvd_fail_voltage_value"
                                                               value="{{$tower->llvd_fail_voltage_value}}">
                                                    </div>
                                                    @error('llvd_fail_voltage_value')
                                                    <span class="alert alert-danger btn-xs">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--                            //Tenant--}}
                            @if ($towertenant->count() > 0)
                                <div class="form-group">
                                    <label for="model">Tenant Attachment </label>
                                </div>
                                @for ($i = 1; $i <= $companytenants->count(); $i++)
                                    <div class="form-group form-check tenant_attachment">
                                        <label class="form-check-label text-bold">
                                            Load Curr {{ $i }} :
                                        </label>

                                        <input type="radio" value="null" data-tenantTitle="None"
                                               data-loopid="{{ $i }}" data-tenantID=""
                                               class="tenant_class" checked
                                               name="load1_{{ $i }}"> None
                                        @foreach ($companytenants as $item)
                                            <input type="radio"
                                                   @if ($i == 1) {{ $tower->towerWiseTanents && $tower->firstTowerWiseTanent() && $tower->firstTowerWiseTanent()->tenant_id == $item->id ? 'checked' : '' }}

                                                   @elseif($i == 2)
                                                   {{ $tower->towerWiseTanents && $tower->secondTowerWiseTanent() && $tower->secondTowerWiseTanent()->tenant_id == $item->id ? 'checked' : '' }}

                                                   @elseif($i == 3)
                                                   {{ $tower->towerWiseTanents && $tower->thridTowerWiseTanent() && $tower->thridTowerWiseTanent()->tenant_id == $item->id ? 'checked' : '' }}

                                                   @elseif($i == 4)
                                                   {{ $tower->towerWiseTanents && $tower->fourthTowerWiseTanent() && $tower->fourthTowerWiseTanent()->tenant_id == $item->id ? 'checked' : '' }} @endif
                                                   value="{{ $item->id }}"
                                                   name="load1_{{ $i }}"
                                                   data-loopid="{{ $i }}"
                                                   data-tenantTitle="{{ $item->title }}"
                                                   data-tenantID="{{ $item->id }}" class="tenant_class">
                                            {{ $item->title }}
                                        @endforeach
                                    </div>
                                @endfor
                                <div class="form-group">
                                    <label for="model">Load Alarm Set in KWh</label>
                                </div>
                                <div class="row">
                                    <span class="d-none">{{ $i = 1 }}</span>
                                    @foreach ($towertenant as $comten)
                                        <div class="col-md-3">
                                            <div class="card h-100">
                                                <div class="card-body w3-light-gray">

                                                    <div class="form-group">

                                                        <label for="platenumber">Load {{ $i }}
                                                            </span><span
                                                                class="text-success load_{{ Str::limit($i, 4, '.') }}">

                                                                                @if ($comten->tenant_id)
                                                                    @php
                                                                        $tt = \App\Models\CompanyTenant::where('id', $comten->tenant_id)->first();
                                                                    @endphp
                                                                    <a
                                                                        href="#"><span
                                                                            class="badge badge-primary">{{ Str::limit($tt->title, 4, '..') }}</span></a>
                                                                @else
                                                                    <span
                                                                        class="badge badge-danger">None</span>
                                                                @endif

                                                                            </span> MAX </label>
                                                        <input type="hidden" name="con"
                                                               value="0">
                                                        <input type="hidden" name="tti"
                                                               value="{{ $comten->tenant_id }}">
                                                        <input type="hidden"
                                                               class="tanant_id_{{ $i++ }}"
                                                               value="{{ $comten->tenant_id }}"
                                                               name="tenant_id[]">
                                                        <input type="hidden" name="ttid[]"
                                                               value="{{ $comten->id }}">
                                                        <input type="hidden" name="tower_id"
                                                               value="{{ $comten->tower_id }}">
                                                        <input type="hidden" name="company_id"
                                                               value="{{ $comten->company_id }}">
                                                        <input type="text" name="max_loard[]"
                                                               class="form-control" placeholder="Load 1 Max"
                                                               value="{{ $comten->max_load }}"
                                                               id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @else
                                {{-- ================ --}}
                                <div class="form-group">
                                    <label for="model">Tenant Attachment</label>
                                </div>
                                @for ($i = 1; $i <= $companytenants->count(); $i++)
                                    <div class="form-group form-check tenant_attachment">
                                        <label class="form-check-label text-bold">
                                            Load Curr {{ $i }} :
                                        </label>
                                        <input type="radio" class="tenant_class"
                                               data-tenantTitle="None" data-tenantID=""
                                               data-loopid="{{ $i }}" value="null"
                                               name="load1_{{ $i }}"> None
                                        @foreach ($companytenants as $item)
                                            <input type="radio" value="{{ $item->id }}"
                                                   name="load1_{{ $i }}"
                                                   data-loopid="{{ $i }}"
                                                   data-tenantTitle="{{ $item->title }}"
                                                   data-tenantID="{{ $item->id }}" class="tenant_class">
                                            {{ $item->title }}
                                        @endforeach
                                    </div>
                                @endfor
                                <div class="form-group">
                                    <label for="model">Load Alarm Set in KWh</label>
                                </div>
                                <div class="row">
                                    @for ($i = 1; $i <= $companytenants->count(); $i++)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body w3-light-gray">
                                                    <div class="form-group">
                                                        <label for="platenumber">Load {{ $i }}
                                                            <span
                                                                class="text-success load_{{ $i }}"></span>
                                                            MAX </label>
                                                        <input type="hidden" name="con"
                                                               value="1">
                                                        <input type="hidden"
                                                               class="tanant_id_{{ $i }}"
                                                               name="tenant_id[]">
                                                        <input type="hidden" name="company_id"
                                                               value="{{ $company->id }}">
                                                        <input type="text" name="max_loard[]"
                                                               class="form-control" placeholder="Load 1 Max"
                                                               value="" id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                            @endif
                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-success form-control" value="Update Tower">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <!-- Select2 -->
    <script src="{{ asset('cp/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>


        function remove_tr_information() {
            // var elem = document.getElementByClass('voucher_information');
            //$(this).closest("tr").remove();
            //   $($(this).closest("tr")).remove()
            $('#myTable tr:last').remove();
            // elem.parentNode.removeChild(elem);
            // return false;
        }
    </script>




    <script type="text/javascript">


        $(function () {

            //////////////////////////////////

            $(document).ready(function () {


                var dists = <?php echo json_encode($districts); ?>;
                var thanas = <?php echo json_encode($thanas); ?>

                $(document).on("change", ".div-select", function (e) {
                    // e.preventDefault();
                    var that = $(this);
                    var q = that.val();


                    that.closest('.div-dist-thana').find(".thana-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'Thana'
                        }));

                    that.closest('.div-dist-thana').find(".dist-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'District'
                        }));

                    $.each(dists, function (i, item) {
                        if (item.division_id == q) {
                            that.closest('.div-dist-thana').find(".dist-select").append(
                                "<option value='" + item.id + "'>" + item.name +
                                "</option>");
                        }
                    });

                    $.each(thanas, function (i, item) {
                        if (item.division_id == q) {
                            that.closest('.div-dist-thana').find(".thana-select").append(
                                "<option value='" + item.id + "'>" + item.name +
                                "</option>");
                        }
                    });

                });


                $(document).on("change", ".dist-select", function (e) {
                    // e.preventDefault();

                    var that = $(this);
                    var q = that.val();

                    that.closest('.div-dist-thana').find(".thana-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'Thana'
                        }));

                    $.each(thanas, function (i, item) {
                        if (item.district_id == q) {
                            that.closest('.div-dist-thana').find(".thana-select").append(
                                "<option value='" + item.id + "'>" + item.name +
                                "</option>");
                        }
                    });

                });


            });
        });
    </script>

    <script class="">
        var load1 = '';
        $(document).on("click", ".tenant_class", function () {
            // console.log('ok');
            // let uniqueid = $(this).val();
            let for_loop_id = $(this).attr("data-loopid");
            let tenant_id = $(this).attr("data-tenantID");
            let tenant_title = $(this).attr("data-tenantTitle");

            $(".load_" + for_loop_id).html(tenant_title);
            $(".tanant_id_" + for_loop_id).val(tenant_id);

            console.log([for_loop_id, tenant_id, tenant_title]);
        });
    </script>

    <script type="text/javascript">
        $(function () {

            //////////////////////////////////

            $(document).ready(function () {

                var zones = <?php echo json_encode($tower->company->zones); ?>;
                var sitecodes = <?php echo json_encode($tower->company->siteCodes); ?>

                $(document).on("change", ".region-select", function (e) {
                    // e.preventDefault();

                    var that = $(this);
                    var q = that.val();


                    that.closest('.region-zone-sitecode').find(".sitecode-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'Sitecode'
                        }));

                    that.closest('.region-zone-sitecode').find(".zone-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'Zone'
                        }));

                    $.each(zones, function (i, item) {
                        if (item.region_id == q) {
                            that.closest('.region-zone-sitecode').find(".zone-select")
                                .append("<option value='" + item.id + "'>" + item.title +
                                    "</option>");
                        }
                    });

                    $.each(sitecodes, function (i, item) {
                        if (item.region_id == q) {
                            that.closest('.region-zone-sitecode').find(".sitecode-select")
                                .append("<option value='" + item.id + "'>" + item.title +
                                    "</option>");
                        }
                    });

                });


                $(document).on("change", ".zone-select", function (e) {
                    // e.preventDefault();

                    var that = $(this);
                    var q = that.val();

                    that.closest('.region-zone-sitecode').find(".sitecode-select").empty().append($(
                        '<option>', {
                            value: '',
                            text: 'Sitecode'
                        }));

                    $.each(sitecodes, function (i, item) {
                        if (item.zone_id == q) {
                            that.closest('.region-zone-sitecode').find(".sitecode-select")
                                .append("<option value='" + item.id + "'>" + item.title +
                                    "</option>");
                        }
                    });

                });


            });
        });
    </script>

@endpush

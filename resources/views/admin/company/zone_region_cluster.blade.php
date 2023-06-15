@extends('admin.layout.master')
@push('title')
    Admin | Company Zone Region Cluster
@endpush
@push('css')
@endpush

@section('body')
    <section class="content">
        <br>

        <div class="row">
            <div class="col-md-8 offset-md-2">


                <div class="row">
                    {{-- region --}}
                    <div class="col-md-12">
                        <div class="card w3-animate-zoom shadow">
                            <div class="card-body">
                                All Regions, Zones, Sitecode, Clusters and Vendors of Company <span
                                    class="badge badge-primary">{{ $company->title }}</span>

                                <div class="float-right">
                                    <a class="btn btn-outline-primary btn-xs" href="{{ route('companies.index') }}">
                                        <i class="fas fa-angle-left"></i> All Companies</a>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    All Regions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('addregion', $company) }}" class="form-group"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" name="title" id="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Description</label>
                                                    <input type="text" class="form-control" name="description" id="">
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <label for=""><input type="checkbox" name="active" id=""></label>
                                                    Active

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <tbody>
                                            <tr>
                                                <th>SL</th>
                                                <th>Title</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                            </tbody>
                                            @foreach ($regions as $reg)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ ucfirst($reg->title) }}</td>
                                                    {{-- <td>{{ucfirst($reg->description)}}</td> --}}
                                                    <td>{{ $reg->active == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <a href="{{ route('editRegionDetails', ['company' => $company, 'region' => $reg]) }}"
                                                           class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./ end region --}}

                    {{-- zone --}}
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Zone
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('addNewZone', $company) }}" class="form-group"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Region</label>
                                                    <select name="region" id="" class="form-control">
                                                        <option value="">Select Region</option>
                                                        @if (isset($regions))
                                                            @foreach ($regions->where('active', 1) as $re)
                                                                <option value="{{ $re->id }}">{{ $re->title }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" name="title" id="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Description</label>
                                                    <input type="text" class="form-control" name="description" id="">
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <label for=""><input type="checkbox" name="active" id=""></label>
                                                    Active

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <tbody>
                                            <tr>
                                                <th>SL</th>
                                                <th>Region</th>
                                                <th>Title</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                            </tbody>
                                            @foreach ($zones as $zone)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $zone->region ? $zone->region->title : '' }}</td>
                                                    <td>{{ ucfirst($zone->title) }}</td>
                                                    <td>{{ $zone->active == 1 ? 'Active' : 'Inactive' }}</td>

                                                    <td>
                                                        <a
                                                            href="{{ route('editZone', ['company' => $company, 'zone' => $zone]) }}"><i
                                                                class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./edn zone --}}

                    {{-- site code --}}
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Site Code
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('addNewSiteCode', $company) }}" class="form-group"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="">Region</label>
                                                    <select name="region" id="region" class="form-control">
                                                        <option value="">Select Region</option>
                                                        @if (isset($regions))

                                                            @foreach ($regions->where('active', 1) as $re)
                                                                <option value="{{ $re->id }}">{{ $re->title }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="">Zone</label>
                                                    <select name="zone" id="zone" class="form-control">
                                                        <option value="">Select Zone</option>
                                                        {{-- @if (isset($zones))

                                                            @foreach ($zones->where('active', 1) as $zone)
                                                                <option value="{{ $zone->id }}">{{ $zone->title }}
                                                                </option>
                                                            @endforeach
                                                        @endif --}}
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" name="title" id="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Description</label>
                                                    <input type="text" class="form-control" name="description" id="">
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <label for=""><input type="checkbox" name="" id=""></label> Active

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <tbody>
                                            <tr>
                                                <th>SL</th>
                                                <th>Region</th>
                                                <th>Zone</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                            </tbody>
                                            @foreach ($sitecodes as $scode)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $scode->region ? $scode->region->title : '' }}</td>

                                                    <td>{{ $scode->zone ? $scode->zone->title : '' }}</td>
                                                    <td>{{ ucfirst($scode->title) }}</td>
                                                    <td>
                                                        <a href="{{ route('updateSiteCode', ['company' => $company, 'scode' => $scode]) }}"
                                                           class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./edn site code --}}



                    {{-- cluster --}}
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Cluster
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('addCluster', $company) }}" class="form-group"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" name="title" id="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Description</label>
                                                    <input type="text" class="form-control" name="description" id="">
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <label for=""><input type="checkbox" name="active" id=""></label>
                                                    Active

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <tbody>
                                            <tr>
                                                <th>SL</th>
                                                <th>Title</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                            </tbody>
                                            @foreach ($clusters as $cluster)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ ucfirst($cluster->title) }}</td>
                                                    {{-- <td>{{ucfirst($reg->description)}}</td> --}}
                                                    <td>{{ $cluster->active == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <a href="{{ route('editClusterDetails', ['company' => $company, 'cluster' => $cluster]) }}"
                                                           class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./ end cluster --}}



                    {{-- vendor --}}
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Vendors
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('addVendor', $company) }}" class="form-group"
                                              method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Title</label>
                                                    <input type="text" class="form-control" name="title" id="">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">Description</label>
                                                    <input type="text" class="form-control" name="description" id="">
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <label for=""><input type="checkbox" name="active" id=""></label>
                                                    Active

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <tbody>
                                            <tr>
                                                <th>SL</th>
                                                <th>Title</th>
                                                <th>Active</th>
                                                <th>Action</th>
                                            </tr>
                                            </tbody>
                                            @foreach ($vendors as $vendor)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ ucfirst($vendor->title) }}</td>
                                                    {{-- <td>{{ucfirst($reg->description)}}</td> --}}
                                                    <td>{{ $vendor->active == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <a href="{{ route('editVendorDetails', ['company' => $company, 'vendor' => $vendor]) }}"
                                                           class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ./ end vendor --}}




                    {{-- Tenant --}}
                    {{-- <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Tenant Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{route('admin.addTenantPost',$company)}}" class="form-group"
                                            method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="tenant_title">Title</label>
                                                    <input type="text" class="form-control" name="tenant_title" id="tenant_title" value="{{ old('tenant_title') }}">

                                                </div>
                                                <div class="col-md-3">
                                                    <label for="tenant_description">Description</label>
                                                    <textarea type="text" class="form-control" name="tenant_description" value="{{ old('tenant_description') }}" id="tenant_description" rows="1" cols="2"></textarea>
                                                </div>
                                                <div class="col-md-2 mt-4">
                                                    <input type="checkbox" name="tenant_active"  id="">
                                                    <label for="">Active</label>

                                                </div>
                                                <div class="col-md-3 mt-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-sm table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="20">SL</th>
                                                    <th>Action</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            </tbody>
                                            @foreach ($tenants as $tenant)

                                            <tr>
                                                <td>
                                                    {{$loop->index + 1}}
                                                </td>

                                                <td width="120">
                                                    <a title="Edit" data-toggle="tooltip" href="{{route('company.editTenant',['company'=>$company,'tenant'=>$tenant])}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>


                                                </td>
                                                <td> {{ucfirst($tenant->title)}} </td>
                                                <td>{!!$tenant->description!!}</td>
                                                <td>{{$tenant->active==1 ? 'Active' : 'Inactive'}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- ./tenant --}}
                </div>
            </div>

        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('#all-checked').click(function (event) {
                if (this.checked) {
                    // Iterate each checkbox
                    $('.checkboxPrimary3').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.checkboxPrimary3').each(function () {
                        this.checked = false;
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#category").change(function () {
                var catId = $("#category").val();
                var url = window.location.origin + `/company/category/${catId}/get-subcat`;
                $.getJSON(url, function (data) {

                    $('#subcategory').empty()
                    $('#subcategory').append(`<option value="">Select Zone</option>`);

                    data.forEach(element => {
                        $('#subcategory').append(`
                <option value="${element.id}">${element.title}</option>
                `)
                    });
                });
            });

            $("#region").change(function () {
                var catId = $("#region").val();
                var url = window.location.origin + `/region/${catId}/to/zone`;
                $.getJSON(url, function (data) {

                    $('#zone').empty()
                    $('#zone').append(`<option value="">Select Zone</option>`);

                    data.forEach(element => {
                        $('#zone').append(`
                <option value="${element.id}">${element.title}</option>
                `)
                    });
                });
            });

            $("#subcategory").change(function () {
                var catId = $("#subcategory").val();
                var url = window.location.origin + `/company/zone/${catId}/get-sitecode`;
                $.getJSON(url, function (data) {

                    $('#site').empty()
                    $('#site').append(`<option value="">Select SiteCode</option>`);

                    data.forEach(element => {
                        $('#site').append(`
                <option value="${element.id}">${element.title}</option>
                `)
                    });
                });
            });
        })
    </script>
@endpush

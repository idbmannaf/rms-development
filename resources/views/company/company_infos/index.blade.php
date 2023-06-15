@extends('company.layout.master')
@push('title')
    Company| {{$company->name}}
@endpush
@section('body')
    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card p-0">
                        <div class="card-header bg-card-header">
                            <h5 class="">{{$company->name}}</h5>
                        </div>

                        <div class="card-body p-0 m-0">
                            <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th width="100">Action</th>
                                    <th>Logo</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Address</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>

                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-success dropdown-toggle no-print" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu dropdown-index-" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route('company-infos.edit',$company->id)}}">Edit</a>
                                                      </div>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{asset('/')}}{{$company->logo}}" alt="" height="50" width="50">
                                        </td>
                                        <td>{{$company->name}}</td>
                                        <td>{{$company->user->username}}</td>
                                        <td>{{$company->address}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
@push('script')
@endpush


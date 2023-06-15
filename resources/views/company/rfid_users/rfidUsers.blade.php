@extends('company.layout.master')
@section('title', 'Rfid Users')

@push('css')
@endpush

@section('body')
    <section class="content w3-light-gray">

        <br>
        <div class="row">

            <div class="col-sm-12">

                <div class="card ">
                    <div class="card-header bg-card-header">
                        <h3 class="card-title">
                            <i class="fa fa-university px-2"></i> Rfid Users Of Company : {{ $company->title ?? '' }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('company.rfid.add', $company) }}"
                               class="btn btn-sarbs-one btn-sm "><i class="fa fa-plus px-2"></i>Create New
                                Rfid
                                Users</a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">


                            <table class="table table-bordered table-sm table-striped text-nowrap">
                                <thead>
                                <tr class="text-success">
                                    <th>SL</th>
                                    <th width="200px">Action</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Access RFID No</th>
                                    <th>User ID No</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th>Blood Group</th>
                                    <th>NID No</th>
                                    <th>Date of Expired</th>

                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td width="250">


                                            <div class="dropdown mb-1">

                                                <div class="btn-group ">
                                                    <button type="button"
                                                            class="btn btn-primary  btn-xs dropdown-toggle"
                                                            data-toggle="dropdown">
                                                        Option
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a
                                                            href="{{ route('company.rfid.edit', ['company'=>$company,'id'=>$item->id]) }}">
                                                            <button
                                                                type="button"
                                                                class="dropdown-item btn btn-primary btn-xs">Edit
                                                            </button>
                                                        </a>

                                                        <a href="{{ route('company.rfid.userWiseSmuDetails', ['company'=>$company,'id'=>$item->id]) }}"
                                                           class="dropdown-item btn btn-info btn-xs">Smu Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <div class="text-info">Active</div>
                                            @else
                                                <div class="text-danger">In-Active</div>
                                            @endif
                                        </td>
                                        <td>{{ $item->name ?? '' }}</td>
                                        <td>{{ $item->rfid ?? '' }}</td>
                                        <td>{{ $item->employee_id ?? '' }}</td>
                                        <td>{{ $item->email ?? '' }}</td>
                                        <td>{{ $item->mobile_no ?? '' }}</td>
                                        <td>{{ $item->blood_group ?? '' }}</td>
                                        <td>{{ $item->nid ?? '' }}</td>
                                        <td>{{ $item->doe ?? '' }}</td>


                                    </tr>
                                @endforeach
                                </tbody>

                            </table>


                        </div>


                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


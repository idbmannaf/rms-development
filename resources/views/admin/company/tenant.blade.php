@extends('admin.layout.master')
@push('title')
    Admin | Company
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="card p-0">
                <div class="card-header bg-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Tenants Of Company: {{$company->name}}</h5>
                        <div>
                            <a href="" class="btn btn-sm btn-sarbs-one" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Add Tenant</a>
                            <a href="" class="btn btn-sm btn-warning">Back</a>
                        </div>
                    </div>
                </div>

{{--                Modal--}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-card-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Tenant</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('companyTenant',$company)}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" value="{{old('title')}}" class="form-control">
                                        @error('title')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" value="{{old('description')}}" class="form-control">
                                        @error('description')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="active"> <input type="checkbox" name="active" id="active"> Active</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="">&nbsp;</label>
                                        <input type="submit" class="btn btn-sarbs-one">
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Action</th>
                            <th>Company Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Active</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl = 1;
                        ?>
                        @foreach($company_tenants as $tenant)
                            <tr>
                                <td>{{$sl++}}</td>
                                <td><a href="" class="btn btn-sm btn-sarbs-one" data-toggle="modal" data-target="#editTenant{{$tenant->id}}" data-whatever="@fat"><i class="fas fa-edit"></i></a></td>
                                <td>{{$tenant->company? $tenant->company->name : ''}}</td>
                                <td>{{$tenant->title}}</td>
                                <td>{{$tenant->description}}</td>
                                <td>{{$tenant->active ? 'Yes' : 'No' }}</td>
                            </tr>



                            {{--                Edit--}}
                            <div class="modal fade" id="editTenant{{$tenant->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-card-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Tenant</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('companyTenant.update',[$company,$tenant])}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" value="{{$tenant->title ?? old('title')}}" class="form-control">
                                                    @error('title')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <input type="text" name="description" value="{{$tenant->description ?? old('description')}}" class="form-control">
                                                    @error('description')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="active"> <input {{$tenant->active? 'checked' : ''}} type="checkbox" name="active"> Active</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <input type="submit" class="btn btn-sarbs-one" value="Update">
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-right mr-3 mt-3 small" style="font-size:12px"  >

                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection



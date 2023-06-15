@extends('admin.layout.master')
@push('title')
    Admin | Company
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card p-0">
                        <div class="card-header bg-info">
                            <h3 class="card-title">All Companies</h3>
                        </div>

                        <div class="card-body p-0 m-0">
                            <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th width="20">SL NO</th>
                                    <th width="100">Action</th>
                                    <th>Logo</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Address</th>
                                    <th>Active</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = (($companies->currentPage() - 1) * $companies->perPage() + 1); ?>
                                @forelse($companies as $company)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-success dropdown-toggle no-print" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu dropdown-index-" aria-labelledby="dropdownMenuButton">
                                                    {{--                                                    <a class="dropdown-item" href="">view</a>--}}
                                                    <a class="dropdown-item" href="{{route('companies.edit',$company->id)}}">Edit</a>
{{--                                                    <form action="{{route('companies.destroy',$company->id)}}" method="POST" id="deleteForm">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('DELETE')--}}
{{--                                                        <button class="dropdown-item" onclick="return confirm('Are you sure?');">Delete</button>--}}
{{--                                                    </form>--}}
                                                    <a class="dropdown-item" href="{{route('companyTenant',$company->id)}}">Tenant</a>
                                                    <a class="dropdown-item" href="{{route('zoneRegionCluster',$company->id)}}">Region</a>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{asset('/')}}{{$company->logo}}" alt="" height="50" width="50">
                                        </td>
                                        <td>{{$company->name}}</td>
                                        <td>{{$company->user->username}}</td>
                                        <td>{{$company->address}}</td>
                                        <td>
                                            <input type="checkbox" {{$company->active==1?'checked':''}} name="toggle" data-toggle="toggle" value="{{$company->id}}" data-size="sm" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="float-right mr-3 mt-3 small" style="font-size:12px"  >
                                {{$companies->links()}}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('script')
    <script>
        $(document).on('change', 'input[name=toggle]', function(){
            // alert(1);
            var mode=$(this).prop('checked');
            var id=$(this).val()
            $.ajax({
                url:"{{route('companies.active')}}",
                type:"POST",
                data:{
                    _token:'{{csrf_token()}}',
                    mode:mode,
                    id:id,
                },
                success:function(response){
                    if(response.status){
                        alert(response.msg);
                        // swal({
                        //     title: "Good job!",
                        //     text: response['msg'],
                        //     icon: "success",
                        //     button: "OK!",
                        // });
                    }
                    else{
                        alert('please try again');
                    }
                }
            })
        });
    </script>
@endpush


@extends('admin.layout.master')
@push('title')
    Admin | {{$status ? $status : ''}} Towers
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-0">
                        <div class="card-header bg-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">{{$status ? $status : ''}} Towers</h3>
                                <a href="{{route('towers.create')}}" class="btn btn-sm btn-warning"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <div class="table-responsive">
                                <table class="table table-sm  table-bordered table-striped text-nowrap">
                                    <thead>
                                    <tr>
                                        <th width="20">#SL</th>
                                        <th width="100">Action</th>
                                        <th>Status</th>
                                        <th>ChipID</th>
                                        <th>Last Connected</th>
                                        <th>MNO Site ID</th>
                                        <th>FTB Site ID</th>
                                        <th>Site Name</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Thana</th>
                                        <th>Company</th>
                                        <th>Address</th>
                                        <th>Sim Number</th>
                                        <th>Active</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = (($towers->currentPage() - 1) * $towers->perPage() + 1); ?>
                                    @forelse($towers as $item)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>
                                                <a href="{{route('towers.edit',$item->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="{{route('admin.tower_data',$item->id)}}" class="btn btn-warning btn-sm"><i class="fas fa-th"></i></a>
                                                <a title="Active Device" href="{{route('admin.tower.active_device.index',$item->id)}}" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>

                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                @if($item->last_connected_at > now()->subMinutes(4))
                                                    <i class="fas fa-circle blink_me text-success"></i>
                                                @endif

                                            </td>
                                            <td>{{ $item->chipid ?? "" }}</td>


                                            <td>{{ $item->last_connected_at ?? "" }}</td>
                                            <td>{{ $item->mno_site_id ?? "" }}</td>
                                            <td>{{ $item->ftb_site_id ?? "" }}</td>
                                            <td>{{ $item->name ?? "" }}</td>
                                            <td>{{ $item->division ? $item->division->name : '' }}</td>
                                            <td>{{ $item->district ? $item->district->name : '' }}</td>
                                            <td>{{ $item->upazila ? $item->upazila->name : '' }}</td>

                                            <td>{{ $item->company ? $item->company->name :'' }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->sim_number }}</td>
                                            <td>
                                                <input type="checkbox" {{$item->active==1?'checked':''}} name="toggle"
                                                       data-toggle="toggle" value="{{$item->id}}" data-size="sm"
                                                       data-on="Active" data-off="Inactive" data-onstyle="success"
                                                       data-offstyle="danger">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-danger text-center">No Data Found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{$towers->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('script')
    <script>
        $(document).on('change', 'input[name=toggle]', function () {
            // alert(1);
            var mode = $(this).prop('checked');
            var id = $(this).val()
            $.ajax({
                url: "{{route('towers.active')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    mode: mode,
                    id: id,
                },
                success: function (response) {
                    if (response.status) {
                        alert(response.msg);
                        // swal({
                        //     title: "Good job!",
                        //     text: response['msg'],
                        //     icon: "success",
                        //     button: "OK!",
                        // });
                    } else {
                        alert('please try again');
                    }
                }
            })
        });
    </script>
@endpush


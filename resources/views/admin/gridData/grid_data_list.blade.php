@extends('admin.layout.master')
@push('title')
    Admin | Grid Data
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card p-0">
                        <div class="card-header bg-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Grid Data @if($tower) Of chipid:{{$tower->chipid}} and Tower: {{$tower->name}} @endif</h3>
{{--                                <a href="{{route('towers.create')}}" class="btn btn-sm btn-warning"><i class="fas fa-plus"></i></a>--}}
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <table class="table table-sm table-responsive-sm table-bordered table-striped text-nowrap">
                                <thead>
                                <tr>
                                    <th width="20">#SL</th>
                                    <th>DateTime</th>
                                    <th>Chipid</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = (($grid_data->currentPage() - 1) * $grid_data->perPage() + 1); ?>
                                @forelse($grid_data as $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->chipid}}</td>
                                        <td>{{$data->row_data}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-danger text-center">No Data Found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="float-right mr-3 mt-3 small" style="font-size:12px"  >
                                {{$grid_data->links()}}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('script')
@endpush


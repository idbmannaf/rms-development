@extends('company.layout.master')
@push('title')
    Company | Tower
@endpush

@section('body')
    @php
        $table = 'tower_data'; // Replace 'users' with your actual table name
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
    @endphp

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-0">
                        <div class="card-header bg-card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Data of Device : {{$active_device->device->device_name}} &
                                    Tower/RMS: {{$tower->name}}
                                    ({{$tower->mno_site_id}}) </h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            @foreach($data->first()->getOriginal() as $key => $value)
                                                <th>{{  Str::title(str_replace("_", " ", $key)) }}</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $item)
                                        <tr>
                                            @foreach($item->getOriginal() as $val)
                                                <td>{{ $val }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$data->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')

@endpush


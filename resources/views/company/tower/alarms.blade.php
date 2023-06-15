@extends('company.layout.master')
@push('title')
    Company | Tower
@endpush

@section('body')

    <section class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card p-0">
                        <div class="card-header bg-card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Alarms Of Tower/RMS: {{$tower->name}} ({{$tower->mno_site_id}})</h3>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <div class="table-responsive table-responsive-sm">
                                <table
                                    class="table table-bordered table-sm table-striped text-nowrap w3-white text-nowrap">
                                    <thead>
                                    <tr class="text-success-">
                                        <th>SL</th>

                                        {{--                                            <th width="80">Action</th>--}}
                                        <th>SiteId</th>
                                        <th>Status</th>
                                        <th>Alarm Started</th>
                                        <th>Alarm Ended</th>
                                        <th>Duration</th>
                                        <th>Category</th>
                                        <th>Alarm Name</th>
                                        <th>Alarm Source</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?php $i = (($datas->currentPage() - 1) * $datas->perPage() + 1); ?>

                                    @foreach($datas as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            {{--                                                <td>--}}
                                            {{--                                                    <div class="btn-group no-print">--}}
                                            {{--                                                        <a class="btn btn-outline-danger btn-xs"--}}
                                            {{--                                                           href="{{ route('company.companyTowerAlarmDetails',[$company,$item]) }}">Details</a>--}}
                                            {{--                                                    </div>--}}
                                            {{--                                                </td>--}}
                                            <td>
                                                {{ $item->tower ? $item->tower->mno_site_id: '' }}
                                            </td>
                                            <td  style="text-align: center; vertical-align: middle;">
                                                @if($item->live)
                                                    <i class="fas fa-circle blink_me text-success"></i>
                                                @endif

                                                {{ $item->live ? 'Live' : 'History' }}
                                            </td>
                                            <td>
                                                {{ $item->alarm_started_at }}
                                            </td>

                                            <td>

                                                {{ $item->live ? 'Running' : $item->alarm_ended_at }}
                                            </td>
                                            <td> {{ diffTime($item->alarm_started_at, ($item->live ? \Carbon\Carbon::now() : $item->alarm_ended_at) )}}</td>
                                            <td>
                                                {{ $item->alarm_category }}
                                            </td>

                                            <td>
                                                {{ $item->alarm_title }}
                                            </td>
                                            <td>
                                                {{ $item->alarmSource() }}
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>


                            </div>
                            {{$datas->links()}}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </section>

@endsection

@push('script')

@endpush


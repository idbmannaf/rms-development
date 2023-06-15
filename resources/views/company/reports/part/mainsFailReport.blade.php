<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-12">


            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ request()->report_type }} Report
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url()->full() . '&export_type=mains_fail' }}"
                           class="btn btn-outline-success">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="percent last">
                                <svg>
                                    <circle cx="100" cy="100" r="80"></circle>
                                    <circle cx="100" cy="100" r="80"
                                            style="--percent: {{$mains_fail}}"></circle>
                                </svg>
                                <div class="number">
                                    <h4 style="font-weight:700; color:red;">{{$mains_fail}}<span>%</span></h4>
                                </div>
                                <div class="d-flex justify-content-center align-items-center"
                                     style="padding: 34px 15px;">
                                    <div class="rise">
                                        <!--<div class="rise_text">DC Power Unvailability</div>-->
                                        <div class="rise_text">Mains Fail</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="col-12 col-md-6">--}}
                        {{--                            <div class="percent last timezone">--}}
                        {{--                                <svg style="stroke: green">--}}
                        {{--                                    <circle cx="100" cy="100" r="80"></circle>--}}
                        {{--                                    <circle cx="100" cy="100" r="80"--}}
                        {{--                                            style="--percent: 100"></circle>--}}
                        {{--                                </svg>--}}
                        {{--                                <div class="number">--}}
                        {{--                                    <h4 style="font-weight:700; color:red;">{{$mains_fail_sum}}<span>%</span></h4>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="d-flex justify-content-center align-items-center"--}}
                        {{--                                     style="padding: 34px 15px;">--}}
                        {{--                                    <div class="rise">--}}
                        {{--                                        <!--<div class="rise_text">DC Power Unvailability</div>-->--}}
                        {{--                                        <div class="rise_text">Mains Fail</div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="col-12 col-md-6">
                            <div class="d-flex flex-column align-items-center mt-3">
                                <div class="time_mother">
                                    <div class="time_position">
                                        <h1>{{$mains_fail_sum}}</h1>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-center"
                                     style="padding: 33px 15px;">
                                    <div class="rise">
                                        <!--<div class="rise_text">DC Power Unvailability</div>-->
                                        <div class="rise_text">Mains Fail Time</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{--                        <div class="col-12 col-md-6">--}}
                        {{--                            <div class="d-flex flex-column">--}}
                        {{--                                <div class="time_mother">--}}
                        {{--                                    <div class="time_position">--}}
                        {{--                                        <h1>{{$mains_fail_sum}}</h1>--}}

                        {{--                                    </div>--}}

                        {{--                                </div>--}}
                        {{--                                <div class="d-flex justify-content-center align-items-center"--}}
                        {{--                                     style="padding: 34px 15px;">--}}
                        {{--                                    <div class="rise">--}}
                        {{--                                        <!--<div class="rise_text">DC Power Unvailability</div>-->--}}
                        {{--                                        <div class="rise_text">Mains Fail Time</div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                            </div>--}}
                        {{--                        </div>--}}


                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <th>Date</th>
                            <th>Phase Voltage A</th>
                            <th>Phase Voltage B</th>
                            <th>Phase Voltage C</th>
                            <th>Phase Current A</th>
                            <th>Phase Current V</th>
                            <th>Phase Current C</th>
                            </thead>
                            <tbody>
                           @foreach($datas as $item)
                               <tr>
                                   <td>{{$item->created_at}}</td>
                                   <td>{{$item->voltage_phase_a}}</td>
                                   <td>{{$item->voltage_phase_b}}</td>
                                   <td>{{$item->voltage_phase_c}}</td>
                                   <td>{{$item->current_phase_a}}</td>
                                   <td>{{$item->current_phase_b}}</td>
                                   <td>{{$item->current_phase_c}}</td>
                               </tr>
                           @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

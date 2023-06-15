@extends('company.layout.master')
@push('title')
    Company  Dashboard
@endpush
@push('css')
    <style>
        .a-full-width {
            padding-left: 4%;
            padding-right: 3%;
            display: inline-block;
            width: 100%;
            font-size: 20px;
            font-family: serif;
            padding-top: 5%;
            padding-bottom: 5%;
            background-color: #096ba6;
            color: #ffffff;
        }

        .a-full-width:hover {
            color: #fff !important;
            background: #3670d4;
            text-decoration: none !important;
        }

        .a-full-width-alarms {
            padding-left: 4%;
            padding-right: 3%;
            display: inline-block;
            width: 99%;
            font-size: 13px;
            /*font-family: serif;*/
            padding-top: 2%;
            padding-bottom: 2%;
            background-color: #fff;
            color: #2a0606;
            /*color: #ffffff;*/
        }

        .a-full-width-alarms:hover {
            color: #2a1414 !important;
            /*color: #fff !important;*/
            background: rgba(54, 112, 212, 0.22);
            text-decoration: none !important;
        }

        .card .percent {
            position: relative;
            text-align: center;
        }

        .card svg {
            position: relative;
            width: 210px;
            height: 210px;
            transform: rotate(-90deg);
        }

        .card svg circle {
            width: 100%;
            height: 100%;
            fill: none;
            stroke: #f0f0f0;
            stroke-width: 35;
            stroke-linecap: round;
        }

        .card svg circle:last-of-type {
            stroke-dasharray: 500px;
            stroke-dashoffset: calc(500px - (500px * var(--percent)) / 100);
            stroke: #3498db;
        }

        .card .number {
            position: absolute;
            top: 37%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .card .number h3 {
            font-weight: 700;
            font-size: 31px;
        }

        .card .number h3 span {
            font-size: 2rem;
        }

        .card .title h2 {
            margin: 25px 0 0;
        }

        .card .title h2 {
            margin: 25px 0 0;
        }

        .card:nth-child(1) svg circle:last-of-type {
            stroke: #06BCC1;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 300px;
        }

        .chart-buttons {
            position: absolute;
            top: -17px;
            display: flex;
            right: 65px;
            justify-content: space-between;
        }

        .chart-buttons a {
            margin-left: 10px;
            font-size: 12px;
            padding: 2px;
            cursor: pointer;
            border-radius: 2px;
        }

        .chart-title {
            font-size: 20px;
            /* Adjust the font size */
            text-align: center;
        }


        .chart-buttons a.active {
            background-color: #4CAF50;
            color: white;
        }

        .chart-buttons a:not(.active) {
            background-color: #e7e7e7;
            color: black;
        }
    </style>
@endpush

@section('body')

    <?php
    $startDate = \Carbon\Carbon::now()->subDays(3)->toDateString();
    $endDate = \Carbon\Carbon::now()->toDateString();
    ?>
    <section class="content w3-light-gray py-2">
        <div class="row">
            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1 ml-2 p-0">
                    <a href="{{ route('tower.lists', $company) }}" class="box-shadow a-full-width">
                        <span class="float-left">Total RMS</span>
                        <span class="float-right">{{ $totalRms ?? 0}}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1  p-0">
                    <a href="{{  route('tower.lists', ['company' => $company, 'status' => 'online']) }}"
                       class="box-shadow a-full-width">
                        <span class="float-left">Online RMS</span>
                        <span class="float-right">{{  $onlineRms ?? 0 }}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1  p-0">
                    <a href="{{ route('tower.lists', ['company' => $company, 'status' => 'offline']) }}"
                       class="box-shadow a-full-width">
                        <span class="float-left">Offline RMS</span>
                        <span class="float-right">{{ $totalRms - $onlineRms }}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1  p-0">
                    <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'total','company'=>$company]) }}"
                       class="box-shadow a-full-width">
                        <span class="float-left">Total Locks</span>
                        <span class="float-right">{{ $totalLockTowers}}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1  p-0">
                    <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'close','company'=>$company]) }}"
                       class="box-shadow a-full-width">
                        <span class="float-left">Closed Locks</span>
                        <span class="float-right">{{ $towerCloseTowers}}</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-2 m-0 mb-2 p-0">
                <div class="mx-1 mr-2 p-0">
                    <a href="{{ route('company.rfid.towerLockUnlockData', ['type'=>'open','company'=>$company]) }}"
                       class="box-shadow a-full-width">
                        <span class="float-left">Open Locks</span>
                        <span class="float-right">{{ $towerOpenTowers}}</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($alarmInfoCats as $key=>$cat)
                <div class="col-md-6">
                    <div class="card rounded-0 p-0" style="background-color:transparent;">
                        <div class="card-header text-center rounded-0 p-2"
                             style="background-color:rgba(124,179,213,0.89) ">
                            {{ $cat->category }}
                        </div>
                        <div class="card-body p-1 pt-2 px-3">
                            <div class="row">
                                @foreach ($cat->catChildren() as $child)
                                    <?php $alert_count = $child->companyLiveCatAlarmCount($company->id)  ?>
                                    <div class="col-6 p-0">
                                        <div style="margin-left: 3px">
                                            <a href="{{ route('company.companyTowerAlarms', ['company' => $company, 'title' => $child->title]) }}"
                                               class="a-full-width-alarms">
                                                <span class="float-left">{{ $child->title }}</span>
                                                <span
                                                    class="float-right badge badge-warning right">{{$alert_count }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!--<div class="row">-->
        <!-- BAR CHART -->
        <!--    <div class="col-md-6">-->
        <!--        <div class="card card-info rounded-0 p-0">-->
        <!--            <div class="card-body p-1 px-3">-->
        <!--                <div class="chart">-->
        <!--                    <canvas id="barChart"-->
        <!--                            style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--    <div class="col-md-6">-->
        <!--        <div class="card card-info rounded-0 p-0">-->
        <!--            <div class="card-body p-1 px-3">-->
        <!--                <div class="chart">-->
        <!--                    <canvas id="sensorBarChart"-->
        <!--                            style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--<div class="col-md-4 d-none">-->
        <!--    <div class="card card-info rounded-0 p-0">-->
        <!--        <div class="card-body p-1 px-3">-->
        <!--            <div class="chart">-->
        <!--                <canvas id="ACDCBarChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--</div>-->

        {{--        <div class="d-none">--}}
        {{--            <canvas id="ACDCBarChart"--}}
        {{--                    style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>--}}
        {{--        </div>--}}
        {{--        <div class="row">--}}
        {{--            <!-- -->--}}
        {{--            <div class="col-md-4">--}}
        {{--                <div class="card rounded-0">--}}
        {{--                    <div class="card-header p-2 ">--}}
        {{--                        <h3 class="card-title d-flex justify-content-center">Power Consumption (<small>Average</small>)--}}
        {{--                        </h3>--}}
        {{--                        <div class="card-tools">--}}
        {{--                            <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">-->--}}
        {{--                            <!--    <i class="fas fa-minus"></i>-->--}}
        {{--                            <!--</button>-->--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body rounded-0 text-center">--}}
        {{--                        <input type="text" class="knob1" value="{{$avg_power_consumption}}" data-width="257" disabled--}}
        {{--                               onvolumechange="return false" data-height="257" data-fgColor="#39CCCC">--}}
        {{--                        <br>--}}
        {{--                        <strong>&nbsp;</strong>--}}
        {{--                    </div>--}}
        {{--                    <!-- /.card-body -->--}}
        {{--                </div>--}}
        {{--                <!-- /.card -->--}}
        {{--            </div>--}}
        {{--            <!-- -->--}}

        {{--            <div class="col-md-4">--}}
        {{--                <div class="card rounded-0">--}}
        {{--                    <div class="card-header p-2 ">--}}
        {{--                        <h3 class="card-title d-flex justify-content-center">DC Power Availability (<small>Percent And--}}
        {{--                                Time</small>)</h3>--}}
        {{--                        <div class="card-tools">--}}
        {{--                            <!--<button type="button" class="btn btn-tool" data-card-widget="collapse">-->--}}
        {{--                            <!--    <i class="fas fa-minus"></i>-->--}}
        {{--                            <!--</button>-->--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body rounded-0 text-center">--}}
        {{--                        <input type="text" class="knob2" value="{{$avg_dc_availibility}}" data-width="257" disabled--}}
        {{--                               onvolumechange="return false" data-height="257" data-max="{{100}}"--}}
        {{--                               data-fgColor="#39CCCC">--}}
        {{--                        <br>--}}
        {{--                        <strong>Time: {{getSecondToHours($dc_available_second)}}</strong>--}}
        {{--                    </div>--}}
        {{--                    <!-- /.card-body -->--}}
        {{--                </div>--}}
        {{--                <!-- /.card -->--}}
        {{--            </div>--}}
        {{--            <div class="col-md-4">--}}
        {{--                <div class="card rounded-0">--}}
        {{--                    <div class="card-header p-2 ">--}}
        {{--                        <h3 class="card-title d-flex justify-content-center">Power Slab (<small>Percent And Time</small>)--}}
        {{--                        </h3>--}}
        {{--                        <div class="card-tools">--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="card-body rounded-0 text-center">--}}
        {{--                        <input type="text" class="knob3" value="{{$avg_power_slab}}" data-width="257" data-step="1"--}}
        {{--                               data-min="0"--}}
        {{--                               data-max="{{100}}"--}}
        {{--                               disabled onvolumechange="return false" data-height="257" data-fgColor="#39CCCC">--}}
        {{--                        <br>--}}
        {{--                        <strong>Time: {{getSecondToHours($avg_power_slab_seconds)}}</strong>--}}

        {{--                    </div>--}}
        {{--                    <!-- /.card-body -->--}}
        {{--                </div>--}}
        {{--                <!-- /.card -->--}}
        {{--            </div>--}}
        {{--        </div>--}}


        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        Power Consumption
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="power_consumption"></canvas>
                            <div class="chart-buttons">
                                <a class="btn1 active" id="ps_dailyButton">Daily Average</a>
                                <a class="btn-2" id="ps_monthlyButton">Monthly Average</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        DC Power availability / AC Power availability
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="ac_dc_availability"></canvas>
                            <div class="chart-buttons">
                                <a class="btn1 active" id="ac_dc_dailyButton">Daily Average</a>
                                <a class="btn-2" id="ac_dc_monthlyButton">Monthly Average</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        Power Slab
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart-container">
                                <canvas id="powerSlab"></canvas>
                                <div class="chart-buttons">
                                    <a class="btn1 active" id="powerSlabDailyBtn">Daily Average</a>
                                    <a class="btn-2" id="powerSlabMonthlyBtn">Monthly Average</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    {{--        <script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>--}}
    {{--    <script>--}}
    {{--        $(function () {--}}
    {{--            /* jQueryKnob */--}}
    {{--            $('.knob1').knob({--}}
    {{--                stopper: true,--}}
    {{--                readOnly: true,--}}
    {{--            })--}}
    {{--            $('.knob2').knob({--}}
    {{--                stopper: true,--}}
    {{--                readOnly: true,--}}
    {{--            })--}}
    {{--            $('.knob3').knob({--}}
    {{--                stopper: true,--}}
    {{--                readOnly: true,--}}
    {{--            })--}}
    {{--            /* END JQUERY KNOB */--}}


    {{--        })--}}

    {{--    </script>--}}




    <!-- power_consumption Start  -->

    <script>
        // Example data
        const labels = [@foreach($power_con as $con) '{{$con->siteid}}' {{!$loop->last ? ',': '' }}  @endforeach];
        const ps_dailyAverages = [@foreach($power_con as $con) {{number_format($con->average_power,2,'.')}} {{!$loop->last ? ',': '' }}  @endforeach]; // Placeholder daily average data


        // Create canvas element
        const canvas = document.getElementById('power_consumption');

        // Create chart
        const ctx = canvas.getContext('2d');
        let chart; // Variable to hold the chart object

        // Function to update chart data based on button click
        function updateChartData(newData) {
            if (chart) {
                chart.data.datasets[0].data = newData;
                chart.update();
            }
        }

        // Add event listeners to buttons
        const ps_dailyButton = document.getElementById('ps_dailyButton');
        const ps_monthlyButton = document.getElementById('ps_monthlyButton');


        ps_dailyButton.addEventListener('click', function () {
            $.ajax({
                method:'GET',
                url:"{{route('company.powerConsumptionChartAjax',[$company,'daily'])}}",
                success:function (res) {
                    if(res.success){
                        updateChartData(res.data);
                        ps_dailyButton.classList.add('active');
                        ps_monthlyButton.classList.remove('active');
                    }
                }
            })
            // updateChartData(ps_dailyAverages);
            // ps_dailyButton.classList.add('active');
            // ps_monthlyButton.classList.remove('active');
        });


        ps_monthlyButton.addEventListener('click', function () {
            $.ajax({
                method:'GET',
                url:"{{route('company.powerConsumptionChartAjax',[$company,'monthly'])}}",
                success:function (res) {
                    if(res.success){
                        updateChartData(res.data);
                        ps_dailyButton.classList.add('active');
                        ps_monthlyButton.classList.remove('active');
                    }
                }
            })

            // updateChartData(ps_monthlyAverages);
            // ps_monthlyButton.classList.add('active');
            // ps_dailyButton.classList.remove('active');
        });

        // Create initial chart
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Average',
                        data: ps_dailyAverages,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                height: 200, // Adjust the height value as needed
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 0.01,
                        ticks: {
                            callback: function (value, index, values) {
                                return value + ' kw';
                            }
                        }
                    }
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <!-- power_consumption END  -->


    <!-- ac_dc_ -->
    <script>
        // Example data
        const labels2 = [@foreach($ac_dc as $con) '{{$con->siteid}}' {{!$loop->last ? ',': '' }}  @endforeach];
        const acDataDaily = [@foreach($ac_dc as $con) {{$con->ac_available}} {{!$loop->last ? ',': '' }}  @endforeach]; // AC Available Percentage
        const dcDataDaily = [@foreach($ac_dc as $con) {{$con->dc_available}} {{!$loop->last ? ',': '' }}  @endforeach]; // DC Daily Average
        const acDataMonthly = [50, 100, 150, 200, 250, 34]; // AC Monthly Average
        const dcDataMonthly = [60, 80, 120, 160, 220, 33]; // DC Monthly Average

        // Create canvas element
        const canvas2 = document.getElementById('ac_dc_availability');

        // Create chart with initial data (Daily Average)
        const ctx2 = canvas2.getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [
                    {
                        label: 'AC Availability',
                        data: acDataDaily,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    },
                    {
                        label: 'DC Availability',
                        data: dcDataDaily,
                        backgroundColor: '#096ba6'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                height: 200, // Adjust the height value as needed
                scales: {
                    y: {
                        beginAtZero: true,
                        // min: 0.01,

                    }
                },
                legend: {
                    display: false
                }
            }
        });

        // Button click event handlers
        const ac_dc_dailyButton = document.getElementById('ac_dc_dailyButton');
        const ac_dc_monthlyButton = document.getElementById('ac_dc_monthlyButton');

        ac_dc_dailyButton.addEventListener('click', function () {

            $.ajax({
                method:'GET',
                url:"{{route('company.acDcChartAjax',[$company,'daily'])}}",
                success:function (res) {
                    if(res.success){
                        chart2.data.datasets[0].data = res.acData;
                        chart2.data.datasets[1].data = res.dcData;
                        chart2.update();
                        ac_dc_dailyButton.classList.add('active');
                        ac_dc_monthlyButton.classList.remove('active');
                    }
                }
            })
            // chart2.data.datasets[0].data = acDataDaily;
            // chart2.data.datasets[1].data = dcDataDaily;
            // chart2.update();
            // ac_dc_dailyButton.classList.add('active');
            // ac_dc_monthlyButton.classList.remove('active');
        });

        ac_dc_monthlyButton.addEventListener('click', function () {

            $.ajax({
                method:'GET',
                url:"{{route('company.acDcChartAjax',[$company,'monthly'])}}",
                success:function (res) {
                    if(res.success){
                        chart2.data.datasets[0].data = res.acData;
                        chart2.data.datasets[1].data = res.dcData;
                        chart2.update();
                        ac_dc_monthlyButton.classList.add('active');
                        ac_dc_dailyButton.classList.remove('active');
                    }
                }
            })

            // chart2.data.datasets[0].data = acDataMonthly;
            // chart2.data.datasets[1].data = dcDataMonthly;
            // chart2.update();
            // ac_dc_monthlyButton.classList.add('active');
            // ac_dc_dailyButton.classList.remove('active');
        });
    </script>

    <!-- ac_dc_ -->

    <!-- power_slab  -->
    <script>
        // Get the canvas element
        const canvas4 = document.getElementById('powerSlab');
        const ctx4 = canvas4.getContext('2d');

        // Define the data for the chart
        const data = {
            labels: ['2kW', '2.5kW', '3kW', '3.5kW', '4kW'],
            datasets: [{
                label: 'Power Slab',
                data: [{{$p_slab->slot_1}},{{$p_slab->slot_2}},{{$p_slab->slot_3}},{{$p_slab->slot_4}},{{$p_slab->slot_5}}], // Assuming each slot has a count of 1
                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Set the background color for the bars
                borderColor: 'rgba(54, 162, 235, 1)', // Set the border color for the bars
                borderWidth: 1 // Set the border width for the bars
            }]
        };

        // Define the chart options
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            height: 200, // Adjust the height value as needed
            scales: {
                y: {
                    beginAtZero: true,
                }
            },
            //  title: {
            //     display: true,
            //     text: 'Percentage', // Set the desired title
            //     position: 'left'
            // },
            legend: {
                display: false
            },
        };

        // Create the bar chart
        const barChart = new Chart(ctx4, {
            type: 'bar',
            data: data,
            options: options
        });

        function updateChart(newData) {
            barChart.data.datasets[0].data = newData;
            barChart.update();
        }

        // Handle button clicks for Daily Average and Monthly Average
        const dailyButton = document.getElementById('powerSlabDailyBtn');
        const monthlyButton = document.getElementById('powerSlabMonthlyBtn');

        dailyButton.addEventListener('click', function () {
            $.ajax({
                method:'GET',
                url:"{{route('company.powerSlabChartAjax',[$company,'daily'])}}",
                success:function (res) {
                    if(res.success){
                        updateChart(res.data)
                        dailyButton.classList.add('active');
                        monthlyButton.classList.remove('active');
                    }
                }
            })


        });

        monthlyButton.addEventListener('click', function () {
            $.ajax({
                method:'GET',
                url:"{{route('company.powerSlabChartAjax',[$company,'monthly'])}}",
                success:function (res) {
                    if(res.success){
                        updateChart(res.data)
                        monthlyButton.classList.add('active');
                        dailyButton.classList.remove('active');
                    }
                }
            })


        });

    </script>
    <!-- power_slab -->
@endpush

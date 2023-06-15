@extends('company.layouts.companyMaster')
@section('title', 'Company Tower List')

@push('css')
@endpush

@section('content')
<section class="content">

    <div class="row">

        <div class="col-md-12">
            @include('company.companyTopMenu')



            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                      <div class="card-body p-2 shadow-lg">
                       
                            
                       <i class="fas fa-broadcast-tower"></i> RMS: {{ $alarm->tower->name }} ({{ $alarm->tower->mno_site_id }}) | Alarm Duration: {{ $alarm->alarm_started_at }} - {{ $alarm->alarm_ended_at }} | Category:{{ $alarm->alarm_category }} | Source: {{ $alarm->alarmSource() }}
                     
                      </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            This RMS Live Alarms: 
                            @foreach($alarm->tower->liveAlarms() as $key =>  $alrm)
                            

                           <a class="btn btn-danger btn-xs" href="{{ route('company.companyTowerAlarmDetails',[$company,$key]) }}">{{ $alrm }} Details</a>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

        <div class="col-sm-12">

            @include('alerts.alerts')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"> <i class="fa fa-university px-2"></i>
                       Digital Input Alarms of  {{ $company->title ?? '' }} 
                    </h3>
                    <div class="card-tools">
                         <button class="btn btn-xs w3-white float-right mx-1" onclick="exportTableToCSV('Alarm Details of {{ $alarm->tower->name }}')">Export To CSV</button>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped text-nowrap">
                        <thead>
                            <tr class="text-success-">
                               <th>SL</th>
                               <th>Date Time</th>
                               <th>Name</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $i = (($items->currentPage() - 1) * $items->perPage() + 1); ?>

                            @foreach($items as $item)

                            <tr>
                                <td>{{ $i++ }}</td>
                                 <td>{{ $item->created_at }}</td> 
                                 <td>
                                     {{ $item['dg_name_'. $alarm->alarm_number] }}


                                       
                                    @if($item['dg_nc_alerm_'. $alarm->alarm_number])
                                    <img src="{{asset('img/major.gif')}}" alt="" class="rounded-circle" title="Majur" >
                                    @else
                                    <img src="{{asset('img/normal.gif')}}" alt="" class="rounded-circle" title="Normal">
                                    @endif
                                    

                                 </td>

 
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



        </div>
    </div>
 
    
 
        </section>
        @endsection


        @push('js')

        <script type="text/javascript">
    
                function exportTableToCSV(filename) { 
                var csv = [];
                var rows = document.querySelectorAll("table tr");
                
                for (var i = 0; i < rows.length; i++) {
                    var row = [], cols = rows[i].querySelectorAll("td, th");
                    
                    for (var j = 0; j < cols.length; j++) 
                    row.push("\""+cols[j].innerText+"\"");
                    
                    csv.push(row.join(","));        
                }

                // Download CSV file
                downloadCSV(csv.join("\n"), filename);
            };


            function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

  
        </script>
        @endpush

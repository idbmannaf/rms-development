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
                                <a href="" class="btn  btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"
                                   data-whatever="@fat">Add Remote Access</a>
                            </div>
                        </div>

                        <div class="card-body p-0 m-0">
                            <div class="table-responsive">
                                <table class="table table-borderd table-sm">
                                    <thead>
                                    <tr>
                                        <th>Chipid</th>
                                        <th>Employee Name</th>
                                        <th>Rfid</th>
                                        <th>Door Opened At</th>
                                        <th>Door Closed At</th>
                                        <th>Duration</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas as $item)
                                        <tr>
                                            <td>{{$item->chipid}}</td>
                                            <td>{{$item && $item->employee ? $item->employee->name : ''}}</td>
                                            <td>{{$item ? $item->rfid_employee_id : ''}}</td>
                                            <td>{{$item ? $item->door_open_at : ''}}</td>
                                            <td>{{$item ? $item->door_closed_at : ''}}</td>
                                            <td>{{$item ? $item->dore_open_duration : ''}}</td>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Give Door Open Access</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form
                            action="{{ route('company.tower.towerDetailsEntryExitHistoryLogCreateByChipIdPost', [$company,$tower->chipid]) }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="select_employee">Employee</label>
                                <select name="select_employee" id="select_employee" class="form-control">
                                    <option value="">Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->rfid }}">
                                            {{ $employee->name ?? 'N/A' }}-{{ $employee->rfid }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </section>

@endsection

@push('script')

@endpush


@extends('company.layout.master')
@section('title', 'Add Rfid Users')

@push('css')
@endpush

@section('body')
<section class="content">
    <br>
    <div class="row">

        <div class="col-sm-12">
            <div class="card ">
                <div class="card-header bg-card-header">
                    <h3 class="card-title">
                       Add Rfid User Of Company: {{$company->title ?? ''}}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ url()->previous() }}" class="btn btn-warning btn-sm ">Back</a>
                    </div>
                </div>
                <div class="card-body  pb-0">
                    <div class="row">
                        <div class="col-sm-12 col-md-10   offset-md-1 col-lg-8 offset-lg-2">
                            <div class="card card-widget">

                                <div class="card-body" >
                                    <form method="post" action="{{route('company.rfid.store',$company)}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="rfid">RFID No <span class="text-danger">*</span></label>
                                            <input type="number" name="rfid" class="form-control"
                                                   placeholder="Enter RFID No"
                                                   value="{{ old('rfid') }}" id="rfid" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile">Employee ID No</label>
                                            <input type="text" name="employee_id" class="form-control"
                                                   placeholder="Enter Employee ID No "
                                                   value="{{ old('employee_id') }}" id="employee_id">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Employee Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   placeholder="Enter Employee Name "
                                                   value="{{ old('name') }}" id="name">
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" name="mobile_no" class="form-control"
                                                   placeholder="Enter company mobile"
                                                   value="{{ old('mobile_no') }}" id="mobile">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                   placeholder="Enter company email"
                                                   value="{{ old('email')}}" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="blood_group">Blood Group</label>
                                            <select name="blood_group" class="form-control">
                                                <option value="">Select</option>
                                                <option value="A+">A+</option>
                                                <option value="A-">A-</option>
                                                <option value="B+">B+</option>
                                                <option value="B-">B-</option>
                                                <option value="O+">O+</option>
                                                <option value="O-">O-</option>
                                                <option value="AB+">AB+</option>
                                                <option value="AB-">AB-</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nid">NID No</label>
                                            <input type="text" name="nid" class="form-control"
                                                   placeholder="Enter NID No"
                                                   value="{{ old('nid') }}" id="nid">
                                        </div>
                                        <div class="form-group">
                                            <label for="doe">Date Of Expired</label>
                                            <input type="date" name="doe" class="form-control"
                                                   placeholder="Enter doe No"
                                                   value="{{ date('Y-m-d') }}" id="doe">
                                        </div>
                                        <div class="form-group">
                                            <label for="blood_group">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="0"{{old('status') == 0 ? 'Selected':''}}>InActive</option>
                                                <option value="1"{{old('status') == 1 ? 'Selected':''}}>Active</option>

                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-sarbs-one">Save</button>
                                    </form>


                                </div>
                            </div>



                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>
    </div>



</section>
@endsection

@extends('admin.layout.master')
@push('title')
    Admin | Active Devices
@endpush
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px) !important;
        }
    </style>
@endpush
@section('body')
    <section class="pt-3">
        <div class="row">
            <div class="col-12  m-auto">
                <div class="card card-info">
                    <div class="card-header bg-card-header">
                        <div class="d-flex justify-content-between align-items-center">

                            <h5 class="">Add Active Device </h5>
                            <a href="{{route('admin.tower.active_device.index',$tower)}}" class="btn btn-sm btn-warning">Back</a>
                        </div>
                    </div>
                    <form action="{{route('admin.tower.active_device.update',[$active_device,$tower])}}" method="post">
                        @csrf
                        @method('PATCH')
                            <?php
                        $active_devices = explode(',',$active_device->active_column);
                            ?>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label for="device_name">Device Name</label>
                                    <select name="device_name" id="device_name" class="select2 form-control">
                                        <option value="">Select Device</option>
                                        @foreach($devices as $device)
                                            <option {{$device->id == $active_device->device_id ? 'selected' : '' }} value="{{$device->id}}">{{$device->device_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-3">
                                    <label for="voltage_phase_a"><input {{ in_array('voltage_phase_a',$active_devices) ? 'checked' : '' }} value="voltage_phase_a" name="active_column[]" type="checkbox"
                                                                        id="voltage_phase_a"> Voltage
                                        Phase A </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="voltage_phase_b"><input {{ in_array('voltage_phase_b',$active_devices) ? 'checked' : '' }} value="voltage_phase_b" name="active_column[]" type="checkbox"
                                                                        id="voltage_phase_b"> Voltage
                                        Phase B </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="voltage_phase_c"><input {{ in_array('voltage_phase_c',$active_devices) ? 'checked' : '' }} value="voltage_phase_c" name="active_column[]" type="checkbox"
                                                                        id="voltage_phase_c"> Voltage
                                        Phase C </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="current_phase_a"><input {{ in_array('current_phase_a',$active_devices) ? 'checked' : '' }} value="current_phase_a" name="active_column[]" type="checkbox"
                                                                        id="current_phase_a"> Current
                                        Phase A </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="current_phase_b"><input {{ in_array('current_phase_b',$active_devices) ? 'checked' : '' }} value="current_phase_b" name="active_column[]" type="checkbox"
                                                                        id="current_phase_b"> Current
                                        Phase B </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="current_phase_c"><input {{ in_array('current_phase_c',$active_devices) ? 'checked' : '' }} value="current_phase_c" name="active_column[]" type="checkbox"
                                                                        id="current_phase_c"> Current
                                        Phase C </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="frequency"><input {{ in_array('frequency',$active_devices) ? 'checked' : '' }} value="frequency" name="active_column[]" type="checkbox" id="frequency"> Frequency
                                    </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="power_factor"><input {{ in_array('power_factor',$active_devices) ? 'checked' : '' }} value="power_factor" name="active_column[]" type="checkbox" id="power_factor">
                                        Power Factor
                                    </label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="cumilative_energy"><input {{ in_array('cumilative_energy',$active_devices) ? 'checked' : '' }} value="cumilative_energy" name="active_column[]" type="checkbox"
                                                                          id="cumilative_energy"> Cumilative
                                        Energy</label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="power"><input {{ in_array('power',$active_devices) ? 'checked' : '' }} value="power" name="active_column[]" type="checkbox" id="power"> Power</label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="dc_voltage"><input {{ in_array('dc_voltage',$active_devices) ? 'checked' : '' }} value="dc_voltage" name="active_column[]" type="checkbox" id="dc_voltage"> Dc
                                        Voltage</label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="tanent_load"><input {{ in_array('tanent_load',$active_devices) ? 'checked' : '' }} value="tanent_load" name="active_column[]" type="checkbox" id="tanent_load"> Tanent
                                        Load</label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="cumilative_dc_energy"><input {{ in_array('cumilative_dc_energy',$active_devices) ? 'checked' : '' }} value="cumilative_dc_energy" name="active_column[]" type="checkbox"
                                                                             id="cumilative_dc_energy"> Cumilative
                                        DC Energy</label>
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <label for="power_dc"><input {{ in_array('checkbox',$active_devices) ? 'checked' : '' }} type="checkbox" id="power_dc" name="active_column[]" value="power_dc"> Power DC</label>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-sarbs-one form-control" value="Update Active Device">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        // $('.select2').select2({
        //     placeholder: 'select Device'
        // });
    </script>
@endpush

@extends('layouts.app')
@section('title')
    {{ __('messages.appointment.edit_appointment') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ url()->previous() }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                    <div class="alert alert-danger d-none hide" id="editAppointmentErrorsBox"></div>
                </div>
            </div>
            <div class="card">
                {{ Form::hidden('doctorDepartmentUrl', url('doctors-list'), ['class' => 'doctorDepartmentUrl']) }}
                {{ Form::hidden('doctorScheduleList', url('doctor-schedule-list'), ['class' => 'doctorScheduleList']) }}
                {{ Form::hidden('getBookingSlot', route('get.booking.slot'), ['class' => 'getBookingSlot']) }}
                {{ Form::hidden('isEdit', true, ['class' => 'isEdit']) }}
                {{ Form::hidden('isCreate', false, ['class' => 'isCreate']) }}
                {{ Form::hidden('appointmentIndexPage', route('appointments.edit', $appointment), ['class' => 'appointmentIndexPage']) }}
                {{ Form::hidden('appointmentEditId', $appointment->id, ['id' => 'appointmentEditsID']) }}
                {{ Form::hidden('appointmentUpdateUrl', route('appointments.update', ['appointment' => $appointment->id]), ['id' => 'appointmentUpdateUrl']) }}
                <div class="card-body">
                    {{ Form::model($appointment, ['route' => ['appointments.update', $appointment->id], 'method' => 'patch','files' => true, 'id' => 'editAppointmentForm', 'class' => 'editAppointmentForm']) }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('first_name', __('messages.user.first_name').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{-- {{ Form::text('first_name', null, ['class' => 'form-control', 'required', 'id' => 'patientFirstName','tabindex' => '1']) }} --}}
                                <input type="text" value="{{ $appointment->patient->user->first_name }}" name="first_name" class="form-control" required id="patientFirstName" tabindex="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('middle_name', __('messages.user.middle_name').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{-- {{ Form::text('middle_name', null, ['class' => 'form-control', 'required', 'id' => 'middleName','tabindex' => '1']) }} --}}
                                <input type="text" value="{{ $appointment->patient->user->middle_name }}" name="middle_name" class="form-control" required id="middleName" tabindex="1">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('last_name', __('messages.user.last_name').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{-- {{ Form::text('last_name', null, ['class' => 'form-control', 'required', 'tabindex' => '2']) }} --}}
                                <input type="text" value="{{ $appointment->patient->user->last_name }}" name="last_name" class="form-control" required id="lastName" tabindex="2">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('dob', __('Age').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{-- {{ Form::number('dob', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'patientBirthDate', 'autocomplete' => 'off', 'tabindex' => '4']) }} --}}
                                <input type="number" class="form-control" autocomplete="off" tabindex="4" value="{{ $appointment->patient->user->age }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('national_number', __('messages.user.national_number').':', ['class' => 'form-label']) }}
                                {{-- {{ Form::number('national_number', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'nationalNumber', 'autocomplete' => 'off', 'tabindex' => '4']) }} --}}
                                <input type="number" value="{{ $appointment->patient->user->national_number }}" name="national_number" class="form-control" required id="nationalNumber" tabindex="4" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mobile-overlapping  mb-5">
                                {{ Form::label('phone', __('messages.user.phone').':', ['class' => 'form-label']) }}
                                <span class="required"></span><br>
                                {{-- {{ Form::tel('phone', getCount ryCode(), ['class' => 'form-control phoneNumber', 'title' => 'Palestine (فلسطين): +970', 'value' => '+970', 'id' => 'patientPhoneNumber', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'tabindex' => '5']) }} --}}
                                <input type="tel" name="phone" class="form-control phoneNumber" title="Palestine (فلسطين): +970" value="+970{{ $appointment->patient->user->phone }}" id="patientPhoneNumber" required onkeyup='if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")' tabindex="5">
                                {{ Form::hidden('prefix_code',null,['class'=>'prefix_code']) }}
                                <span class="text-success valid-msg d-none fw-400 fs-small mt-2">✓ &nbsp; {{__('messages.valid')}}</span>
                                <span class="text-danger error-msg d-none fw-400 fs-small mt-2"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('gender', __('messages.user.gender').':', ['class' => 'form-label']) }}
                                <span
                                    class="required"></span> &nbsp;<br>
                                <span class="is-valid">
                                    <label class="form-label">{{ __('messages.user.male') }}</label>&nbsp;&nbsp;
                                    {{ Form::radio('gender', '0', true, ['class' => 'form-check-input', 'tabindex' => '6','id'=>'patientMale']) }} &nbsp;
                                    <label class="form-label">{{ __('messages.user.female') }}</label>
                                    {{ Form::radio('gender', '1', false, ['class' => 'form-check-input', 'tabindex' => '7','id'=>'patientFemale']) }}
                                </span>
                            </div>
                        </div>
                        <!-- Department Name Field -->
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('department_name', __('messages.appointment.doctor_department').':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::select('department_id',$departments, null, ['class' => 'form-select','required','id' => 'appointmentDepartmentId','placeholder'=>'Select Department', 'data-control' => 'select2']) }}
                        </div>
                        <!-- Doctor Name Field -->
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('doctor_name', __('messages.case.doctor').':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::select('doctor_id',(isset($doctors) ? $doctors : []), null, ['class' => 'form-select','required','id' => 'appointmentDoctorId','placeholder'=>'Select Doctor', 'data-control' => 'select2']) }}
                        </div>
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('opd_date', isset($appointment) ? $appointment->opd_date->format('Y-m-d') : null, ['id'=>'appointmentOpdDate', 'class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
                        </div>
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('services', 'Services/Insurances'.':', ['class' => 'form-label']) }}
                            <span class="required"></span>
                            <select name="services_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @if($appointment->service != null) @if ($appointment->service->id == $service->id) selected @endif @endif>{{ $service->name }}</option>
                                @endforeach
                            </select>
                            {{-- {{ Form::select('doctor_id',(isset($doctors) ? $doctors : []), null, ['class' => 'form-select','required','id' => '','placeholder'=>'Select Services', 'data-control' => 'select2']) }} --}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-5">
                                {{ Form::label('fees', __('messages.bill.price').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{ Form::number('fees', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => '', 'autocomplete' => 'off', 'tabindex' => '4']) }}
                            </div>
                        </div>
                        <!-- Notes Field -->
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
                            {{ Form::textarea('problem', null, ['class' => 'form-control', 'rows'=>'4']) }}
                        </div>
                        <div class="form-group col-sm-6 mb-5">
                            <div class="doctor-schedule" style="display: none">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="day-name"></span>
                                <span class="schedule-time"></span>
                            </div>
                            <strong class="error-message" style="display: none"></strong>
                            <div class="slot-heading">
                                <h3 class="available-slot-heading"
                                        style="display: none">{{ __('messages.appointment.available_slot').':' }}</h3>
                            </div>
                            <div class="row">
                                <div class="available-slot form-group col-sm-12">
                                </div>
                            </div>
                            <div align="right" style="display: none">
                                <span><i class="fa fa-circle color-information" aria-hidden="true"> </i> {{ __('messages.appointment.no_available') }}</span>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 mb-5">
                            <div class="row">
                                @foreach ($appointment->documents as $item)
                                    <div class="col-4">
                                        <img src="{{ asset(str_replace("http://localhost", "", $item->document_url)) }}" alt="" style="width:300px; hieight: 300px;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- @include('appointments.fields') --}}
                    <input type="number" name="patient_id" value="{{ $appointment->patient->id }}" hidden>
                    <div class="row">
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12 d-flex justify-content-end">
                            {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id'=>'saveAppointment']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @include('appointments.templates.appointment_slot')
    </div>
@endsection
{{-- Js :: assets/js/appointments/create-edit.js --}}

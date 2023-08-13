@extends('layouts.app')
@section('title')
    {{ __('messages.appointment.new_appointment') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('appointments.index') }}"
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
                    <div class="alert alert-danger d-none hide" id="createAppointmentErrorsBox"></div>
                </div>
            </div>
            <div class="card">
                {{-- {{ Form::hidden('doctorDepartmentUrl', url('doctors-list'), ['class' => 'doctorDepartmentUrl']) }} --}}
                {{-- {{ Form::hidden('doctorScheduleList', url('doctor-schedule-list'), ['class' => 'doctorScheduleList']) }} --}}
                {{ Form::hidden('appointmentSaveUrl', route('appointments.store.new'), ['id' => 'saveAppointmentURLID']) }}
                {{ Form::hidden('appointmentIndexPage', route('appointments.print'), ['class' => 'appointmentIndexPage']) }}
                {{-- {{ Form::hidden('isEdit', false, ['class' => 'isEdit']) }}
                {{ Form::hidden('isCreate', true, ['class' => 'isCreate']) }} --}}
                {{-- {{ Form::hidden('getBookingSlot', route('get.booking.slot'), ['class' => 'getBookingSlot']) }} --}}
                <div class="card-body p-12">
                    {{-- {{ Form::open(['id' => 'appointmentForm']) }} --}}
                    <form action="{{ route('appointments.store.new') }}" method="POST" onsubmit="disableButton()">
                        @csrf
                        @method('post')
                        {{-- @include('appointments.fields') --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('first_name', __('messages.user.first_name').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('first_name', null, ['class' => 'form-control', 'required', 'id' => 'patientFirstName','tabindex' => '1']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('middle_name', __('messages.user.middle_name').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('middle_name', null, ['class' => 'form-control', 'required', 'id' => 'middleName','tabindex' => '1']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('last_name', __('messages.user.last_name').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('last_name', null, ['class' => 'form-control', 'required', 'tabindex' => '2']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('dob', __('Age').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::number('dob', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'patientBirthDate', 'autocomplete' => 'off', 'tabindex' => '4']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('national_number', __('messages.user.national_number').':', ['class' => 'form-label']) }}
                                    {{ Form::number('national_number', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'nationalNumber', 'autocomplete' => 'off', 'tabindex' => '4']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mobile-overlapping  mb-5">
                                    {{ Form::label('phone', __('messages.user.phone').':', ['class' => 'form-label']) }}
                                    <span class="required"></span><br>
                                    {{ Form::tel('phone', getCountryCode(), ['class' => 'form-control phoneNumber', 'title' => 'Palestine (فلسطين): +970', 'value' => '+970', 'id' => 'patientPhoneNumber', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'tabindex' => '5']) }}
                                    {{ Form::hidden('prefix_code',null,['class'=>'prefix_code']) }}
                                    <span class="text-success valid-msg d-none fw-400 fs-small mt-2">✓ &nbsp; {{__('messages.valid')}}</span>
                                    <span class="text-danger error-msg d-none fw-400 fs-small mt-2"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
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

                            <!-- Doctor Name Field -->
                            <div class="form-group col-sm-4 mb-5">
                                <label for="" class="form-label">{{ __('messages.case.doctor') }}:</label>
                                <span class="required"></span>
                                <select name="doctor_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true" required>
                                    <option value=""></option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->middle_name }} {{ $doctor->user->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-4 mb-5">
                                {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                {{ Form::date('opd_date', isset($appointment) ? $appointment->opd_date->format('Y-m-d') : Carbon\Carbon::now(), ['class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
                            </div>

                            <div class="form-group col-sm-4 mb-5">
                                {{ Form::label('services', 'Services/Insurances'.':', ['class' => 'form-label']) }}
                                <span class="required"></span>
                                <select name="services_id[]" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true" multiple>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                {{-- {{ Form::select('doctor_id',(isset($doctors) ? $doctors : []), null, ['class' => 'form-select','required','id' => '','placeholder'=>'Select Services', 'data-control' => 'select2']) }} --}}
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-5">
                                    {{ Form::label('fees', __('messages.bill.price').':', ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::number('fees', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => '', 'autocomplete' => 'off', 'tabindex' => '4']) }}
                                </div>
                            </div>
                            <!-- Notes Field -->
                            {{-- <div class="form-group col-sm-4 mb-5">
                                {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
                                {{ Form::textarea('problem', null, ['class' => 'form-control', 'rows'=>'4']) }}
                            </div> --}}

                            <div class="form-group col-sm-6">
                                <input class="btn btn-primary" id="submit_btn" type="submit" value="{{ __('messages.common.save') }}">
                            </div>
                        </div>
                    </form>

                    {{-- {{ Form::close() }} --}}
                </div>
            </div>
        </div>
        {{-- @include('appointments.templates.appointment_slot') --}}
    </div>
@endsection
@section('scripts')
    {{--  backend/js/moment-round/moment-round.js --}}
    {{--  assets/js/appointments/create-edit.js  --}}

    <script>
        function disableButton() {
        document.getElementById("submit_btn").disabled = true;
      }
    </script>
@endsection

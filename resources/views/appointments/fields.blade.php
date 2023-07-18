<div class="row">
    <!-- Patient Name Field -->
    @if(Request::path() == 'appointments/create')
        @if(Auth::user()->hasRole('Patient'))
            <input type="hidden" name="patient_id" value="{{ Auth::user()->owner_id }}">
        @else
            <div class="form-group col-sm-6 mb-5">
                {{ Form::label('patient_name', __('messages.case.patient').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::select('patient_id', $patients, null, ['class' => 'form-select','required','id' => 'appointmentPatientId','placeholder'=>'Select Patient', 'data-control' => 'select2']) }}
            </div>
        @endif
    @endif
    @if(Auth::user()->hasRole('Receptionist') && Request::path() != 'appointments/create')
        <div class="col-md-6">
            <div class="form-group mb-5">
                {{ Form::label('first_name', __('messages.user.first_name').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('first_name', null, ['class' => 'form-control', 'required', 'id' => 'patientFirstName','tabindex' => '1']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-5">
                {{ Form::label('middle_name', __('messages.user.middle_name').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('middle_name', null, ['class' => 'form-control', 'required', 'id' => 'middleName','tabindex' => '1']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-5">
                {{ Form::label('last_name', __('messages.user.last_name').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('last_name', null, ['class' => 'form-control', 'required', 'tabindex' => '2']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-5">
                {{ Form::label('dob', __('Age').':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::number('dob', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'patientBirthDate', 'autocomplete' => 'off', 'tabindex' => '4']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-5">
                {{ Form::label('national_number', __('messages.user.national_number').':', ['class' => 'form-label']) }}
                {{ Form::number('national_number', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'nationalNumber', 'autocomplete' => 'off', 'tabindex' => '4']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mobile-overlapping  mb-5">
                {{ Form::label('phone', __('messages.user.phone').':', ['class' => 'form-label']) }}
                <span class="required"></span><br>
                {{ Form::tel('phone', getCountryCode(), ['class' => 'form-control phoneNumber', 'title' => 'Palestine (فلسطين): +970', 'value' => '+970', 'id' => 'patientPhoneNumber', 'required', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'tabindex' => '5']) }}
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
    @endif
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

 
    @if(!Auth::user()->hasRole('Patient'))
    <!-- Date Field -->
        <div class="form-group col-sm-6 mb-5">
            {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('opd_date', isset($appointment) ? $appointment->opd_date->format('Y-m-d') : null, ['id'=>'appointmentOpdDate', 'class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
        </div>
        @if(Auth::user()->hasRole('Receptionist'))
            {{-- <div class="col-md-12">
                <div class="form-group mb-5">
                    {{ Form::label('gender', 'Services/Insurances'.':', ['class' => 'form-label']) }}
                    <span class="required"></span> &nbsp;<br>
                    <span class="is-valid">
                        <label class="form-label">Services</label>&nbsp;&nbsp;
                        <input type="radio" name="servicesRadio" class='form-check-input' tabindex='6'>
                        <label class="form-label">Insurances</label>
                        <input type="radio" name="servicesRadio" class='form-check-input' tabindex='6'>
                    </span>
                </div>
            </div> --}}
            <div class="form-group col-sm-6 mb-5">
                {{ Form::label('services', 'Services/Insurances'.':', ['class' => 'form-label']) }}
                <span class="required"></span>
                <select name="services_id[]" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true" multiple>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
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
        @endif

        @if (Auth::user()->hasRole('Admin'))
            <div class="form-group col-sm-6 mb-5">
                {{ Form::label('services', 'Services/Insurances'.':', ['class' => 'form-label']) }}
                <span class="required"></span>
                <select name="services_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true">
                    @foreach ($services as $service)
                        @if (request()->routeIs('appointments.edit'))
                            <option value="{{ $service->id }}" @if ($appointment->service->id == $service->id) selected @endif>{{ $service->name }}</option>
                        @else
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endif
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
        @endif
    
        <!-- Notes Field -->
        <div class="form-group col-sm-6 mb-5">
            {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
            {{ Form::textarea('problem', null, ['class' => 'form-control', 'rows'=>'4']) }}
        </div>

        @if (request()->routeIs('appointments.edit'))
            <div class="form-group col-sm-6 mb-5">
                {{ Form::label('file', __('messages.document.attachment').(':'), ['class' => 'form-label required']) }}
                <br>
                <div class="d-block">
                    <?php
                    $style = 'style=';
                    $background = 'background-image:';
                    ?>

                    <div class="image-picker">
                        <div class="image previewImage" id="documentPreviewImage"
                        {{$style}}"{{$background}} url({{ asset('assets/img/default_image.jpg')}}">
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{ __('messages.document.attachment') }}">
                                <label>
                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                    {{ Form::file('file',['id'=>'','class' => 'd-none image-upload']) }}
                                    <input type="hidden" name="avatar_remove"/>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            
        @endif
       

        @if(!Auth::user()->hasRole('Receptionist'))
            <div class="form-group col-sm-6 mb-5">
                {{ Form::label('status', __('messages.common.status').':', ['class' => 'form-label']) }}
                <br>
                <div class="form-check form-switch">
                    <input class="form-check-input w-35px h-20px" name="status" type="checkbox"
                        value="1" checked>
                </div>
            </div>
        @endif
        
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
    @endif

    @if(Auth::user()->hasRole('Patient'))
    <!-- Date Field -->
        <div class="form-group col-sm-6 mb-5">
            {{ Form::label('opd_date', __('messages.appointment.date').':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{ Form::text('opd_date', null, ['id'=>'patientAppointmentOpdDate', 'class' => (getLoggedInUser()->thememode ? 'bg-light opdDate form-control' : 'bg-white opdDate form-control'), 'required', 'autocomplete'=>'off']) }}
        </div>

        <!-- Notes Field -->
        <div class="form-group col-sm-6 mb-5">
            {{ Form::label('problem', __('messages.appointment.description').':', ['class' => 'form-label']) }}
            {{ Form::textarea('problem', null, ['class' => 'form-control', 'rows'=>'4']) }}
        </div>
        <div class="form-group col-sm-6 available-slot-div">
            <div class="doctor-schedule" style="display: none">
                <i class="fas fa-calendar-alt"></i>
                <span class="day-name"></span>
                <span class="schedule-time"></span>
            </div>
            <strong class="error-message" style="display: none"></strong>
            <div class="slot-heading">
                <strong class="available-slot-heading"
                        style="display: none">{{ __('messages.appointment.available_slot').':' }}</strong>
            </div>
            <div class="row">
                <div class="available-slot form-group col-sm-10">
                </div>
            </div>
            <div class="color-information" align="right" style="display: none">
                <span><i class="fa fa-circle fa-xs" aria-hidden="true"> </i> {{ __('messages.appointment.no_available') }}</span>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12 d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id'=>'saveAppointment']) }}
        @if(!Auth::user()->hasRole('Receptionist'))
            <a href="{{ route('appointments.index') }}"
            class="btn btn-secondary">{{ __('messages.common.cancel') }}</a>
        @endif
    </div>
</div>

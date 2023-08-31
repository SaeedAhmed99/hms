@extends('layouts.app')
@section('title')
    {{ __('messages.appointments') }}
@endsection
@section('content')
    @include('flash::message')
    <div class="container-fluid">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        {{ Form::hidden('appointmentUrl', url('appointments'), ['class' => 'appointmentURL']) }}
        {{ Form::hidden('patientUrl', url('patients'), ['class' => 'patientAppointmentURL']) }}
        {{ Form::hidden('doctorUrl', url('doctors'), ['class' => 'doctorAppointmentURL']) }}
        {{ Form::hidden('doctorShowUrl', url('employee/doctor'), ['class' => 'doctorShowURL']) }}
        {{ Form::hidden('patientRole', Auth::user()->hasRole('Patient')?true:false, ['class' => 'patientRole']) }}
        {{ Form::hidden('doctorRole', Auth::user()->hasRole('Doctor')?false:true, ['class' => 'doctorRole']) }}
        {{ Form::hidden('loginDoctor', Auth::user()->hasRole('Doctor')?true:false, ['class' => 'loginDoctor']) }}
        {{ Form::hidden('adminRole', Auth::user()->hasRole('Admin')?true:false, ['class' => 'adminRole']) }}
        {{ Form::hidden('doctorDepartmentUrl', url('doctor-departments'), ['class' => 'doctorDepartmentURL']) }}
        {{ Form::hidden('appointment', __('messages.web_menu.appointment'), ['id' => 'Appointment']) }}
        {{ Form::hidden('todayAppointment', __('messages.appointment.today'), ['id' => 'todayAppointment']) }}
        {{ Form::hidden('yesterdayAppointment', __('messages.appointment.yesterday'), ['id' => 'yesterdayAppointment']) }}
        {{ Form::hidden('thisWeekAppointment', __('messages.appointment.this_week'), ['id' => 'thisWeekAppointment']) }}
        {{ Form::hidden('last7DayAppointment', __('messages.appointment.last_7_days'), ['id' => 'last7DayAppointment']) }}
        {{ Form::hidden('last30DayAppointment', __('messages.appointment.last_30_days'), ['id' => 'last30DayAppointment']) }}
        {{ Form::hidden('thisMonthAppointment', __('messages.appointment.this_month'), ['id' => 'thisMonthAppointment']) }}
        {{ Form::hidden('lastMonthAppointment', __('messages.appointment.last_month'), ['id' => 'lastMonthAppointment']) }}
        <div class="d-flex flex-column">
            <livewire:appointment-table/>
             <!-- Modal -->
            <div id="addFile" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.addfile') }}</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form id="fileForm" action="{{ route('appointment.add.file') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          @method('post')
                          {{-- {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }} --}}
                          <div class="modal-body">
                              {{-- <div class="alert alert-danger d-none hide" id="expenseErrorsBox"></div> --}}
                                <input type="number" name="appointment_id" id="appointment_id" hidden value="">
                                <input type="number" name="patient_id" id="patient_id" hidden value="">
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
                            <!-- Notes Field -->
                            <div class="form-group col-sm-12 mb-5">
                                {{ Form::label('notes', __('messages.appointment.description').':', ['class' => 'form-label']) }}
                                {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows'=>'4']) }}
                            </div>
                                  
                              </div>
                          <div class="modal-footer pt-0">
                              {{-- {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0']) }} --}}
                              {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                              <button type="button" class="btn btn-primary" id="submit_file_btn">Save</button>
                              <button type="button" class="btn btn-secondary"
                                      data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                          </div>
                        {{-- {{ Form::close() }} --}}
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @include('appointments.templates.templates')
    </div>
@endsection
@section('scripts')
    
    {{--        asset('assets/js/plugins/daterangepicker.js >--}}
    {{--    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Doctor'))--}}
    {{--        assets/js/appointments/appointments.js --}}
    {{--    @else--}}
    {{--       assets/js/appointments/patient_appointment.js --}}
    {{--    @endif--}}

    <script>
        // $(function(){
        //     $('.iconAddFile').click(function(){
        //         console.log('s');
        //         var appointment_id = $(this).attr('data-appointment_id');
        //         var patient_id = $(this).attr('data-patient_id');
        //         // $(this).prev('input').val("hello world");
        //         // console.log(appointment_id);
        //         // console.log(patient_id);
        //         $("#appointment_id").val(appointment_id);
        //         $("#patient_id").val(patient_id);
        //     });
        // });

        $(document).on('click', '.iconAddFile', function () {
              var appointment_id = $(this).attr('data-appointment_id');
              var patient_id = $(this).attr('data-patient_id');
              $("#appointment_id").val(appointment_id);
              $("#patient_id").val(patient_id);
      });
    </script>

    <script>
        $(document).on('click', '#submit_file_btn', function () {
            console.log('s');
            $('#fileForm').submit();
        });
    </script>
@endsection


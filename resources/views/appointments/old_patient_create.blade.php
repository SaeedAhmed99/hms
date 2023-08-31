@extends('layouts.app')
@section('title')
    {{__('messages.appointment.appointments_today')}}
@endsection
@section('css')
{{--    <link rel="stylesheet" href="{{ asset('assets/css/sub-header.css') }}">--}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div wire:id="WpskoqwzxJ5BdNxsPOsu" id="datatable-WpskoqwzxJ5BdNxsPOsu">


                <div wire:offline.class.remove="d-none" class="d-none">
                  <div class="alert alert-danger d-flex align-items-center" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:1.3em;height:1.3em;" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
              
                    <span class="d-inline-block ml-2">You are not connected to the internet.</span>
                  </div>
                </div>

                <div class="container-fluid">
                    <div class="d-flex flex-column">
                      <div>
                      </div>
                      <div class="d-md-flex justify-content-between mb-3 livewire-search-box align-items-center">
                        <div class="d-md-flex">
                          <div class="mb-3 mb-sm-0">
                            <div class="position-relative d-flex width-500">
                                <h1>{{ __('messages.appointment.new_appointment') }}</h1>
                            </div>
                          </div>
                        </div>
                  
                        <div class="d-flex justify-content-end ">
                          <div class="dropdown">
                            <a href="#" class="btn btn-primary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                              Actions
                              <svg class="svg-inline--fa fa-chevron-down" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                data-fa-i2svg="">
                                <path fill="currentColor"
                                  d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z">
                                </path>
                              </svg><!-- <i class="fas fa-chevron-down"></i> Font Awesome fontawesome.com -->
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li>
                                @if (Auth::user()->hasRole('Admin'))
                                    <a href="{{ route('appointments.create') }}" class="dropdown-item  px-5">{{ __('messages.new_appointments') }}</a>
                                @elseif (Auth::user()->hasRole('Receptionist'))
                                    <a href="{{ route('appointments.create.new') }}" class="dropdown-item  px-5">{{ __('messages.new_appointments') }}</a>
                                @endif
                              </li>
                              <li>
                                <a href="{{ route('appointments.today') }}" class="dropdown-item  px-5" target="_blank">{{ __('messages.appointment.appointments_today_print') }}</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                
                
                <div id="alert_withdrawl" class="mb-3"></div>
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
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('appointments.old.patient.search.store') }}" method="POST">
                            @csrf
                            @method('post')
                            <input type="number" name="patient_id" value="{{ $patient->id }}" hidden>
                            <div class="p-5">
                            <div class="row">
                                <div class="mb-5 col-6">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.case.doctor') }}:</label>
                                    <select name="doctor_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true" required>
                                        <option value=""></option>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->user->first_name ?? '' }} {{ $doctor->user->middle_name ?? '' }} {{ $doctor->user->last_name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-5 col-6">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.package.service') }}:</label>
                                    <select name="service_id[]" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true" required multiple>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="exampleInputSelect2" class="form-label">{{ __('messages.case.fee') }}:</label>
                                <input type="number" name="fees" class="form-control" required>
                            </div>
                            <div class="mb-5">
                                <label for="exampleInputSelect2" class="form-label">{{ __('messages.visitor.note') }}:</label>
                                <textarea class="form-control" name="problem" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-secondary">{{ __('messages.appointment.new_appointment') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-striped">
                    <thead class="">
                        <tr>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>#</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.case.patient') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.case.doctor') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.package.service') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.case.fee') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.case.date') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.live_consultation.created_by')}}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                            <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                <span>{{ __('messages.common.actions') }}</span>
                                <span class="relative">
                                </span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                
                    <tbody class="">
                        @foreach ($patient->appointments as $item)
                            <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-3">
                                        <span class="badge bg-light-info text-decoration-none">{{ $loop->iteration  }}</span>
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{route('patients.show',$patient->id)}}"
                                                class="mb-1 text-decoration-none">{{$patient->user->first_name ?? ''}} {{$patient->user->middle_name ?? ''}} {{$patient->user->last_name ?? ''}}</a>
                                        </div>
                                    </div>                                    
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{$item->doctor->user->first_name ?? ''}} {{ $item->doctor->user->middle_name ?? '' }} {{ $item->doctor->user->last_name ?? '' }}
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{ $item->service->name ?? '' }}
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{ $item->fees }}
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="badge bg-light-info">
                                        {{-- <div class="mb-2">{{ \Carbon\Carbon::parse($item->opd_date)->isoFormat('LT')}}</div> --}}
                                        {{-- <div>{{ \Carbon\Carbon::parse($item->opd_date)->translatedFormat('jS M, Y')}}</div> --}}
                                        <div>{{date('d-m-Y', strtotime($item->opd_date))}}</div>
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{$item->userEntered->first_name ?? ''}} {{$item->userEntered->middle_name ?? ''}} {{$item->userEntered->last_name ?? ''}}
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    @if (count($item->documents) == 0)
                                        <a data-appointment_id="{{ $item->id }}" data-patient_id="{{ $item->patient->id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                            <i class="fa-regular fa-file"></i>
                                        </a>
                                    @else
                                        <a data-appointment_id="{{ $item->id }}" data-patient_id="{{ $item->patient->id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                            <i class="fa-solid fa-file"></i>
                                        </a>
                                    @endif
                                </td>
                    
                            </tr>
                        @endforeach
                    </tbody>
                
                    </table>

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
                                      <button type="button" class="btn btn-primary" id="submit_file_btn">{{ __('messages.common.save') }}</button>
                                      <button type="button" class="btn btn-secondary"
                                              data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                                  </div>
                                {{-- {{ Form::close() }} --}}
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                    

              </div>
        </div>
@endsection
@section('scripts')
    {{--    assets/js/incomes/incomes.js --}}
    {{--    assets/js/custom/new-edit-modal-form.js --}}
    <script>
        $(document).on('click', '.iconAddFile', function () {
        console.log('s');
              var appointment_id = $(this).attr('data-appointment_id');
              var patient_id = $(this).attr('data-patient_id');
              // const div1 = document.getElementById("iconAddFile");
              // console.log(div1.getAttribute("data-appointment_id"));
              // $(this).prev('input').val("hello world");
              // console.log(appointment_id);
              // console.log(patient_id);
              $("#appointment_id").val(appointment_id);
              $("#patient_id").val(patient_id);
      });
    </script>

    <script>
        $(function(){
            $('.show-appointment-cancellation').click(function(){
                var reason = $(this).attr('data-reason');
                $("#show_cancel").val(reason);
            });
        });
    </script>w

    <script>
        $(document).on('click', '#submit_file_btn', function () {
            $('#fileForm').submit();
        });
    </script>
@endsection

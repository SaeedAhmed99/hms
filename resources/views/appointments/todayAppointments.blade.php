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
                                <button class="btn btn-primary" style="margin-right: 10px; width: fit-content; cursor: auto;">Total Earning <svg style="font-size: 23px; margin-right: 7px; color: #fff;" class="svg-inline--fa fa-money-bill" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-bill" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M512 64C547.3 64 576 92.65 576 128V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512zM128 384C128 348.7 99.35 320 64 320V384H128zM64 192C99.35 192 128 163.3 128 128H64V192zM512 384V320C476.7 320 448 348.7 448 384H512zM512 128H448C448 163.3 476.7 192 512 192V128zM288 352C341 352 384 309 384 256C384 202.1 341 160 288 160C234.1 160 192 202.1 192 256C192 309 234.1 352 288 352z"></path></svg>
                                    : {{ $appointments->sum('fees') }}</button>
                                {{-- <button class="btn btn-primary" style="margin-right: 10px; width: fit-content; cursor: auto;">{{ __('messages.appointment.total_appointments') }} : {{ count($appointments) }}</button> --}}
                                {{-- <button class="btn btn-primary" style="margin-right: 10px; width: fit-content;">Total Remaining: {{ $total_earning - $total_withdrawn }}</button> --}}
                              </div>
                          </div>
                        </div>
                  
                        <div class="d-flex justify-content-end ">
                          <div class="ms-0 ms-md-2" wire:ignore="">
                            <div class="dropdown d-flex align-items-center me-4 me-md-5">
                              <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
                                data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false" id="incomeFilterBtn">
                                <svg class="svg-inline--fa fa-filter" aria-hidden="true" focusable="false" data-prefix="fas"
                                  data-icon="filter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                  <path fill="currentColor"
                                    d="M3.853 54.87C10.47 40.9 24.54 32 40 32H472C487.5 32 501.5 40.9 508.1 54.87C514.8 68.84 512.7 85.37 502.1 97.33L320 320.9V448C320 460.1 313.2 471.2 302.3 476.6C291.5 482 278.5 480.9 268.8 473.6L204.8 425.6C196.7 419.6 192 410.1 192 400V320.9L9.042 97.33C-.745 85.37-2.765 68.84 3.854 54.87L3.853 54.87z">
                                  </path>
                                </svg><!-- <i class="fas fa-filter"></i> Font Awesome fontawesome.com -->
                              </button>
                              <div class="dropdown-menu py-0" aria-labelledby="incomeFilterBtn">
                                <div class="text-start border-bottom py-4 px-7">
                                  <h3 class="text-gray-900 mb-0">Filter Options</h3>
                                </div>
                                <form action="{{ route('today.appointments') }}" method="GET">
                                    @csrf
                                    @method('get')
                                    <div class="p-5">
                                    <div class="mb-5">
                                        <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.first_name') }}:</label>
                                        <input type="text" name="first_name" class="form-control">
                                    </div>
                                    <div class="mb-5">
                                        <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.middle_name') }}:</label>
                                        <input type="text" name="middle_name" class="form-control">
                                    </div>
                                    <div class="mb-5">
                                        <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.last_name') }}:</label>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                    @if (!Auth::user()->hasRole('Doctor'))
                                        <div class="mb-5">
                                            <label for="exampleInputSelect2" class="form-label">{{ __('messages.case.doctor') }}:</label>
                                            <select name="doctor_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true">
                                                <option value=""></option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->user->first_name }} {{ $doctor->user->middle_name }} {{ $doctor->user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-secondary" id="incomeResetFilter">{{ __('messages.common.search') }}</button>
                                    </div>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
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
                                    <a href="{{ route('appointments.old.patient.search') }}" class="dropdown-item  px-5">{{ __('messages.appointment.new_appointments_for_old_patient') }}</a>
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
                {{ Form::hidden('appointmentUrl', url('appointments'), ['class' => 'appointmentURL']) }}
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="">
                      <tr>
                        <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                            <span>{{ __('messages.case.patient') }}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-1-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('name')" style="cursor:pointer;">
                            <span>{{ __('messages.case.doctor') }}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>{{ __('messages.service.service') }}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>{{ __('messages.case.fee') }}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>{{ __('messages.appointment.date') }}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>{{ __('messages.live_consultation.created_by')}}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="d-flex justify-content-end" style="padding-right: 7rem !important"
                          wire:key="header-col-4-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('amount')" style="cursor:pointer;">
                            <span>{{ __('messages.common.action')}}</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                      </tr>
                    </thead>
              
                    <tbody class="">
                        @foreach ($appointments as $row)
                            <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center">
                                        <div class="image image-mini me-3">
                                            {{$row->counter}} - 
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{route('patients.show',$row->patient->id)}}"
                                               class="mb-1 text-decoration-none">{{$row->patient->user->first_name ?? ''}} {{$row->patient->user->middle_name ?? ''}} {{$row->patient->user->last_name ?? ''}} @if(count($row->patient->appointments) == 1) <small style="color: green">(new)</small> @endif</a>
                                            {{-- <span>{{$row->patient->patientUser->email}}</span> --}}
                                        </div>
                                    </div>                                    
                                </td>
                    
                                <td class="p-5" wire:key="cell-0-1-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex flex-column">
                                        <a href="{{ url('doctors',$row->doctor->id) }}"
                                           class="mb-1 text-decoration-none">{{ $row->doctor->user->first_name ?? ''}} {{ $row->doctor->user->middle_name ?? ''}} {{ $row->doctor->user->last_name ?? ''}}</a>
                                    </div>
                                </td>

                                @php
                                    $servicesIds = $row->service_id;
                                    $gerServices = App\Models\Service::whereIn('id', $servicesIds)->get();
                                @endphp
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{-- {{$row->service->name ?? ''}} --}}
                                        @foreach ($gerServices as $service)
                                            {{ $service->name . ', ' ?? '' }}
                                        @endforeach
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{$row->fees ?? ''}}
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="badge bg-light-info">
                                        <div class="mb-2">{{ \Carbon\Carbon::parse($row->opd_date)->isoFormat('LT')}}</div>
                                        <div>{{ \Carbon\Carbon::parse($row->opd_date)->translatedFormat('jS M, Y')}}</div>
                                    </div>
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="d-flex align-items-center mt-4">
                                        {{$row->userEntered->first_name ?? ''}} {{$row->userEntered->middle_name ?? ''}} {{$row->userEntered->last_name ?? ''}}
                                    </div>
                                </td>

                            <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                  @if($row->is_completed == 3)
                                  <a data-bs-toggle="tooltip" data-placement="top" data-bs-original-title=" {{__('messages.common.canceled')}} " class="btn px-1 text-danger fs-3 pe-0">
                                      <i class="fas fa-calendar-times text-danger"></i>
                                  </a>
                              @else
                                  @if (!Auth::user()->hasRole('Doctor'))
                                      <a data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="{{ __('messages.common.cancel')}}" data-id="{{$row->id}}"
                                          class="cancel-appointment btn px-1 text-danger fs-3 pe-0 {{$row->is_completed == 1 ? "d-none"  : "" }}">
                                          <i class="far fa-calendar-times {{$row->is_completed == 1 ? "text-danger"  : "" }}"></i>
                                      </a>
                                  @endif
                              @endif

                              @if (!getLoggedinPatient())
                                  @if ($row->is_completed == 1 || $row->is_completed == 3)
                                      <a title="Completed"
                                         class="btn px-1 text-primary fs-3 pe-0 {{$row->is_completed == 3 ? "d-none"  : "" }}">
                                          <i class="fas fa-calendar-check text-success {{$row->is_completed == 3 ? "d-none"  : ""}}"></i>
                                      </a>
                                  @endif
                                  @if ($row->is_completed == 0)
                                      <a title="{{ __('messages.common.confirm') }}" data-id="{{$row->id}}" class="appointment-complete-status btn px-1 text-primary fs-3 pe-0">
                                          <i class="far fa-calendar-check"></i>
                                      </a>
                                  @endif
                              @endif
                              
                              @if (!Auth::user()->hasRole('Doctor'))
                                  <a href="{{ route('appointments.edit', $row->id) }}" title="{{__('messages.common.edit') }}"
                                      class="btn px-1 text-primary fs-3 ps-0">
                                      <i class="fa-solid fa-pen-to-square"></i>
                                  </a>  
                              
                              <a href="{{ route('appointments.print.id', $row->id) }}" title="{{ __('messages.common.print') }}"  class="btn px-1 text-primary fs-3 pe-0">
                                  <i class="fa-solid fa-print"></i>
                              </a>
                                  @if (count($row->documents) == 0)
                                      <a data-appointment_id="{{ $row->id }}" data-patient_id="{{ $row->patient->id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                          <i class="fa-regular fa-file"></i>
                                      </a>
                                  @else
                                      <a data-appointment_id="{{ $row->id }}" data-patient_id="{{ $row->patient->id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                          <i class="fa-solid fa-file"></i>
                                      </a>
                                  @endif
                              @endif
                              
                              
                              <?php if($is_role = getLoggedInUser()->hasRole(['Admin', 'Patient'])) { ?>
                              <a title="<?php echo __('messages.common.delete') ?>" data-id="{{$row->id}}"
                                 class="appointment-delete-btn btn px-1 text-danger fs-3 pe-0" wire:key="{{$row->id}}">
                                  <i class="fa-solid fa-trash"></i>
                              </a>
                              <?php }?>
                              
                              {{-- @if (Auth::user()->hasRole('Doctor')) --}}
                                <button data-appointmentId="{{ $row->id }}" data-note="{{ $row->problem }}" type="button" class="btn px-1 @if($row->problem) text-success @else text-primary @endif fs-3 pe-0 appNote" data-bs-toggle="modal" data-bs-target="#appointmentNote" title="note"><i class="fa-solid fa-notes-medical"></i></button>
                              {{-- @endif --}} 
                            </tr>
                        @endforeach

                          <!-- Modal -->
                      <div id="appointmentNote" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.visitor.note') }}</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                {{-- {{ Form::open(['id'=>'addExpenseForm', 'files' => true]) }} --}}
                                <form action="{{ route('appointment.add.note') }}" method="post" id="FormNote">
                                  @csrf
                                  @method('post')
                                  <input id="appointmentId" type="hidden" name="id" value="">
              
                                  {{-- {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }} --}}
                                  <div class="modal-body">
                                      {{-- <div class="alert alert-danger d-none hide" id="expenseErrorsBox"></div> --}}
                                      <div class="row">
                                          
                                      </div>
                                          <div class="form-group col-sm-12 mb-5">
                                            {{ Form::label('description', __('Note').(':'),['class' => 'form-label']) }}
                                            {{-- {{ Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4, 'id' => 'notes']) }} --}}
                                            <textarea name="note" id="notes" rows="4" class="form-control" @if(!Auth::user()->hasRole('Doctor')) readonly @endif></textarea>
                                          </div>
                                      </div>
                                  <div class="modal-footer pt-0">
                                      {{-- {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0']) }} --}}
                                      @if(Auth::user()->hasRole('Doctor'))
                                        <button type="button" class="btn btn-primary" id="submit_btn">Save</button>
                                      @endif
                                      <button type="button" id="cancel_btn" class="btn btn-secondary"
                                              data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                                  </div>
                                {{-- {{ Form::close() }} --}}
                              </form>

                            </div>
                        </div>
                      </div>

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
                    </tbody>
              
                  </table>
                </div>
              </div>
        </div>
@endsection
@section('scripts')
    {{--    assets/js/incomes/incomes.js --}}
    {{--    assets/js/custom/new-edit-modal-form.js --}}

    
    <script>
      $(document).on('click', '.appNote', function () {
          var id = $(this).attr('data-appointmentId');
          var note = $(this).attr('data-note');
  
          $('#appointmentId').attr('value', id)
          $('#notes').val(note)
      });
    </script>

    <script>
      $(document).on('click', '#submit_btn', function () {
        $('#FormNote').submit();
      });
    </script>
    
    <script>
      $(function(){
          $('.iconAddFile').click(function(){
              console.log('s');
              var appointment_id = $(this).attr('data-appointment_id');
              var patient_id = $(this).attr('data-patient_id');
              // $(this).prev('input').val("hello world");
              // console.log(appointment_id);
              // console.log(patient_id);
              $("#appointment_id").val(appointment_id);
              $("#patient_id").val(patient_id);
          });
      });
  </script>

  <script>
      $(document).on('click', '#submit_file_btn', function () {
          console.log('s');
          $('#fileForm').submit();
      });
  </script>
@endsection

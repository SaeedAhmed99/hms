@extends('layouts.app')
@section('title')
    {{__('messages.incomes.incomes')}}
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
                          <form action="">
                            <div class="position-relative d-flex width-370">
                              <select name="doctor_id" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true">
                                <option value="" class="form-control">Select Doctor</option>
                                @foreach ($doctors_search as $doctor)
                                    <option value="{{ $doctor->id }}" @if($doctor->id == $doctor_id) selected @endif>{{ $doctor->user->first_name }} {{ $doctor->user->middle_name }} {{ $doctor->user->last_name }}</option>
                                @endforeach
                              </select>
                              <div></div>
                              <input type="date" name="due" value="{{ $due }}" class="form-control" style="margin-left: 10px;">
                              <input type="submit" value="Search" class="form-control btn btn-primary" style="margin-left: 10px;">
                            </div>
                          </form>
                        </div>
                        <div class="mb-3 mb-sm-0" style="margin-left: 10px;">
                          <div class="position-relative d-flex width-500">
                            <button class="btn btn-primary" style="margin-right: 5px; width: fit-content; padding-left: 5px; padding-right: 5px; cursor: auto;">Total Earning: {{ $total_earning }}</button>
                            <button class="btn btn-primary" style="margin-right: 5px; width: fit-content; padding-left: 5px; padding-right: 5px; cursor: auto;">Total Withdrawn: {{ $total_withdrawn }}</button>
                            <button class="btn btn-primary" style="margin-right: 5px; width: fit-content; padding-left: 5px; padding-right: 5px; cursor: auto;">Total Remaining: {{ $total_earning - $total_withdrawn }}</button>
                          </div>
                        </div>
                        <div class="mb-3 mb-sm-0" style="margin-left: 10px;">
                          <div class="position-relative d-flex width-500">
                            <a href="{{ route('incomes.print.last.day') }}" target="_blank" class="btn btn-primary" style="margin-right: 5px; width: fit-content; padding-left: 5px; padding-right: 5px;">print last day</a>
                          </div>
                        </div>
                      </div>
                
                      {{-- <div class="d-flex justify-content-end ">
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
                              <div class="p-5">
                                <div class="mb-5">
                                  <label for="exampleInputSelect2" class="form-label">Status:</label>
                                  <select id="incomeHead" data-control="select2"
                                    class="form-select status-filter select2-hidden-accessible" name="income_head" tabindex="-1"
                                    aria-hidden="true" data-select2-id="select2-data-incomeHead">
                                    <option value="0" data-select2-id="select2-data-24-qx4k">All</option>
                                    <option value="1">Canteen Rent</option>
                                    <option value="2">Hospital Charges</option>
                                    <option value="3">Special Campaign</option>
                                    <option value="4">Vehicle Stand Charges</option>
                                  </select><span class="select2 select2-container select2-container--bootstrap-5" dir="ltr"
                                    data-select2-id="select2-data-23-zvdv" style="width: 100%;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true"
                                        aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-incomeHead-container"
                                        aria-controls="select2-incomeHead-container"><span class="select2-selection__rendered"
                                          id="select2-incomeHead-container" role="textbox" aria-readonly="true"
                                          title="All">All</span><span class="select2-selection__arrow" role="presentation"><b
                                            role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                      aria-hidden="true"></span></span>
                                </div>
                                <div class="d-flex justify-content-end">
                                  <button type="reset" class="btn btn-secondary" id="incomeResetFilter">Reset</button>
                                </div>
                              </div>
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
                              <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add_incomes_modal"
                                class="dropdown-item  px-5">New Income</a>
                            </li>
                            <li>
                              <a href="http://127.0.0.1:8000/export-incomes" class="dropdown-item  px-5" target="_blank">Export to
                                Excel</a>
                            </li>
                          </ul>
                        </div>
                
                
                      </div> --}}
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
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="">
                      <tr>
                        <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                            <span>ID</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-1-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('name')" style="cursor:pointer;">
                            <span>Doctor Name</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>Total Earning</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-3-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('date')" style="cursor:pointer;">
                            <span>Withdrawn Amount</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="d-flex justify-content-end" style="padding-right: 7rem !important"
                          wire:key="header-col-4-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('amount')" style="cursor:pointer;">
                            <span>Remaining Amount</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-6-WpskoqwzxJ5BdNxsPOsu">
                          Action
                        </th>
                      </tr>
                    </thead>
              
                    <tbody class="">
                        @foreach ($doctors as $doctor)
                            <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                    <span class="badge bg-light-info text-decoration-none">{{ $loop->iteration  }}</span>
                    
                                </div>
                                </td>
                    
                                <td class="p-5" wire:key="cell-0-1-WpskoqwzxJ5BdNxsPOsu">
                                {{ $doctor->user->first_name }} {{ $doctor->user->middle_name }} {{ $doctor->user->last_name }}
                                </td>
                    
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                    {{ $doctor->appointments->where('is_completed', '!=', '3')->sum('fees') }}
                                </div>
                                </td>
                    
                                {{-- <td class="" wire:key="cell-0-3-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                    <div class="badge bg-light-info">
                                    20th June 2023
                                    </div>
                                </div>
                                </td> --}}

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                  @if ($due)
                                    {{ $doctor->financialTransaction->where('due_date', '>=', $due)->where('due_date', '<', $dateby1)->where('is_completed', '!=', '3')->sum('transaction_amount') }}
                                  @else
                                    {{ $doctor->financialTransaction->where('is_completed', '!=', '3')->sum('transaction_amount') ?? 0 }}
                                  @endif
                                </div>
                                </td>
                    
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                  @if ($due)
                                    {{ $doctor->appointments->where('is_completed', '!=', '3')->sum('fees')  - $doctor->financialTransaction->where('due_date', '>=', $due)->where('due_date', '<', $dateby1)->where('is_completed', '!=', '3')->sum('transaction_amount') }}
                                  @else
                                    {{ $doctor->appointments->where('is_completed', '!=', '3')->sum('fees')  - $doctor->financialTransaction->where('is_completed', '!=', '3')->sum('transaction_amount') ?? 0 }}
                                  @endif
                                </div>
                                </td>
                    
                                <td class="" wire:key="cell-0-6-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center">
                                    {{-- <a title="Delete" href="javascript:void(0)" data-id="1" wire:key="1"
                                      class="btn px-1 text-danger fs-3 pe-0 deleteIncomesBtn">
                                      <svg class="svg-inline--fa fa-trash" aria-hidden="true" focusable="false" data-prefix="fas"
                                          data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                          data-fa-i2svg="">
                                          <path fill="currentColor"
                                          d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z">
                                          </path>
                                      </svg><!-- <i class="fa-solid fa-trash"></i> Font Awesome fontawesome.com -->
                                    </a> --}}
                                    <button type="button" class="btn btn-primary paidfees" @if (!$due) disabled @endif data-bs-toggle="modal" data-bs-target="#payTheAmount" style="border: none; background-color: transparent;" 
                                        data-id = {{ $doctor->id }}
                                        data-total = {{ $doctor->appointments->where('is_completed', '!=', '3')->sum('fees') ?? '' }}
                                        data-remaining = {{ $doctor->appointments->where('is_completed', '!=', '3')->sum('fees')  - $doctor->financialTransaction->where('due_date', '>=', $due)->where('due_date', '<', $dateby1)->where('is_completed', '!=', '3')->sum('transaction_amount') }}
                                    >
                                      <svg style="font-size: 23px; margin-right: 7px; color: #515acc;" class="svg-inline--fa fa-money-bill" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-bill" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M512 64C547.3 64 576 92.65 576 128V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512zM128 384C128 348.7 99.35 320 64 320V384H128zM64 192C99.35 192 128 163.3 128 128H64V192zM512 384V320C476.7 320 448 348.7 448 384H512zM512 128H448C448 163.3 476.7 192 512 192V128zM288 352C341 352 384 309 384 256C384 202.1 341 160 288 160C234.1 160 192 202.1 192 256C192 309 234.1 352 288 352z"></path></svg>
                                    </button>
                                    
                                    <a href="{{ route('incomes.more', $doctor->id) }}" class="btn btn-primary">more</a>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Modal -->
                      <div id="payTheAmount" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Pay the amount</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                {{-- {{ Form::open(['id'=>'addExpenseForm', 'files' => true]) }} --}}
                                <form action="{{ route('incomes.withdraw') }}" method="post" id="formPaid">
                                  @csrf
                                  @method('post')
                                  <input id="doctorId" type="hidden" name="id" value="">
                                  <input id="total" type="hidden" name="total" value="">
                                  <input id="remaining" type="hidden" name="remaining" value="{{ $total_earning - $total_withdrawn }}">
                                  <input type="hidden" name="created_at" value="{{$due == null ? date('Y-m-d H:i:s') : $due}}">
              
                                  {{-- {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }} --}}
                                  <div class="modal-body">
                                      {{-- <div class="alert alert-danger d-none hide" id="expenseErrorsBox"></div> --}}
                                      <div class="row">
                                          
                                      </div>
                                          <div class="form-group mb-5">
                                            {{ Form::label('Amount', __('Amount').':', ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::number('transaction_amount', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'id' => 'amount', 'required', 'autocomplete' => 'off', 'tabindex' => '4']) }}
                                          </div>
                                          <div class="form-group col-sm-12 mb-5">
                                              {{ Form::label('description', __('Select Option').(':'),['class' => 'form-label']) }}
                                              <span class="required"></span>
                                              <select name="type" id="" class="form-select" placeholder="Select Services" data-control="select2" tabindex="-1" aria-hidden="true">
                                                <option value="doctor">Doctor</option>
                                                <option value="center">Center</option>
                                              </select>                                        
                                          </div>
                                          <div class="form-group col-sm-12 mb-5">
                                            {{ Form::label('description', __('Note').(':'),['class' => 'form-label']) }}
                                            {{ Form::textarea('note', null, ['class' => 'form-control', 'rows' => 4]) }}
                                          </div>
                                      </div>
                                  <div class="modal-footer pt-0">
                                      {{-- {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0']) }} --}}
                                      <button type="button" class="btn btn-primary" id="submit_btn">Save</button>
                                      <button type="button" id="cancel_btn" class="btn btn-secondary"
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
      $(document).on('click', '#submit_btn', function () {
        $('#formPaid').submit();
      });
    </script>
    <script>
      $(document).on('click', '.paidfees', function () {
          const button = document.querySelector('#paidButton');
  
          const disableButton = () => {
              button.disabled = true;
          };
  
          var id = $(this).attr('data-id');
          var total = $(this).attr('data-total');
          var remaining = $(this).attr('data-remaining');
  
          $('#doctorId').attr('value', id)
          $('#total').attr('value', total)
          $('#remaining').attr('value', remaining)
      });

      

      // $("#formPaid").submit(function (e) {
      //   e.preventDefault();
      //   var formData = new FormData(this);
      //   $.ajax({
      //       type: 'post',
      //       enctype: 'multipart/form-data',
      //       url: "/incomes/withdraw",
      //       data: formData,
      //       cache: false,
      //       contentType: false,
      //       processData: false,
      //       success: function (data) {
      //         console.log('ss');
      //           $('#alert_withdrawl').empty()
      //           $('#alert_withdrawl').append('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
      //               '<i class="fa fa-exclamation-circle me-2"></i>Successfuly paid' +
      //               '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
      //               '</div>')
      //           setTimeout(function () {
      //               $('#alert_withdrawl').empty()
      //           }, 5000);
      //       }
      //       , error: function (data) {
      //         console.log('aa');
      //           $('#alert_withdrawl').empty();
      //           for (const key in data.responseJSON.errors) {
      //               $('#alert_withdrawl').append(
      //                   '<div class="alert alert-danger alert-dismissible fade show" role="alert">\n' +
      //                   '<i class="fa fa-exclamation-circle me-2"></i>' + data.responseJSON.errors[key][0] + '\n' +
      //                   '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>\n' +
      //                   '</div>'
      //               )setTimeout(function () {
      //               $('#alert_withdrawl').empty()
      //           }, 5000);
      //           }
      //       }
      //   });
      // });

  </script>
@endsection

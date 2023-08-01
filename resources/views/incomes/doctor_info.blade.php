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
                            <div class="position-relative d-flex width-470">
                              <input style="padding: 0 10px;" type="date" name="due" value="{{ $due }}" class='form-control' style="margin-left: 10px;">
                              <input type="submit" value="Search" class="form-control btn btn-primary" style="margin-left: 10px;">
                            </div>
                          </form>
                        </div>
                        <div>
                          <button @if (!$due) disabled @endif  href="" class="btn btn-primary" style="margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#payTheAmount"><svg style="font-size: 23px; margin-right: 7px; color: white;" class="svg-inline--fa fa-money-bill" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-bill" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M512 64C547.3 64 576 92.65 576 128V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512zM128 384C128 348.7 99.35 320 64 320V384H128zM64 192C99.35 192 128 163.3 128 128H64V192zM512 384V320C476.7 320 448 348.7 448 384H512zM512 128H448C448 163.3 476.7 192 512 192V128zM288 352C341 352 384 309 384 256C384 202.1 341 160 288 160C234.1 160 192 202.1 192 256C192 309 234.1 352 288 352z"></path></svg>
                          </button>
                        </div>
                        <div>
                          <a  href="{{route('incomes.doctors.exportPdf', ['doctor_id' => $doctor->id, 'date' => $due])}}" target="_blank" class="btn btn-primary" style="margin-left: 10px;"><i class="fa-solid fa-print"></i></a>
                        </div>
                        <div class="mb-3 mb-sm-0" style="margin-left: 20px;">
                          <div class="position-relative d-flex width-500">
                            <button class="btn btn-primary" style="margin-right: 10px; width: fit-content; cursor: auto;">Earning: {{ $total_earning }}</button>
                            <button class="btn btn-primary" style="margin-right: 10px; width: fit-content; cursor: auto;">Withdrawn: {{ $total_withdrawn }}</button>
                            <button class="btn btn-primary" style="margin-right: 10px; width: fit-content; cursor: auto;">Remaining: {{ $total_earning - $total_withdrawn }}</button>
                          </div>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
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
                            <span>Withdrawn Amount</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>Withdrawn date</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>Type</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-3-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('date')" style="cursor:pointer;">
                            <span>Note</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
                      </tr>
                    </thead>
              
                    <tbody class="">
                        @foreach ($transactions as $item)
                            <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                    <span class="badge bg-light-info text-decoration-none">{{ $loop->iteration  }}</span>
                                </div>
                                </td>
                    
                                <td class="p-5" wire:key="cell-0-1-WpskoqwzxJ5BdNxsPOsu">
                                  {{ $item->transaction_amount ?? 0 }}
                                </td>
                    
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                  {{ date('d-m-Y', strtotime($item->due_date)) ?? '' }}
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
                                    {{ $item->type ?? '' }}
                                  </div>
                                  </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                  {{ $item->note ?? '' }}
                                </div>
                                </td>
                    
                            </tr>
                        @endforeach
                          <!-- Modal -->
                      <div id="payTheAmount" class="modal fade" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Pay the amount</h3>
                                </div>
                                {{-- {{ Form::open(['id'=>'addExpenseForm', 'files' => true]) }} --}}
                                <form action="{{ route('incomes.withdraw') }}" method="post" id="formPaid" onsubmit="disableButton()">
                                  @csrf
                                  @method('post')
                                  <input id="doctorId" type="hidden" name="id" value="{{ $doctor->id }}">
                                  <input id="total" type="hidden" name="total" value="{{ $total_earning }}">
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
                                            {{ Form::number('transaction_amount', null, ['class' => (getLoggedInUser()->thememode ? 'bg-light patientBirthDate form-control' : 'bg-white patientBirthDate form-control'), 'required', 'id' => 'amount', 'autocomplete' => 'off', 'tabindex' => '4']) }}
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
                                      {{-- <button type="submit"  class="btn btn-primary" id="btn_order">Save</button> --}}
                                      <button type="button" class="btn btn-primary" id="submit_btn">Save</button>
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


                <div class="table-responsive mt-3">
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
                            <span>Patient Name</span>
              
                            <span class="relative">
                            </span>
                          </div>
                        </th>
              
                        <th scope="col" class="" wire:key="header-col-2-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('income_head')" style="cursor:pointer;">
                            <span>Fees</span>
                            <span class="relative">
                            </span>
                          </div>
                        </th>
                      </tr>
                    </thead>
                    <p class="mt-3">{{ $transactions->links() }}</p>
                    <tbody class="">
                        @foreach ($appointments as $item)
                            <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                    <span class="badge bg-light-info text-decoration-none">{{ $loop->iteration  }}</span>
                                </div>
                                </td>
                    
                                <td class="p-5" wire:key="cell-0-1-WpskoqwzxJ5BdNxsPOsu">
                                  {{ $item->patient->user->first_name }} {{ $item->patient->user->middle_name }} {{ $item->patient->user->last_name }}
                                </td>
                    
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                <div class="d-flex align-items-center mt-3">
                                  {{ $item->fees }}
                                </div>
                                </td>
                    
                            </tr>
                        @endforeach
                    </tbody>
              
                  </table>
                </div>
                  <!-- Modal -->
                               
                {{-- <div class="d-flex align-items-center mb-5 mt-3">
                  <div class="mb-xxl-0 d-flex align-items-center justify-content-sm-start justify-content-center">
                    <span class="me-3 text-gray-600 fs-4 fs-xl-6">Show</span>
                    <select wire:model="perPage" id="perPage" class="form-select w-auto data-sorting pl-1 pr-5 py-2 border-0">
                      <option value="10" wire:key="per-page-10-table">10</option>
                      <option value="25" wire:key="per-page-25-table">25</option>
                      <option value="50" wire:key="per-page-50-table">50</option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col-12 ms-3 text-gray-600 fs-4">
                      Showing <strong>1</strong>
                      results </div>
                  </div>
                </div> --}}
                

              </div>
              
        </div>



     
@endsection
@section('scripts')

    {{--    assets/js/incomes/incomes.js --}}
    {{--    assets/js/custom/new-edit-modal-form.js --}}
    {{-- <script src="{{ asset('assets/js/incomes/incomes.js') }}"></script> --}}

    <script>
      $(document).on('click', '#submit_btn', function () {
        $('#formPaid').submit();
      });

      function disableButton() {
        document.getElementById("submit_btn").disabled = true;
      }
    </script>
    
    <script>
      function myFunction() {
          const button = document.querySelector('#paidButton');
  
          const disableButton = () => {
              button.disabled = true;
          };
      }
  </script>


@endsection

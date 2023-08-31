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
                                <h1>{{ __('messages.appointment.search_old_patient') }}</h1>
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

                @if (count($patients) == 0)
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('appointments.old.patient.search') }}" method="GET">
                                @csrf
                                @method('get')
                                <div class="p-5 row">
                                <div class="mb-5 col-4">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.first_name') }}:</label>
                                    <input type="text" name="first_name" class="form-control">
                                </div>
                                <div class="mb-5 col-4">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.middle_name') }}:</label>
                                    <input type="text" name="middle_name" class="form-control">
                                </div>
                                <div class="mb-5 col-4">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.user.last_name') }}:</label>
                                    <input type="text" name="last_name" class="form-control">
                                </div>
                                <div class="mb-5 col-6">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.case.phone') }}:</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="mb-5 col-6">
                                    <label for="exampleInputSelect2" class="form-label">{{ __('messages.appointment.file_number') }}:</label>
                                    <input type="text" name="file_number" class="form-control">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-secondary" id="incomeResetFilter">{{ __('messages.common.search') }}</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
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
                                    <span>{{ __('messages.appointment.file_number') }}</span>
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
                                    <span>{{ __('messages.case.phone') }}</span>
                                    <span class="relative">
                                    </span>
                                    </div>
                                </th>
                                <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                                    <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                                    <span>{{ __('messages.common.action')}}</span>
                                    <span class="relative">
                                    </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    
                        <tbody class="">
                            @foreach ($patients as $item)
                                <tr wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                    <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                        <div class="d-flex align-items-center mt-3">
                                            <span class="badge bg-light-info text-decoration-none">{{ $loop->iteration  }}</span>
                                        </div>
                                    </td>

                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                        <div class="d-flex align-items-center mt-4">
                                            #{{$item->serial_number ?? ''}}
                                        </div>
                                    </td>

                                    <td class="" wire:key="cell-0-0-WpskoqwzxJ5BdNxsPOsu">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <a href="{{route('patients.show',$item->patient->id)}}"
                                                    class="mb-1 text-decoration-none">{{$item->first_name ?? ''}} {{$item->middle_name ?? ''}} {{$item->last_name ?? ''}} @if(count($item->patient->appointments) == 1) <small style="color: green">(new)</small> @endif</a>
                                            </div>
                                        </div>                                    
                                    </td>
    
                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                        <div class="d-flex align-items-center mt-4">
                                            {{$item->phone ?? ''}}
                                        </div>
                                    </td>

                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                        <a href="{{ route('appointments.old.patient.search.create', $item->id) }}" class="btn btn-primary" title="{{ __('messages.appointment.new_appointment') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">{{ __('messages.appointment.new_appointment') }}</a>
                                    </td>
                        
                                </tr>
                            @endforeach
                        </tbody>
                    
                        </table>
                    </div>
                @endif
                    

              </div>
        </div>
@endsection
@section('scripts')
    {{--    assets/js/incomes/incomes.js --}}
    {{--    assets/js/custom/new-edit-modal-form.js --}}
@endsection

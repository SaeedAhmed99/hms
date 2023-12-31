@extends('layouts.app')
@section('title')
    {{__('messages.lab_technician_category')}}
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
                            <h1 class="text-gray-900 mb-0">{{ __('messages.prescription.order_lab_list') }}</h1>
                        </div>
                  
                        <div class="d-flex justify-content-end ">
                        
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
                                    <span>{{ __('messages.user.name') }}</span>
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
                                <span>{{ __('messages.common.status') }}</span>
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
    
                            <th scope="col" class="" style="padding-right: 7rem !important; width: 20%;"
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
                            @foreach ($orderlabs as $item)
                                <tr id="Category" wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $loop->iteration }}</td>

                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $item->patient->user->first_name ?? '' }} {{ $item->patient->user->middle_name ?? '' }} {{ $item->patient->user->last_name ?? '' }}</td>

                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $item->doctor->user->first_name ?? '' }} {{ $item->doctor->user->middle_name ?? '' }} {{ $item->doctor->user->last_name ?? '' }}</td>
    
                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                        @if ($item->status == '0')
                                            {{ __('messages.common.cancel') }}
                                        @elseif ($item->status == '1')
                                            {{ __('messages.appointment.pending') }}
                                        @elseif ($item->status == '2')
                                            {{ __('messages.appointment.completed') }}
                                        @endif
                                    </td>

                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $item->created_at }}</td>
    
                                    <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                         <a href="{{ route('patients.show.order', $item->id) }}" class="btn px-1 text-primary fs-3 ps-0 edit-btn">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>   
                                        @if (count($item->documents) == 0)
                                            <a data-order_lab_id="{{ $item->id }}" data-patient_id="{{ $item->patient_id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                                <i class="fa-regular fa-file"></i>
                                            </a>
                                        @else
                                            <a data-order_lab_id="{{ $item->id }}" data-patient_id="{{ $item->patient_id }}" data-bs-toggle="modal" data-bs-target="#addFile" title="{{ __('messages.addfile') }}"  class="btn px-1 text-primary fs-3 pe-0 iconAddFile">
                                                <i class="fa-solid fa-file"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
                                        <form id="fileForm" action="{{ route('lab.order.list.add.file') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                        {{-- {{ Form::hidden('currency_symbol', getCurrentCurrency(), ['class' => 'currencySymbol']) }} --}}
                                        <div class="modal-body">
                                            {{-- <div class="alert alert-danger d-none hide" id="expenseErrorsBox"></div> --}}
                                            <input type="number" name="patient_id" id="patient_id" hidden value="">
                                            <input type="number" name="order_lab_id" id="order_lab_id" hidden value="">
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
        // $(function(){
        //     $('.iconAddFile').click(function(){
        //         var patient_id = $(this).attr('data-patient_id');
        //         var order_lab_id = $(this).attr('data-order_lab_id');
        //         $("#patient_id").val(patient_id);
        //         $("#order_lab_id").val(order_lab_id);
        //     });
        // });

        $(document).on('click', '.iconAddFile', function(){
            var patient_id = $(this).attr('data-patient_id');
            var order_lab_id = $(this).attr('data-order_lab_id');
            $("#patient_id").val(patient_id);
            $("#order_lab_id").val(order_lab_id);
        });
    </script>

    <script>
        $(document).on('click', '#submit_file_btn', function () {
            console.log('s');
            $('#fileForm').submit();
        });
    </script>
@endsection

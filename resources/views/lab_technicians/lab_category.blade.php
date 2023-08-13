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
                            <h1 class="text-gray-900 mb-0">{{ __('messages.lab_technician_category') }}</h1>
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
                                <button data-bs-toggle="modal" data-bs-target="#labCategoryModal" class="dropdown-item  px-5">{{ __('messages.lab_category') }}</button>
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
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead class="">
                      <tr>
                        <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                            <span>{{ __('messages.item.name') }}</span>
                            <span class="relative">
                            </span>
                          </div>
                        </th>

                        <th scope="col" class="" wire:key="header-col-0-WpskoqwzxJ5BdNxsPOsu">
                          <div class="" wire:click="sortBy('invoice_number')" style="cursor:pointer;">
                            <span>{{ __('messages.appointment.description') }}</span>
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
                        @foreach ($categories as $category)
                            <tr id="Category" wire:loading.class.delay="" class="" wire:key="row-0-WpskoqwzxJ5BdNxsPOsu">
                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $category->name }}</td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">{{ $category->description }}</td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    <a href="{{ route('lab.category.add.type', $category->id) }}" class="btn px-1 text-primary fs-3 ps-0 edit-btn">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>   
                                    <button data-bs-toggle="modal" data-id="{{ $category->id }}" data-bs-target="#updateCategoryModal" title="{{__('messages.common.edit') }}"
                                        class="btn px-1 text-primary fs-3 ps-0 edit-btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>   
                                    <button title="<?php echo __('messages.common.delete') ?>" data-id="{{ $category->id }}"
                                        class="labCategory-delete-btn btn px-1 text-danger fs-3 pe-0" wire:key="">
                                         <i class="fa-solid fa-trash"></i>
                                     </button>         
                                </td>
                            </tr>
                        @endforeach
                      
                    </tbody>
                  </table>
                   <!-- Modal -->
                   <div id="labCategoryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.lab_category') }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="addCategoryForm" action="{{ route('lab.category.store') }}" method="post">
                              @csrf
                              @method('post')
                              <div class="modal-body">
                                    <!-- Notes Field -->
                                    <div class="form-group col-sm-12 mb-5">
                                        {{ Form::label('Name', __('messages.item.name').':', ['class' => 'form-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group col-sm-12 mb-5">
                                        {{ Form::label('Description', __('messages.appointment.description').':', ['class' => 'form-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'rows'=>'4']) }}
                                    </div>
                                </div>
                                <div class="modal-footer pt-0">
                                    <button type="submit" class="btn btn-primary" id="submit_category_btn">Save</button>
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
               <!-- Modal -->
                <div id="updateCategoryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.lab_category_edit') }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form id="updateCategoryForm" action="{{ route('lab.category.update') }}" method="post">
                              @csrf
                              @method('post')
                              <input hidden type="number" name="id" id="categoryId-input">
                              <div class="modal-body">
                                    <!-- Notes Field -->
                                    <div class="form-group col-sm-12 mb-5">
                                        {{ Form::label('Name', __('messages.item.name').':', ['class' => 'form-label']) }}
                                        {{-- {{ Form::text('name', null, ['class' => 'form-control']) }} --}}
                                        <input type="text" name="name" class="form-control" id="title-input">
                                    </div>
                                    <div class="form-group col-sm-12 mb-5">
                                        {{ Form::label('Description', __('messages.appointment.description').':', ['class' => 'form-label']) }}
                                        {{-- {{ Form::textarea('description', null, ['class' => 'form-control', 'rows'=>'4']) }} --}}
                                        <textarea name="description" id="description-input" class="form-control" id="" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer pt-0">
                                    <button type="button" class="btn btn-primary" id="update_category_btn">Save</button>
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                                </div>
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
        $(document).on('click', '#submit_category_btn', function () {
            console.log('s');
            $('#addCategoryForm').submit();
        });
    </script>

    <script>
        $(document).on("click", '.edit-btn', function() {
            var row = $(this).closest("tr");
            var id = $(this).data("id");
            var title = row.find("td:eq(0)").text();
            var description = row.find("td:eq(1)").text();
            $("#categoryId-input").val(id);
            $("#title-input").val(title);
            $("#description-input").val(description);
        });
    </script>

    <script>
        $(document).on('click', '#update_category_btn', function () {
            console.log('s');
            $('#updateCategoryForm').submit();
        });
    </script>

    <script>
        listenClick('.labCategory-delete-btn', function (event) {
            var id = $(this).data("id");

            deleteItem('category/destroy/' + id, $('#Category').remove())
        })
    </script>
    
@endsection

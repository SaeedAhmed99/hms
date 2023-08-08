@extends('layouts.app')
@section('title')
    {{ __('messages.prescription.create_order') }}
@endsection
@section('page_css')

@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ url()->previous() }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')

        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8">
                                        <h1 class="mb-5">{{ __('messages.choose_medical_tests') }}</h1>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control" type="text" id="searchInput" placeholder="{{ __('messages.common.search') }}">
                                    </div>
                                </div>
                                <ul class="list-group">
                                    <form action="{{ route('patients.store.order') }}" method="post">
                                        @csrf
                                        @method('post')
                                        <input type="number" name="patient_id" value="{{ $id }}" hidden>
                                        <div class="row">

                                        @foreach ($categoryLabs as $item)
                                           <div class="col-3 mb-3">
                                                <li style="cursor: pointer;" class="" data-toggle="" data-target=""><h3>{{ $item->name }}</h3></li>
                                                <div id="" class="" style="margin-left: 10px;">
                                                    @foreach ($item->labs as $item1)
                                                        <li><input class="analysisCheckbox" type="checkbox" name="labs[]" value="{{ $item1->id }}" data-text="{{ $item1->name }}">  {{ $item1->name }}</li>
                                                    @endforeach
                                                    {{-- <ul class="list-group">
                                                        @foreach ($item->labs as $item1)
                                                            <li class="list-group-item">
                                                                <label>
                                                                    <input type="checkbox" name="labs[]" value="{{ $item1->id }}">  {{ $item1->name }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul> --}}
                                                </div>   
                                           </div>
                                        @endforeach
                                    </div>

                                        <button type="submit" class="btn btn-primary mt-3">{{ __('messages.prescription.create_order') }}</button>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
{{-- JS File :- assets/js/patients/patients_data_listing.js --}}

@section('scripts')
{{-- <script src="{{ asset('js/ckeditor/build/ckeditor.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- رابط Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
          $("#searchInput").on("input", function() {
            var searchText = $(this).val().toLowerCase();

            $(".analysisCheckbox").each(function() {
            //   var analysisText = $(this).val().toLowerCase();
              var analysisText = $(this).attr('data-text').toLowerCase();
              var analysisItem = $(this).parent();
              
              if (analysisText.includes(searchText)) {
                analysisItem.show();
              } else {
                analysisItem.hide();
              }
            });
          });
        });
    </script>
@endsection

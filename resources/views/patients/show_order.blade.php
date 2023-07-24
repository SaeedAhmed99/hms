@extends('layouts.app')
@section('title')
    {{ __('messages.show_medical_tests') }}
@endsection
@section('page_css')

@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @if (Auth::user()->hasRole('Doctor'))
                    <a href="{{ route('patients.show', $order->patient_id) }}"
                    class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
                @else
                    <a href="{{ url()->previous() }}"
                    class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
                    {{-- <a href="{{ route('lab.order.list') }}"
                    class="btn btn-outline-primary">{{ __('messages.common.back') }}</a> --}}
                @endif
                
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
                                <h1 class="mb-3">{{ __('messages.show_medical_tests') }}</h1>
                                <ul class="list-group">
                                    @foreach ($categoryLabs as $item)
                                        <li style="cursor: pointer;" class="list-group-item category" data-toggle="collapse" data-target="#category{{ $item->id }}"><h3>{{ $item->name }}</h3></li>
                                        <div id="category{{ $item->id }}" class="collapse show">
                                            <ul class="list-group">
                                                @foreach ($item->labs as $item1)
                                                    <li class="list-group-item" @if(in_array($item1->id, $listSelectedLabs)) style="background-color: #ccc;" @endif>
                                                        <label>
                                                            <input disabled type="checkbox" name="labs[]" @if(in_array($item1->id, $listSelectedLabs)) checked @endif  >  {{ $item1->name }}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>   
                                    @endforeach
                                </ul>
                            </div>
                            <div class="container">
                                <div class="row mt-5">
                                    @foreach ($order->documents as $item)
                                        <div class="col-4">
                                            <img src="{{ asset(str_replace("http://localhost", "", $item->document_url)) }}"  alt="" style="width: 300px; height: 300px; cursor: pointer;" class="img-fluid mb-3 zoomE" >
                                        </div>
                                    @endforeach
                                </div>
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
<script>
    window.onload = () => {
        // (A) GET ALL IMAGES
        let all = document.getElementsByClassName("zoomE");
        console.log(all);

        // (B) CLICK TO GO FULLSCREEN
        if (all.length>0) { for (let i of all) {
            i.onclick = () => {
            // (B1) EXIT FULLSCREEN
            if (document.fullscreenElement != null || document.webkitFullscreenElement != null) {
                if (document.exitFullscreen) { document.exitFullscreen(); }
                else { document.webkitCancelFullScreen(); }
            }

            // (B2) ENTER FULLSCREEN
            else {
                if (i.requestFullscreen) { i.requestFullscreen(); }
                else { i.webkitRequestFullScreen(); }
            }
            };
        }}
    };
</script>

{{-- <script src="{{ asset('js/ckeditor/build/ckeditor.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- رابط Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    
@endsection

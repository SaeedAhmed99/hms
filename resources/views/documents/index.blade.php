@extends('layouts.app')
@section('title')
    {{ __('messages.documents') }}
@endsection
@section('css')
<style>
    #image-container {
      text-align: center;
      cursor: pointer;
    }
  
    #fullscreen-image {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      z-index: 9999;
    }
  
    #fullscreen-image img {
      max-width: 100%;
      max-height: 100%;
      margin: auto;
      display: block;
    }
  </style>
@endsection
@section('content')
{{--    @include('flash::message')--}}
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column">
            {{Form::hidden('documentsCreateUrl',route('documents.store'),['id'=>'indexDocumentsCreateUrl','class'=>'documentsCreateUrl'])}}
            {{Form::hidden('documentsUrl',route('documents.index'),['id'=>'indexDocumentsUrl','class'=>'documentsUrl'])}}
            {{Form::hidden('defaultDocumentImageUrl',asset('assets/img/default_image.jpg'),['id'=>'indexDefaultDocumentImageUrl','class'=>'defaultDocumentImageUrl'])}}
            {{Form::hidden('downloadDocumentUrl',url('document-download'),['id'=>'indexDownloadDocumentUrl','class'=>'downloadDocumentUrl'])}}
            {{Form::hidden('patientUrl',route('patients.index'),['id'=>'indexPatientUrl','class'=>'patientUrl'])}}
            {{ Form::hidden('documents', __('messages.document.document'), ['id' => 'Documents']) }}
            <livewire:document-table/>
            @include('documents.add_modal')
            @include('documents.edit_modal')

            <div id="fullscreen-image">
                <img src="">
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    {{--   assets/js/document/document.js --}}
    {{--   assets/js/custom/new-edit-modal-form.js --}}

    <script>
        $(document).ready(function() {
            // عند النقر على الايقونة
            $('.action-container').on('click', '#show-button', function() {
                var imageUrl = $(this).attr('data-href');
                $('#fullscreen-image img').attr('src', imageUrl);
                $('#fullscreen-image').fadeIn();
            });

            $('#fullscreen-image').on('click', function() {
                $(this).fadeOut();
            });
        });
    </script>
@endsection

@extends('layouts.app')
@section('title')
    {{ __('messages.patient.patient_details') }}
@endsection
@section('page_css')
<style>
    .ck-editor__editable {
            height: 400px;
            width: 100%;
        }

    .navbar-expand-lg .navbar-nav {
        width: 100%;
    }

    .containerImage {
        position: relative;
    }

    .delete {
        position: absolute;
        width: fit-content;
        top: 0;
        right: 0;
    }

    #section_text_for_history, #back_history, #back_rochet, #section_text_for_rochet {
        display: none;
    }
</style>
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-7">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                @if (!Auth::user()->hasRole('Doctor|Accountant|Case Manager|Nurse|Patient'))
                    <a href="{{ route('patients.edit',['patient' => $data->id]) }}"
                       class="btn btn-primary me-2">{{ __('messages.common.edit') }}</a>
                @endif
                <a href="{{ route('appointments.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')

        {{Form::hidden('advancedPaymentUrl',url('advanced-payments'),['id'=>'showPatientAdvancedPaymentUrl'])}}
        {{Form::hidden('advancePaymentCreateUrl',route('advanced-payments.store'),['id'=>'showPatientAdvancePaymentCreateUrl'])}}
        {{Form::hidden('patientUrl',url('patients'),['id'=>'showPatientUrl'])}}
        {{Form::hidden('vaccinatedPatientUrl',route('vaccinated-patients.index'),['id'=>'showVaccinatedPatientUrl'])}}
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                    @include('patients.show_fields')
                </div>
            </div>
            @include('patients.advanced_payments.edit_modal')
            @include('patients.vaccinations.edit_modal')
        </div>
    </div>
@endsection
{{-- JS File :- assets/js/patients/patients_data_listing.js --}}

@section('scripts')
{{-- <script src="{{ asset('js/ckeditor/build/ckeditor.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="https://cdn.tiny.cloud/1/1urw5cscdnze9hew8gcr7tyxcb4b6u92tly1h2xe433kvw92/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script> --}}
<script>
    tinymce.init({
      selector: 'textarea#section_text_for_history_editor',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ]
    });

</script>

<script>
    tinymce.init({
      selector: 'textarea#section_text_for_rochet_editor',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ]
    });
</script>

<script>
    $(document).on('click', '#Add_History_by_text', function (e) {
        e.preventDefault();
        $('#section_image_for_history').removeAttr("style").hide();
        $('#section_text_for_history').removeAttr("style").show();
        $('#back_history').removeAttr("style").show();
        $('#back_history').css("display", "inline");
        $('#Add_History_by_text').removeAttr("style").hide();
    });

    $(document).on('click', '#back_history', function (e) {
        e.preventDefault();
        $('#section_image_for_history').removeAttr("style").show();
        $('#section_text_for_history').removeAttr("style").hide();
        $('#back_history').removeAttr("style").hide();
        $('#Add_History_by_text').removeAttr("style").show();
    });


    $(document).on('click', '#Add_rochet_by_text', function (e) {
        e.preventDefault();
        $('#section_image_for_rochet').removeAttr("style").hide();
        $('#section_text_for_rochet').removeAttr("style").show();
        $('#back_rochet').removeAttr("style").show();
        $('#back_rochet').css("display", "inline");
        $('#Add_rochet_by_text').removeAttr("style").hide();
    });

    $(document).on('click', '#back_rochet', function (e) {
        e.preventDefault();
        $('#section_image_for_rochet').removeAttr("style").show();
        $('#section_text_for_rochet').removeAttr("style").hide();
        $('#back_rochet').removeAttr("style").hide();
        $('#Add_rochet_by_text').removeAttr("style").show();
    });
</script>

<script>
    $(document).on('click', '.zoomE', function (e) {
        let all = document.getElementsByClassName("zoomE");
        

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
    })

    // window.onload = () => {
    //     // (A) GET ALL IMAGES
    //     let all = document.getElementsByClassName("zoomE");
    //     console.log(all);
        

    //     // (B) CLICK TO GO FULLSCREEN
    //     if (all.length>0) { for (let i of all) {
    //         i.onclick = () => {
    //         // (B1) EXIT FULLSCREEN
    //         if (document.fullscreenElement != null || document.webkitFullscreenElement != null) {
    //             if (document.exitFullscreen) { document.exitFullscreen(); }
    //             else { document.webkitCancelFullScreen(); }
    //         }

    //         // (B2) ENTER FULLSCREEN
    //         else {
    //             if (i.requestFullscreen) { i.requestFullscreen(); }
    //             else { i.webkitRequestFullScreen(); }
    //         }
    //         };
    //     }}
    // };
</script>

<script>
    $(document).on('click', '.delete-image', function (e) {
        e.preventDefault();
        var image = $(this).attr('image-name');
        var delimage = $(this).parent();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: "/patients/image/destroy",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: image
                    },
                    success: function (data) {
                        delimage.remove();
                        Swal.fire(
                            'Deleted!',
                            'Record has been deleted.',
                            'success'
                        )
                    },
                    error: function (data) {
                        Swal.fire(
                            'Not Deleted!',
                            data.responseJSON.message,
                            'error'
                        )
                    }
                });
            }
        })
    });
</script>

<script>
    $("#formSaveTextHistory").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: 'patients/history/text',
        data: $(this).serialize(),
        success: function (data) {
            $('#alert_save_text_history').empty()
            $('#alert_save_text_history').append(`
                <div class="alert alert-success" role="alert">
                    updated successfully.
                </div>
            `)
            setTimeout(function () {
                $('#alert_save_text_history').empty()
            }, 8000);
        },
        error: function (data) {
            $('#alert_save_text_history').empty()
            for (const key in data.responseJSON.errors) {
                $('#alert_save_text_history').append(
                    `
                        <div class="alert alert-danger" role="alert">
                            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <li>${data.responseJSON.errors[key]}</li>
                        </div>
                    `
                )
                setTimeout(function () {
                    $('#alert_save_text_history').empty()
                }, 8000);
            }
        }
    });
    });
</script>
@endsection

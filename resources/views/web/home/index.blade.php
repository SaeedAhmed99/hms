@extends('web.layouts.front')
@section('title')
    {{ __('web.home') }}
@endsection

@section('content')
    <div class="home-page">
        <!-- start hero section -->
        <section
                class="hero-section position-relative p-t-120 p-b-200 border-bottom-right-rounded border-bottom-left-rounded bg-gray"
                id="div1">
            <div class="container">
                <div class="row align-items-center flex-column-reverse flex-lg-row">
                    <div class="col-lg-6 text-lg-start text-center">
                        <div class="hero-content mt-5 mt-lg-0">
                            <h6 @if(app()->getLocale() == 'ar') style="text-align: right;" @endif class="text-primary mb-3">{{ $frontSetting['home_page_experience'] }} {{ __('messages.web_home.years_experience') }}</h6>
                            <h1 @if(app()->getLocale() == 'ar') style="text-align: right;" @endif class="mb-3 pb-1">
                                {{ \Illuminate\Support\Str::limit($frontSetting['home_page_title'], 42) }}
                            </h1>
                            <p @if(app()->getLocale() == 'ar') style="text-align: right;" @endif class="mb-lg-4 pb-lg-3 mb-4">
                                {{ \Illuminate\Support\Str::limit($frontSetting['home_page_description'], 170) }}</p>
                            @if(!Auth::user())
                                <a @if(app()->getLocale() == 'ar') style="text-align: right;" @endif href="{{ route('register') }}"
                                   class="btn btn-primary" data-turbo="false">{{ __('messages.web_home.sign_up') }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-end text-center">
                        <img style="border-radius: 10px;" src="{{ !empty($frontSetting['home_page_image']) ? $frontSetting['home_page_image'] : asset('web_front/images/main-banner/banner-one/Home.png') }}"
                             alt="Infy Care" class="img-fluid"/>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!--start book-appointment section-->
        {{-- <section class="appointment-section">
            <div class="container">
                <div class="book-appintment position-relative br-2 bg-white">
                    <form action="{{ route('appointment.post') }}" method="POST" turbo:load>
                        <div class="row align-items-center justify-content-around">
                            <div class="col-lg-3">
                                <h3 class="mb-lg-0 mb-3 fw-bold">{{ __('messages.web_home.book_an_appointment') }}</h3>
                            </div>
                            <div class="col-lg-3 col-md-6 text-center mb-lg-0 mb-3">
                                <select class="doctor-name-filter" name="doctorId" id="appointmentDoctorId" aria-label="select doctor">
                                    <option value="">{{ __('messages.web_home.select_doctor') }}</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->doctorUser->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 text-center mb-lg-0 mb-3">
                                <input type="text" name="appointmentDate" autocomplete="off" class="form-control datepicker"
                                       id="datepicker"
                                       placeholder="{{ __('messages.web_appointment.select_time') }}">

                            </div>
                            <div class="col-lg-3 text-end">
                                <button type="submit" class="btn btn-primary d-block w-100" id="bookAppointment">
                                    {{ __('messages.web_home.book_now') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section> --}}
        <!--end book-appointment section-->

        <!-- start easy-solution section -->
        {{-- <section class="easy-solution-section position-relative">
            <div class="container">
                <div class="col-lg-6 text-center mx-auto">
                    <h6 class="text-primary pb-2">{{ __('messages.web_home.easy_solutions') }}</h6>
                    <h2 class="mb-4 pb-4">{{ __('messages.web_home.4_easy_step_and_get_the_world_best_treatment') }}</h2>
                </div>
                <div class="easy-solution-cards">
                    <div class="row justify-content-between">
                        <div class="col-xxl-3 col-md-6 text-center solution-card mb-xxl-0 mb-4">
                            <div class="card">
                                <div class="icon-box mx-auto br-5 mb-4 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user fs-5"></i>
                                </div>
                                <div class="card-body p-0 text-center">
                                    <h4>{{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_1_title'], 22) }}</h4>
                                    <p class="mb-0">
                                        {{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_1_description'], 114) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 text-center solution-card mb-xxl-0 mb-4">
                            <div class="card">
                                <div class="icon-box mx-auto br-5 mb-4 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-headphones-simple fs-5"></i>
                                </div>
                                <div class="card-body p-0 text-center">
                                    <h4>{{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_2_title'], 22) }}</h4>
                                    <p class="mb-0">
                                        {{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_2_description'], 114) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-6 text-center solution-card mb-xxl-0 mb-4">
                            <div class="card">
                                <div class="icon-box mx-auto br-5 mb-4 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-calendar-check fs-5"></i>
                                </div>
                                <div class="card-body p-0 text-center">
                                    <h4>{{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_3_title'], 22) }}</h4>
                                    <p class="mb-0">
                                        {{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_3_description'], 114) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 text-center solution-card mb-xxl-0 mb-lg-4">
                            <div class="card">
                                <div class="icon-box mx-auto br-5 mb-4 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-check-double fs-5"></i>
                                </div>
                                <div class="card-body p-0 text-center">
                                    <h4>{{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_4_title'], 22) }}</h4>
                                    <p class="mb-0">
                                        {{ \Illuminate\Support\Str::limit($frontSetting['home_page_step_4_description'], 114) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- end easy-solution section -->

        <!--start about-section -->
        <section class="about-section p-t-120 p-b-120">
            <div class="container">
                <div class="row align-items-stretch flex-column-reverse flex-lg-row">
                    <div class="col-lg-6">
                        <div class="about-right pb-5 pt-lg-5 text-lg-start text-center">
                            <h2 class="mt-md-3">{{ \Illuminate\Support\Str::limit(getFrontSettingValue(\App\Models\FrontSetting::ABOUT_US, 'about_us_title'), 31) }}</h2>
                            <p class="mt-4">{!!  \Illuminate\Support\Str::limit(getFrontSettingValue(\App\Models\FrontSetting::ABOUT_US, 'about_us_description'), 615)  !!}</p>
                            {{-- <a href="{{ route('appointment') }}"
                               class="btn btn-primary mt-4">{{ __('messages.web_home.book_appointment') }}</a> --}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="row h-100">
                            <div class="col-lg-7 col-md-7 about-count-block">
                                <div class="about-count h-100 br-2 text-center d-flex align-items-center justify-content-center py-lg-3 py-5 px-3">
                                    <div>
                                        {{-- <h3 class="text-green">{{ $totalbeds }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.patients_beds') }}</h4> --}}
                                        <img src="{{ asset('images/about_us_image_01.jpeg') }}" style="border-radius: 8px;" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class=" col-lg-5 col-md-5 about-count-block">
                                <div class="about-count h-100 br-2 text-center d-flex align-items-center justify-content-center py-lg-3 py-5 px-3">
                                    <div>
                                        {{-- <h3 class="text-pink">{{ $totalDoctorNurses }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.doctors_nurses') }}</h4> --}}
                                        <h3 class="text-blue">{{ $frontSetting['home_page_experience'] }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.years_experience') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 about-count-block">
                                <div class="about-count h-100 br-2 text-center d-flex align-items-center justify-content-center py-lg-3 py-5 px-3">
                                    <div>
                                        {{-- <h3 class="text-primary">{{ $totalPatient }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.happy_patients') }}</h4> --}}
                                        <h3 class="text-pink">{{ $totalDoctorNurses }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.doctors_nurses') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 about-count-block">
                                <div class="about-count h-100 br-2 text-center d-flex align-items-center justify-content-center py-lg-3 py-5 px-3">
                                    <div>
                                        {{-- <h3 class="text-blue">{{ $frontSetting['home_page_experience'] }}</h3>
                                        <h4 class="fw-normal mb-0">{{ __('messages.web_home.years_experience') }}</h4> --}}
                                        <img src="{{ asset('images/about_us_image_02.jpeg') }}" style="border-radius: 8px;" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </section>
        <!-- end about-section -->

        <!-- start service-section -->
        <section class="service-section p-t-120 p-b-100 bg-gray">
            <div class="container">
                <div class="col-lg-6 text-center mx-auto">
                    <h2 class="text-primary mb-3">{{ __('messages.web_home.our_services') }}</h2>
                    <h2 class="mb-4 pb-xl-4">
                        {{ __('messages.web_home.we_offer_different_services_to_improve_your_health') }}
                    </h2>
                </div>
                <div class="our-service">
                    <div class="row justify-content-center">
                        @foreach($frontServices  as $frontService)
                                <div class="col-xl-3 col-lg-4 col-md-6 py-lg-2 card-hover d-flex align-items-stretch" >
                                    <button style="border: none; padding: 0; background-color: transparent;"
                                    data-titleService="{{ \Illuminate\Support\Str::limit($frontService->name, 50) }}"
                                    data-ContentService="{{ \Illuminate\Support\Str::limit($frontService->short_description, 50) }}"
                                     type="button" class="btn btn-primary show-modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <div class="card p-c-4 my-lg-2 mx-lg-1 my-md-3 my-2 flex-fill">
                                            <img src="{{ isset($frontService->icon_url) ? $frontService->icon_url : asset('web_front/images/services/medicine.png') }}"
                                                class="card-img-top img-wh mx-auto " alt="Cardiology">
                                            <div class="card-body p-0 text-center flex-column">
                                                <h4 class="card-title mt-4">{{ \Illuminate\Support\Str::limit($frontService->name, 50) }}</h4>
                                                <p class="card-text">{{ \Illuminate\Support\Str::limit($frontService->short_description, 50) }}</p>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
  
  <!-- Modal -->
  {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #00AAE7;">
            <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Modal title</h5>
            <button type="button" style="margin-left: 0; background-color: white;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
      </div>
    </div>
  </div> --}}
        <!-- end service-section -->

        <!-- start quality-section -->
        <section class="quality-section p-t-120 p-b-200">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="quality-desc mt-lg-4 text-lg-start text-center">
                            <h6 class="text-primary pb-2" @if(app()->getLocale() == 'ar') style="text-align: right;" @endif>
                                {{ \Illuminate\Support\Str::limit($frontSetting['home_page_certified_doctor_text'], 64) }}
                            </h6>
                            <h2 class="mb-3" @if(app()->getLocale() == 'ar') style="text-align: right;" @endif>
                                {{ \Illuminate\Support\Str::limit($frontSetting['home_page_certified_doctor_title'], 64) }}
                            </h2>
                            <p @if(app()->getLocale() == 'ar') style="text-align: right;" @endif>
                                {{ $frontSetting['home_page_certified_doctor_description'] }}
                            </p>
                            {{-- <a href="{{ route('appointment') }}"
                               class="btn btn-primary mt-lg-4 mb-lg-0 mb-4">{{ __('messages.web_home.book_appointment') }}</a> --}}
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 position-relative">
                        <div class="certified-doctor  text-end">
                            <img src="{{ $frontSetting['home_page_certified_doctor_image'] }}" alt="Certifired Doctor"
                                 class="img-fluid">
                        </div>
                        <div class="doctor-desc position-absolute br-2 d-flex align-items-center">
                            <div class="icon-box br-5 me-md-4 me-2 text-primary bg-white d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-certificate fs-5"></i>
                            </div>
                            <div></div>
                            <div class="desc">
                                <h4 class="text-white">
                                    {{ \Illuminate\Support\Str::limit($frontSetting['home_page_certified_box_title'], 16) }}
                                </h4>
                                {{-- <p class="text-white fs-14 mb-0">
                                    {{ \Illuminate\Support\Str::limit($frontSetting['home_page_certified_box_description'], 44) }}
                                </p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end quality-section -->

        <!-- start professional-doctors section -->
        <section class="professional-doctors-section shape-rectangle position-relative" style="margin-bottom: 100px;">
            <div class="container">
                <div class="col-lg-6 text-center mx-auto">
                    <h2 class="text-primary mb-3">{{ __('messages.web_home.professional_doctors') }}</h2>
                    <h2 class="mb-5 pb-xl-3">{{ __('messages.web_home.we_are_experienced_healthcare_professionals') }}</h2>
                </div>

                <div class="slick-slider">
                    @foreach($doctorAppointments as $doctor)
                        <div class="slide text-center">
                            <img src="{{ $doctor->doctorUser->image_url }}" alt="Doctor" class="mx-auto">
                            <div class="slide-desc mt-4 text-center">
                                <h6>{{ \Illuminate\Support\Str::limit($doctor->doctorUser->full_name, 23) }}</h6>
                                <p>{{ \Illuminate\Support\Str::limit($doctor->doctorUser->qualification, 45) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end professional-doctors section -->

        <!-- start testimonial-section -->
        {{-- <section class="testimonial-section p-t-120">
            <div class="container">
                <div class="col-lg-6 text-center mx-auto">
                    <h6 class="text-primary pb-2">{{ __('messages.web_home.our_testimonials') }}</h6>
                    <h2 class="mb-4 pb-xl-4">
                        {{ __('messages.web_home.what_our_patient_say_about_medical_treatments') }}
                    </h2>
                </div>
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="testimonial-slider">
                            @foreach($testimonials as $testimonial)
                                <div class="justify-content-center">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 col-sm-4 position-relative">
                                            <div class="testimonial-img">
                                                <img src="{{ $testimonial->document_url }}" alt="testimonial image"
                                                     class="img-fluid">
                                            </div>
                                            <div class="quote-img br-5 position-absolute">
                                                <img src="web_front/images/testimonials/quote.png" alt="quote">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 position-relative pb-md-5 mb-md-3">
                                            <div class="testimonial-desc ps-lg-5 pt-sm-0 pt-4">
                                                <h3>{{ \Illuminate\Support\Str::limit($testimonial->name, 46) }}</h3>
                                                <p class="mb-0">
                                                    {{ $testimonial->description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <!-- end testimonial-section -->
        <div class="testimonial-slider" style="display: none">
                           
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on("click", '.show-modal', function() {
            // var row = $(this).closest("tr");
            // var id = $(this).data("id");
            // var title = row.find("td:eq(0)").text();
            // var description = row.find("td:eq(1)").text();
            const titleService = $(this).data('titleService');
            const ContentService = $(this).data('ContentService');
            console.log(titleService);
            console.log(ContentService);
            // $("#categoryId-input").val(id);
            // $("#name-input").val(title);
            // $("#price-input").val(description);
        });
    </script>
@endsection
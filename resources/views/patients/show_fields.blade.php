<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xxl-5 col-12">
                    <div class="d-sm-flex align-items-center mb-5 mb-xxl-0 text-center text-sm-start">
                        <div class="image image-circle image-small">
                            <img src="{{ !empty($data->patientUser->image_url) ? $data->patientUser->image_url : '' }}" alt="image"/>
                        </div>
                        <div class="ms-0 ms-md-10 mt-5 mt-sm-0">
                            <h2><a href="javascript:void(0)"
                                   class="text-decoration-none">{{ !empty($data->patientUser->full_name) ? $data->patientUser->full_name : '' }}</a>
                            </h2>
                            
                            <a href="mailto:{{ !empty($data->patientUser->email) ? $data->patientUser->email : '' }}"
                               class="text-gray-600 text-decoration-none fs-5">
                                {{ !empty($data->patientUser->email) ? $data->patientUser->email : '' }}
                            </a>
                            <span class="d-flex align-items-center me-2 mb-2 mt-2">
                                @if(!empty($data->address->address1) || !empty($data->address->address2) || !empty($data->address->city) || !empty($data->address->zip))
                                    <span><i class="fas fa-location"></i></span>
                                @endif
                                <span class="p-2">
                                    {{ !empty($data->address->address1) ? $data->address->address1 : '' }}{{ !empty($data->address->address2) ? !empty($data->address->address1) ? ',' : '' : '' }}
                                    {{ empty($data->address->address1) || !empty($data->address->address2)  ? !empty($data->address->address2) ? $data->address->address2 : '' : '' }}
                                    {{ empty($data->address->address1) && empty($data->address->address2) ? '' : '' }}{{ !empty($data->address->city) ? ','.$data->address->city : '' }}{{ !empty($data->address->zip) ? ','.$data->address->zip : '' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-12">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->cases) ? $data->cases->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_cases')}}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->admissions) ? $data->admissions->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_admissions')}}</h3>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12 mb-6 mb-md-0">
                            <div class="border rounded-10 p-5 h-100">
                                <h2 class="text-primary mb-3">{{!empty($data->appointments) ? $data->appointments->count() : 0}}</h2>
                                <h3 class="fs-5 fw-light text-gray-600 mb-0">{{__('messages.patient.total_appointments')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-7 overflow-hidden">
        <ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap">
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link active p-0" data-bs-toggle="tab"
                   href="#PatientOverview">{{ __('messages.overview') }}</a>
            </li> --}}
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientCases">{{ __('messages.cases') }}</a>
            </li> --}}
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAdmissions">{{ __('messages.patient_admissions') }}</a>
            </li> --}}
            
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientDocument">{{ __('messages.documents') }}</a>
            </li> --}}
            @if (Auth::user()->hasRole('Doctor'))
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link active p-0" data-bs-toggle="tab"
                    href="#showPatientHistory">{{ __('messages.prescription.medical_history') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                    href="#showPatientRochet">{{ __('messages.prescription.medical_rochet') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                    href="#showPatientOrderLab">{{ __('messages.prescription.order_lab') }}</a>
                </li>
                <li class="nav-item position-relative me-7 mb-3">
                    <a class="nav-link p-0" data-bs-toggle="tab"
                       href="#showPatientAppointments">{{ __('messages.appointments') }}</a>
                </li>
            @endif

            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientBills">{{ __('messages.bills') }}</a>
            </li> --}}
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientInvoices">{{ __('messages.invoices') }}</a>
            </li> --}}
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientAdvancedPayments">{{ __('messages.advanced_payments') }}</a>
            </li> --}}
            
            {{-- <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0" data-bs-toggle="tab"
                   href="#showPatientVaccinated">{{ __('messages.vaccinations') }}</a>
            </li> --}}
        </ul>
    </div>
</div>
<div class="tab-content" id="myPatientTabContent">
    {{-- <div class="tab-pane fade show active" id="PatientOverview" role="tabpanel">
        <div class="card mb-5 mb-xl-10">
            <div>
                <div class="card-body  border-top p-9">
                    <div class="row">
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.phone') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->phone) ? $data->patientUser->phone :__('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.gender') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->phone) ? ($data->patientUser->gender != 1) ? __('messages.user.male') : __('messages.user.female') : '' }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.blood_group') }}</label>
                            <p>
                                @if(!empty($data->patientUser->blood_group))
                                    <span
                                            class="badge fs-6 bg-light-{{ !empty($data->patientUser->blood_group) ? 'success' : 'danger'  }}"> {{ $data->patientUser->blood_group }} </span>
                                @else
                                    <span
                                            class="fs-5 text-gray-800">{{ __('messages.common.n/a')}}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.user.dob') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->dob) ? \Carbon\Carbon::parse($data->patientUser->dob)->translatedFormat('jS M, Y') : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.common.created_at') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->created_at) ? $data->patientUser->created_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6 d-flex flex-column">
                            <label for="name"
                                   class="pb-2 fs-5 text-gray-600">{{ __('messages.common.updated_at') }}</label>
                            <p>
                                <span class="fs-5 text-gray-800">{{ !empty($data->patientUser->updated_at) ? $data->patientUser->updated_at->diffForHumans() : __('messages.common.n/a') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="tab-pane fade" id="showPatientCases" role="tabpanel">
        <livewire:patient-case-table patientId="{{ $data->id }}"/>
    </div> --}}
    {{-- <div class="tab-pane fade" id="showPatientAdmissions" role="tabpanel">
        <livewire:patient-admission-detail-table patientId="{{ $data->id }}"/>
    </div> --}}
    
    @if (Auth::user()->hasRole('Doctor'))   
        <div class="tab-pane show active     fade" id="showPatientHistory" role="tabpanel">
            {{-- <livewire:patient-appoinment-detail-table patientId="{{ $data->id }}"/> --}}
            <div class="card">
                <div class="card-body">
                    <div class="my-3">
                        <div class="form-group">
                            <a id="Add_History_by_text" class="btn btn-primary">{{ __('messages.Add_History_by_text') }}</a>
                            <a href="{{ route('patient.history.board', $data->id) }}" class="btn btn-primary">{{ __('messages.Add_History_by_board') }}</a>
                            <a id="back_history" class="btn btn-primary">{{ __('messages.common.back') }}</a>
                        </div>
                    </div>
                    <div class="row mt-3" id="section_image_for_history">
                        @forelse ($data->documents as $item)
                            <div class="col-md-4 containerImage" id="history-image">
                                <img src="{{ asset(str_replace("http://localhost", "", $item->document_url)) }}" alt="Report 1" class="img-fluid mb-3 zoomE" style="width: 300px; height: 300px; cursor: pointer;">
                                {{-- <a class="btn btn-danger delete delete-image" image-name=""><i class="fa-solid fa-trash"></i></a> --}}
                            </div>
                        @empty
                        @endforelse

                        @foreach($data->appointments as $item)
                            <div class="col-md-4 containerImage" id="history-image">
                                <img src="{{ asset($item->image_from_old_system) }}" alt="Report 1" class="img-fluid mb-3 zoomE" style="width: 300px; height: 300px; cursor: pointer;">
                                <a class="btn btn-danger delete delete-image" image-name="{{ $item->image_from_old_system }}"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        @endforeach

                        @forelse ($historyBoard as $item)
                            <div class="col-md-4 containerImage" id="history-image">
                                <img src="{{ asset($item->link) }}" alt="Report 1" class="img-fluid mb-3 zoomE" style="width: 300px; height: 300px; cursor: pointer;">
                                <a class="btn btn-danger delete delete-image" image-name="{{ $item->link }}"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        @empty
                            @if (!$data->documents)
                                <div class="col-md-4">
                                    <img src="https://via.placeholder.com/300" alt="Report 1" class="img-fluid mb-3">
                                </div>
                            @endif
                        @endforelse
                    </div>

                    <div id="section_text_for_history">
                        <h3>{{ __('messages.Add_History_by_text') }}</h3>
                        <div id="alert_save_text_history"></div>
                        <form  action="{{ route('history.text.save') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="number" name="patient_id" value="{{ $data->id }}" hidden>
                            {{-- <input type="number" name="doctor_id" value="{{ auth()->user()->doctor->id }}" hidden> --}}
                            <div class="d-flex mb-2 p-4 form-floating card">
                                <textarea name="history" placeholder="" class="form-control"
                                    id="section_text_for_history_editor">{!! $textHistoryAndRochet->history ?? '' !!}</textarea>
                                <button class="btn btn-primary ms-2 mt-3 p-2" style="font-size: 20px;" name="save_history">{{ __('messages.common.save') }}</button>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="showPatientRochet" role="tabpanel">
            {{-- <livewire:patient-appoinment-detail-table patientId="{{ $data->id }}"/> --}}
            <div class="card">
                <div class="card-body">
                    <div class="my-3">
                        <div class="form-group">
                            <a id="Add_rochet_by_text" class="btn btn-primary">{{ __('messages.Add_Rochet_by_text') }}</a>
                            <a href="{{ route('patient.rochet.board', $data->id) }}" class="btn btn-primary">{{ __('messages.Add_Rochet_by_board') }}</a>
                            <a id="back_rochet" class="btn btn-primary">{{ __('messages.common.back') }}</a>
                        </div>
                    </div>
                    <div class="row mt-3" id="section_image_for_rochet">
                        
                        @forelse ($rochetBoard as $item)
                            <div class="col-md-4 containerImage" id="prescription-image">
                                <img src="{{ asset($item->link) }}" alt="Report 1" class="img-fluid mb-3 zoomE" style="width: 300px; height: 300px; cursor: pointer;">
                                <a class="btn btn-danger delete delete-image" image-name="{{ $item->link }}"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        @empty
                            <div class="col-md-4">
                                <img src="https://via.placeholder.com/300" alt="Report 1" class="img-fluid mb-3">
                            </div>
                        @endforelse
                    </div>
                    <div id="section_text_for_rochet">
                        <h3>{{ __('messages.Add_Rochet_by_text') }}</h3>
                        <div id="alert_save_text_rochet"></div>
                        <form action="{{ route('rochet.text.save') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="number" name="patient_id" value="{{ $data->id }}" hidden>
                            <div class="d-flex mb-2 p-4 form-floating card">
                                <textarea name="rochet" placeholder="" class="form-control"
                                    id="section_text_for_rochet_editor">{!! $textHistoryAndRochet->rochet ?? '' !!}</textarea>
                                <input type="submit" name="textRochet" class="btn btn-primary ms-2 mt-3 p-2" value="{{ __('messages.common.save') }}" style="font-size: 20px;">
                            </div>
                        </form>  
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="showPatientOrderLab" role="tabpanel">
            {{-- <livewire:patient-appoinment-detail-table patientId="{{ $data->id }}"/> --}}
            <a href="{{ route('patients.create.order', $data->id) }}" class="btn btn-primary mb-3">{{ __('messages.prescription.create_order') }}</a>
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
                            <span>{{ __('messages.common.status') }}</span>
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

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                    @if ($item->status == '0')
                                        {{ __('messages.common.cancel') }}
                                    @elseif ($item->status == '1')
                                        {{ __('messages.appointment.pending') }}
                                    @elseif ($item->status == '2')
                                        {{ __('messages.appointment.completed') }}
                                    @endif
                                </td>

                                <td class="" wire:key="cell-0-2-WpskoqwzxJ5BdNxsPOsu">
                                     <a href="{{ route('patients.show.order', $item->id) }}" class="btn px-1 text-primary fs-3 ps-0 edit-btn">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>   
                                    @if ($item->status == '1')
                                        <a href="{{ route('patients.edit.order', $item->id) }}" title="{{__('messages.common.edit') }}"
                                            class="btn px-1 text-primary fs-3 ps-0 edit-btn">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="tab-pane fade" id="showPatientAppointments" role="tabpanel">
        <livewire:patient-appoinment-detail-table patientId="{{ $data->id }}"/>
    </div>
    {{-- <div class="tab-pane fade" id="showPatientBills" role="tabpanel">
        <livewire:patient-bill-detail-table patientId="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientInvoices" role="tabpanel">
        <livewire:patient-invoice-detail-table patientId="{{ $data->id}}"/>
    </div>
    <div class="tab-pane fade" id="showPatientAdvancedPayments" role="tabpanel">
        <livewire:patient-advance-payment-detail-table patient-id="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientDocument" role="tabpanel">
        <livewire:patient-document-table patient-id="{{ $data->id }}"/>
    </div>
    <div class="tab-pane fade" id="showPatientVaccinated" role="tabpanel">
        <livewire:patient-vaccination-detail-table patient-id="{{ $data->id }}"/>
    </div> --}}
</div>

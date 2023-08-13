<?php

namespace App\Http\Controllers;

use App\Exports\AppointmentExport;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\CreateNewAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use App\Repositories\DocumentRepository;
use Auth;
use DB;
use Exception;
use Hash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;
use Carbon\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;
use Barryvdh\DomPDF\Facade as PDF;

/**
 * Class AppointmentController
 */
class AppointmentController extends AppBaseController
{
    /** @var AppointmentRepository */
    private $appointmentRepository;

     /** @var DocumentRepository */
     private $documentRepository;

    public function __construct(AppointmentRepository $appointmentRepo, DocumentRepository $documentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
        $this->documentRepository = $documentRepo;
    }

    /**
     * Display a listing of the appointment.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $statusArr = Appointment::STATUS_ARR;
        return view('appointments.index', compact('statusArr'));
    }

    public function todayAppointments(Request $request) {
        $doctor_id = $request->doctor_id ?? null;
        $first_name = $request->first_name ?? '';
        $middle_name = $request->middle_name ?? '';
        $last_name = $request->last_name ?? '';

        if (Auth::user()->hasRole('Doctor')) {
            if ($first_name || $middle_name || $last_name) {
                $appointments = Appointment::whereHas('patient.user', function ($query) use ($first_name, $middle_name, $last_name) {
                    $query->where('first_name', 'like', '%'.$first_name.'%')->where('middle_name', 'like', '%'.$middle_name.'%')->where('last_name', 'like', '%'.$last_name.'%');
                })->where('doctor_id', auth()->user()->doctor->id)->whereDate('created_at', Carbon::today())->where('is_completed', '!=', 3)->orderBy('created_at', 'desc')->get();    
            } else {
                $appointments = Appointment::with('patient', 'doctor')->where('doctor_id', auth()->user()->doctor->id)->whereDate('created_at', Carbon::today())->where('is_completed', '!=', 3)->orderBy('created_at', 'desc')->get();
            }
        } else {
            if ($doctor_id || $first_name || $middle_name || $last_name) {
                $appointments = Appointment::whereHas('patient.user', function ($query) use ($first_name, $middle_name, $last_name) {
                    $query->where('first_name', 'like', '%'.$first_name.'%')->where('middle_name', 'like', '%'.$middle_name.'%')->where('last_name', 'like', '%'.$last_name.'%');
                })->where('doctor_id', $doctor_id)->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();    
            } else {
                $appointments = Appointment::with('patient', 'doctor')->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
            }
        }
       
        $doctors = Doctor::get();
        return view('appointments.todayAppointments', compact('appointments', 'doctors'));
    }

    public function todayAppointmentsPDF() {
        $appointments = Appointment::whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
        if (Auth::user()->hasRole('Doctor')) {
            $appointments = Appointment::where('doctor_id', auth()->user()->doctor->id)->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get();
        }

        $file_name = 'daily_appointments.pdf';

        if (file_exists(public_path() . '/' . $file_name )) {
            unlink(public_path() . '/' . $file_name);
        }
        // $pdf = \PDF::loadView('appointments.today_appointments_pdf',compact('appointments'))->save(public_path($file_name)); 
        $pdf = \PDF::loadView('appointments.today_appointments_pdf',compact('appointments')); 
        // $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
    
        return $pdf->stream('document.pdf');
        // dd('s');
       
        // return response()->file(
        //     public_path($file_name)
        // );

        // return view('appointments.today_appointments_pdf', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return Factory|View
     */
    public function create()
    {
        $patients = $this->appointmentRepository->getPatients();
        $departments = $this->appointmentRepository->getDoctorDepartments();
        $statusArr = Appointment::STATUS_PENDING;
        $services = Service::all();
        return view('appointments.create', compact('patients', 'departments', 'statusArr', 'services'));
    }

    public function createNewAppointment() {
        $patients = $this->appointmentRepository->getPatients();
        $departments = $this->appointmentRepository->getDoctorDepartments();
        $statusArr = Appointment::STATUS_PENDING;
        $bloodGroup = getBloodGroups();
        $services = Service::all();
        $doctors = Doctor::get();

        return view('appointments.create_new_appointment', compact('bloodGroup', 'patients', 'departments', 'statusArr', 'services', 'doctors'));
    }

    public function storeNewAppointment(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            // 'department_id' => 'required',
            // 'doctor_id' => 'required',
            // 'time' => 'required',
            'fees' => 'required',
            'services_id' => 'required',
        ]);

        
        if ($validator->fails()) {
            return $this->sendError(__('messages.web_menu.appointment').' '.$validator->messages()->first());
        } else {

            $serial_number_for_user = User::where('owner_type', 'App\Models\Patient')->first();
            if ($serial_number_for_user == null) {
                $serial_number_for_user = 1;
                // $serial_number_for_user = str_pad($serial_number_for_user, 8, '0', STR_PAD_LEFT);
                $serial_number_for_user = '00000001';
            } else {
                $serial_number_for_user = User::where('owner_type', 'App\Models\Patient')->latest()->first()->serial_number;
                if ($serial_number_for_user == null) {
                    $serial_number_for_user = '00000001';
                } else {
                    $serial_number_for_user = number_format($serial_number_for_user); 
                    $serial_number_for_user = ltrim($serial_number_for_user, '0');
                    $serial_number_for_user += 1 ;
                    $serial_number_for_user = str_pad($serial_number_for_user, 8, '0', STR_PAD_LEFT);
                }
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'age' => $request->dob,
                'national_number' => $request->national_number,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'department_id' => 3,
                'email' =>  mt_rand() . '_' . mt_rand() . '@gmail.com',
                'password' => Hash::make('123456789'),
                'status' => true,
                'serial_number' => $serial_number_for_user,
                'owner_type' => 'App\Models\Patient',
                'owner_id' => DB::table('patients')->orderBy('created_at', 'desc')->first()->id + 1
            ]);
    
            $patient = Patient::create([
                'user_id' => $user->id
            ]);

            $date = Carbon::today();
            $max_number = Appointment::where('doctor_id', $request->doctor_id)->where('created_at', '>=', $date)->max('counter');
            if ($max_number == null) {
                $max_number = 1;
            } else {
                $max_number += 1 ;
            }         

            // $serial_number = Appointment::latest()->first()->serial_number;
            $serial_number = Appointment::first();
            if ($serial_number == null) {
                $serial_number = 1;
                // $serial_number = str_pad($serial_number, 8, '0', STR_PAD_LEFT);
                $serial_number = '00000001';
            } else {
                $serial_number = Appointment::latest()->first()->serial_number;
                $serial_number = number_format($serial_number); 
                $serial_number = ltrim($serial_number, '0');
                $serial_number += 1 ;
                $serial_number = str_pad($serial_number, 8, '0', STR_PAD_LEFT);
            }

            $doc = Doctor::findOrFail($request->doctor_id);
            $opd_date = Carbon::now();

            $appointment = Appointment::create([
                'serial_number' => strval($serial_number),
                'counter' => $max_number,
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'department_id' => $doc->department->id,
                'service_id' => $request->services_id,
                'user_entered' => auth()->user()->id,
                'opd_date' => $opd_date,
                'is_completed' => 0,
                'problem' => $request->problem,
                'fees' => $request->fees
            ]);

            
            $input = $request->all();
            // $input['opd_date'] = $input['opd_date'].$input['time'];
            // $input['opd_date'] = $input[$opd_date];
            $input['is_completed'] = 0;
            $input['patient_id'] = $patient->id;
            $input['user_id'] = $user->id;
            $input['appointment_id'] = $appointment->id;
            $this->appointmentRepository->createNotification($input);

            // return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
            return redirect()->route('appointments.print');
        }

       
    }

    public function printAppointment() {
       $appointment = Appointment::latest()->first();
       return view('appointments.print_appointment', compact('appointment'));
    }

    public function printAppointmentById($id) {
       $appointment = Appointment::findOrFail($id);
       return view('appointments.print_appointment', compact('appointment'));
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  CreateAppointmentRequest  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['opd_date'] = $input['opd_date'].$input['time'];
        $input['is_completed'] = isset($input['status']) ? Appointment::STATUS_COMPLETED : Appointment::STATUS_PENDING;
        if ($request->user()->hasRole('Patient')) {
            $input['patient_id'] = $request->user()->owner_id;
        }
        $date = Carbon::today();
        $max_number = Appointment::where('doctor_id', $request->doctor_id)->where('created_at', '>=', $date)->max('counter');
        if ($max_number == null) {
            $max_number = 1;
        } else {
            $max_number += 1 ;
        }

        // $serial_number = Appointment::latest()->first()->serial_number;
        $serial_number = Appointment::first();
        if ($serial_number == null) {
            $serial_number = 1;
            $serial_number = str_pad($serial_number, 8, '0', STR_PAD_LEFT);
            // $serial_number = '00000001';
        } else {
            $serial_number = Appointment::latest()->first()->serial_number;
            $serial_number = number_format($serial_number);
            $serial_number = ltrim($serial_number, '0');
            $serial_number += 1 ;
            $serial_number = str_pad($serial_number, 8, '0', STR_PAD_LEFT);
        }

        $input['serial_number'] = strval($serial_number);
        $input['counter'] = $max_number;
        $input['service_id'] = $request->services_id;                    
        $input['user_entered'] = auth()->user()->id;                    
        $input['is_completed'] = 0;                    
        $this->appointmentRepository->create($input);
        $this->appointmentRepository->createNotification($input);

        return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
    }


    public function oldPatientSearch(Request $request) {
        $first_name = $request->first_name ?? '';
        $middle_name = $request->middle_name ?? '';
        $last_name = $request->last_name ?? '';
        $phone = $request->phone ?? '';
        $file_number = $request->file_number ?? '';

        if ($file_number) {
            $file_number = ltrim($file_number, '0');
            $file_number = str_pad($file_number, 8, '0', STR_PAD_LEFT);
        }
        $patients = array();
        if ($first_name || $middle_name || $last_name || $phone || $file_number) {
            // $patients = User::where('first_name', 'like', '%'.$first_name.'%')->where('middle_name', 'like', '%'.$middle_name.'%')->where('last_name', 'like', '%'.$last_name.'%')->where('phone', 'like', '%'.$phone.'%')->where('serial_number', 'like', '%'.$file_number.'%')->get();   
            $patients = User::where('owner_type', 'App\Models\Patient')
            ->when($first_name, function ($q) use ($first_name) {
                return $q->where('first_name', 'like', '%'.$first_name.'%');
            })->when($middle_name, function ($q) use ($middle_name) {
                return $q->where('middle_name', 'like', '%'.$middle_name.'%');
            })->when($last_name, function ($q) use ($last_name) {
                return $q->where('last_name', 'like', '%'.$last_name.'%');
            })->when($phone, function ($q) use ($phone) {
                return $q->where('phone', 'like', '%'.$phone.'%');
            })->when($file_number, function ($q) use ($file_number) {
                return $q->where('serial_number', 'like', '%'.$file_number.'%');
            })
            ->get(); 

            if (count($patients) == 0) {
                return redirect()->back()->with('error', __('messages.appointment.no_patients_found'));
            }
        }
        
        return view('appointments.old_patient_search', compact('patients'));
    }

    public function oldPatientSearchCreate($id) {
        $patient = Patient::where('user_id', $id)->first();
        $doctors = Doctor::get();
        $services = Service::get();

        return view('appointments.old_patient_create', compact('patient', 'doctors', 'services'));
    }

    public function oldPatientSearchStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'fees' => 'required',
            'service_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', __('messages.web_menu.appointment').' '.$validator->messages()->first());
        } else {
            $serial_number = Appointment::first();
            if ($serial_number == null) {
                $serial_number = 1;
                $serial_number = '00000001';
            } else {
                $serial_number = Appointment::latest()->first()->serial_number;
                $serial_number = number_format($serial_number); 
                $serial_number = ltrim($serial_number, '0');
                $serial_number += 1 ;
                $serial_number = str_pad($serial_number, 8, '0', STR_PAD_LEFT);
            }

            $date = Carbon::today();
            $max_number = Appointment::where('doctor_id', $request->doctor_id)->where('created_at', '>=', $date)->max('counter');
            if ($max_number == null) {
                $max_number = 1;
            } else {
                $max_number += 1 ;
            }
            
            $appointment = Appointment::create([
                'serial_number' => strval($serial_number),
                'counter' => $max_number,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'department_id' => Doctor::find($request->doctor_id)->department->id,
                'service_id' => $request->service_id,
                'user_entered' => auth()->user()->id,
                'opd_date' => Carbon::today(),
                'is_completed' => 0,
                'problem' => $request->problem,
                'fees' => $request->fees
            ]);

            return redirect()->route('today.appointments')->with('success', __('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
        }
    }


    /**
     * Display the specified appointment.
     *
     * @param  Appointment  $appointment
     * @return Factory|View|RedirectResponsex
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.show')->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @param  Appointment  $appointment
     * @return RedirectResponse|Redirector|View
     */
    public function edit(Appointment $appointment)
    {
        // dd($appointment->documents[0]->document_url);
        // dd(Str::replaceFirst($appointment->documents[0]->document_url, 'localhost', '127.0.0.1:8000', 0    ));
        // $text = $appointment->documents[0]->document_url;
        // $replacement = "http://127.0.0.1:8000";

        // $targetText = "http://localhost";

        // $newText = str_replace("http://localhost", "http://127.0.0.1:8000", $appointment->documents[0]->document_url);

        // dd('s');


        $patients = $this->appointmentRepository->getPatients();
        // $doctors = $this->appointmentRepository->getDoctors($appointment->department_id);
        $doctors = Doctor::get();
        $departments = $this->appointmentRepository->getDoctorDepartments();
        $statusArr = $appointment->is_completed;
        $services = Service::all();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments', 'statusArr', 'services'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  Appointment  $appointment
     * @param  UpdateAppointmentRequest  $request
     * @return JsonResponse
     */
    public function update(Appointment $appointment, Request $request)
    {
        $age = $request->dob;                    
        $input = $request->except('dob');
        // $input = $request->all();
        $input['age'] = $age;
        // $input['opd_date'] = $input['opd_date'].$input['time'];
        // $input['is_completed'] = isset($input['status']) ? Appointment::STATUS_COMPLETED : Appointment::STATUS_PENDING;
        if ($request->user()->hasRole('Patient')) {
            $input['patient_id'] = $request->user()->owner_id;
        }
        $input['service_id'] = $request->services_id;                    
        $appointment = $this->appointmentRepository->update($input, $appointment->id);
        $appointment->patient->user->update($input);
        // return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.updated_successfully'));
        return redirect()->back()->with('success', __('messages.web_menu.appointment').' '.__('messages.common.updated_successfully'));
    }

    public function addFile(Request $request) {
        // dd($request->all());
        $docType = DocumentType::where('name', 'history paper')->first();
        if (!$docType) {
            $docType = DocumentType::create(['name' => 'history paper']);
        }   

        try {
            // $doc = Document::create([
            //     'title' => 'history paper',
            //     'document_type_id' => $docType->id,
            //     'patient_id' => $request->patient_id,
            //     'appointment_id' => $request->appointment_id,
            //     'uploaded_by' => Auth::id(),
            // ]);

            $input = $request->all();
            $input['document_type_id'] = $docType->id;
            $input['title'] = 'history paper for patient';

            $this->documentRepository->store($input);
            return redirect()->back()->with('success', __('messages.document.document').' '.__('messages.common.saved_successfully'));

        } catch (\Exception $e) {
        
            return redirect()->back()->with('error', __('messages.document.document').' '.__('messages.incomes.document_error'));
        }
    
      
        // return $this->sendSuccess(__('messages.document.document').' '.__('messages.common.saved_successfully'));
    
        // $media = Media::create([
        //     'model_type' => Document::class,
        //     'model_id' => $doc->id,
        //     'collection_name' => 'documents',
        //     'name' => 'test',
        //     'file_name' => 'test',
        //     'mime_type' => 'image/png',
        //     'disk' => 'public',
        //     'manipulations' => [],
        //     'custom_properties' => [],
        //     'responsive_images' => [],
        //     'order_column' => 1,
        //     'conversions_disk' => 'public',
        //     'uuid' => 'b64053s4-3df8-4fsf-87df-d5f25s6aa3dd',
        //     'generated_conversions' => []
        // ]);
    }

    /**
     * Remove the specified appointment from storage.
     *
     * @param  Appointment  $appointment
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        if (getLoggedinPatient() && $appointment->patient_id != getLoggedInUser()->owner_id) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $this->appointmentRepository->delete($appointment->id);

            return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.deleted_successfully'));
        }
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getDoctors(Request $request)
    {
        $id = $request->get('id');

        $doctors = $this->appointmentRepository->getDoctors($id);

        return $this->sendResponse($doctors, 'Retrieved successfully');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getBookingSlot(Request $request)
    {
        $inputs = $request->all();
        $data = $this->appointmentRepository->getBookingSlot($inputs);

        return $this->sendResponse($data, 'Retrieved successfully');
    }

    /**
     * @return BinaryFileResponse
     */
    public function appointmentExport()
    {
        return Excel::download(new AppointmentExport, 'appointments-'.time().'.xlsx');
    }

    /**
     * @param  Appointment  $appointment
     * @return JsonResponse
     */
    public function status(Appointment $appointment): JsonResponse
    {
        if (getLoggedinDoctor() && $appointment->doctor_id != getLoggedInUser()->owner_id) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $isCompleted = ! $appointment->is_completed;
            $appointment->update(['is_completed' => $isCompleted]);
            return $this->sendSuccess(__('messages.common.status_updated_successfully'));
        }
    }

    /**
     * @param  Appointment  $appointment
     * @return JsonResponse
     */
    public function cancelAppointment(Appointment $appointment): JsonResponse
    {
        if ((getLoggedinPatient() && $appointment->patient_id != getLoggedInUser()->owner_id) || (getLoggedinDoctor() && $appointment->doctor_id != getLoggedInUser()->owner_id)) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $appointment->update(['is_completed' => Appointment::STATUS_CANCELLED]);

            return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.canceled'));
        }
    }

    public function appointmentCancellation(Request $request)
    {
        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update(['is_completed' => Appointment::STATUS_CANCELLED]);
        $appointment->update(['cancel_reason' => $request->cancel_reason]);
        return redirect()->back()->with('success', __('messages.web_menu.appointment').' '.__('messages.common.canceled'));
    }

    public function AddAppointmentNote(Request $request) {
        $appointment = Appointment::findOrFail($request->id);
        $appointment->update(['problem' => $request->note]);
        return redirect()->back()->with('success', __('messages.web_menu.appointment').' '.__('messages.common.updated_successfully'));
    }
}

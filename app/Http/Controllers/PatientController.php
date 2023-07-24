<?php

namespace App\Http\Controllers;

use App;
use App\Exports\PatientExport;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\AdvancedPayment;
use App\Models\Appointment;
use App\Models\BedAssign;
use App\Models\Bill;
use App\Models\BirthReport;
use App\Models\BoardHistoryAndRochet;
use App\Models\DeathReport;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\InvestigationReport;
use App\Models\Invoice;
use App\Models\IpdPatientDepartment;
use App\Models\labCategory;
use App\Models\OperationReport;
use App\Models\OrderLab;
use App\Models\OrderLabDetails;
use App\Models\Patient;
use App\Models\PatientAdmission;
use App\Models\PatientCase;
use App\Models\Prescription;
use App\Models\TextHistoryAndRochet;
use App\Models\User;
use App\Models\Vaccination;
use App\Repositories\AdvancedPaymentRepository;
use App\Repositories\PatientRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Validator;

class PatientController extends AppBaseController
{
    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Patient.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = Patient::STATUS_ARR;

        return view('patients.index', $data);
    }

    /**
     * Show the form for creating a new Patient.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('patients.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param  CreatePatientRequest  $request
     * @return RedirectResponse|Redirector
     */
    public function store(CreatePatientRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
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

        $input['serial_number'] = $serial_number_for_user;
        $this->patientRepository->store($input);
        $this->patientRepository->createNotification($input);
        Flash::success(__('messages.advanced_payment.patient').' '.__('messages.common.saved_successfully'));

        return redirect(route('patients.index'));
    }

    /**
     * @param  int  $patientId
     * @return Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $patientId)
    {
        $data = $this->patientRepository->getPatientAssociatedData($patientId);
        if (!$data) {
            return view('errors.404');
        }
        if (getLoggedinPatient() && checkRecordAccess($data->id)) {
            return view('errors.404');
        } else {
            $historyPaper = null;
            $historyBoard = null;
            $rochetBoard = null;
            $orderlabs = null;
            $orderlabsPaper = null;
            if (Auth::user()->hasRole('Doctor')) {
                $historyBoard = BoardHistoryAndRochet::where('type', 'historyBoard')->where('doctor_id', auth()->user()->doctor->id)->where('patient_id', $data->id)->get();
                $rochetBoard = BoardHistoryAndRochet::where('type', 'rochetBoard')->where('doctor_id', auth()->user()->doctor->id)->where('patient_id', $data->id)->get();
                $orderlabs = OrderLab::where('doctor_id', auth()->user()->doctor->id)->where('patient_id', $data->id)->orderBy('created_at', 'desc')->get();
            }
            $advancedPaymentRepo = App::make(AdvancedPaymentRepository::class);
            $patients = $advancedPaymentRepo->getPatients();
            $user = Auth::user();
            
            if ($user->hasRole('Doctor')) {
                $vaccinationPatients = getPatientsList($user->owner_id);
            } else {
                $vaccinationPatients = Patient::getActivePatientNames();
                
            }
            $vaccinations = Vaccination::toBase()->pluck('name', 'id')->toArray();
            natcasesort($vaccinations);


            return view('patients.show', compact('data', 'patients', 'vaccinations', 'vaccinationPatients', 'historyBoard', 'rochetBoard', 'orderlabs'));
        }
    }

    /**
     * Show the form for editing the specified Patient.
     *
     * @param  Patient  $patient
     * @return Factory|View
     */
    public function edit(Patient $patient)
    {
//        $user = $patient->patientUser;
        $bloodGroup = getBloodGroups();

        return view('patients.edit', compact('patient', 'bloodGroup'));
    }

    /**
     * @param  Patient  $patient
     * @param  UpdatePatientRequest  $request
     * @return RedirectResponse|Redirector
     */
    public function update(Patient $patient, UpdatePatientRequest $request)
    {
        if ($patient->is_default == 1) {
            Flash::error('This action is not allowed for default record.');

            return redirect(route('patients.index'));
        }

        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $this->patientRepository->update($input, $patient);

        Flash::success(__('messages.advanced_payment.patient').' '.__('messages.common.updated_successfully'));

        return redirect(route('patients.index'));
    }

    /**
     * Remove the specified Patient from storage.
     *
     * @param  Patient  $patient
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Patient $patient)
    {
        if ($patient->is_default == 1) {
            return $this->sendError('This action is not allowed for default record.');
        }

        $patientModels = [
            BirthReport::class, DeathReport::class, InvestigationReport::class, OperationReport::class,
            Appointment::class, BedAssign::class, PatientAdmission::class, PatientCase::class, Bill::class,
            Invoice::class, AdvancedPayment::class, Prescription::class, IpdPatientDepartment::class,
        ];
        $result = canDelete($patientModels, 'patient_id', $patient->id);
        if ($result) {
            return $this->sendError(__('messages.advanced_payment.patient').' '.__('messages.common.cant_be_deleted'));
        }
        $patient->patientUser()->delete();
        $patient->address()->delete();
        $patient->delete();

        return $this->sendSuccess(__('messages.advanced_payment.patient').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $patient = Patient::findOrFail($id);
        $status = ! $patient->patientUser->status;
        $patient->patientUser()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function patientExport()
    {
        return Excel::download(new PatientExport, 'patients-'.time().'.xlsx');
    }

    /**
     * @param $id
     * @return Patient|Builder|Model|object|null
     */
    public function getBirthDate($id)
    {
        return Patient::whereId($id)->with('user')->first();
    }
    

    public function saveTextHistory(Request $request) {
        $textHistoryAndRochet = TextHistoryAndRochet::where('doctor_id', auth()->user()->doctor->id)->where('patient_id', $request->patient_id)->first();
        $patient = Patient::FindOrFail($request->patient_id);
        if ($textHistoryAndRochet == null) {
            $textHistoryAndRochet = TextHistoryAndRochet::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => auth()->user()->doctor->id,
                'history' => $request->history
            ]);        
        } else {
            $textHistoryAndRochet->update([
                'history' => $request->history
            ]);
        }
        Flash::success(__('messages.common.history_saved_successfully'));
        return redirect()->route('patients.show', $patient);
    }

    public function saveTextRochet(Request $request) {
        $textHistoryAndRochet = TextHistoryAndRochet::where('doctor_id', auth()->user()->doctor->id)->where('patient_id', $request->patient_id)->first();
        $patient = Patient::FindOrFail($request->patient_id);
        if ($textHistoryAndRochet == null) {
            $textHistoryAndRochet = TextHistoryAndRochet::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => auth()->user()->doctor->id,
                'rochet' => $request->rochet
            ]);        
        } else {
            $textHistoryAndRochet->update([
                'rochet' => $request->rochet
            ]);
        }
        Flash::success(__('messages.common.rochet_saved_successfully'));
        return redirect()->route('patients.show', $patient);
    }

    public function historyBoard($id) {
        return view('patients.history_board', compact('id'));
    }

    public function historyBoardSave(Request $request) {
        $patient = Patient::findOrFail($request->id);

        $img = $request->link; 
        $image_64 = $img; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
        
        // find substring for replace here eg: data:image/png;base64,
        
        $image = str_replace($replace, '', $image_64); 
        
        $image = str_replace(' ', '+', $image); 
        
        $imageNameWithoutExtension = 'history_' . uniqid();
        $imageName = $imageNameWithoutExtension.'.'.$extension;

        $directory = 'uploads'  . '/' . 'images' . '/' . 'history';
        $filename = '/' . $directory . '/' . $imageName;

        File::put(public_path('uploads/images/history'). '/' . $imageName, base64_decode($image));

        BoardHistoryAndRochet::create([
            'doctor_id' => auth()->user()->doctor->id,
            'patient_id' => $request->id,
            'link' => $filename,
            'type' => 'historyBoard',
        ]);

        // $document_type = DocumentType::where('name', 'history')->first();
        // if (!$document_type) {
            // $document_type = DocumentType::create(['name' => 'history']);
        // }

        // $document = Document::create([
        //     'title' => 'history file',
        //     'document_type_id' => $document_type->id,
        //     'patient_id' => $request->id,
        //     'uploaded_by' => Auth::id()
        // ]);

        // $media = Media::create([
        //     'model_type' => Document::class,
        //     'model_id' => $document->id,
        //     'collection_name' => 'documents',
        //     'name' => $imageNameWithoutExtension,
        //     'file_name' => $imageName,
        //     // 'mime_type' => '',
        //     'disk' => 'public',
        //     'siz' => 5555,
        //     'manipulations' => [],
        //     'custom_properties' => [],
        //     'responsive_images' => [],
        //     // 'order_column' => '',
        //     'conversions_disk' => 'public',
        //     'uuid' => '5555',
        //     'generated_conversions' => [],
        // ]);
        Flash::success(__('messages.common.history_saved_successfully'));
        
        return response()->json([
            'id' => $patient->id
        ]);
    }

    public function rochetBoard($id) {
        return view('patients.rochet_board', compact('id'));
    }

    public function rochetBoardSave(Request $request) {
        $patient = Patient::findOrFail($request->id);

        $img = $request->link; 
        $image_64 = $img; //your base64 encoded data

        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    
        $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
        
        // find substring for replace here eg: data:image/png;base64,
        
        $image = str_replace($replace, '', $image_64); 
        
        $image = str_replace(' ', '+', $image); 
        
        $imageNameWithoutExtension = 'rochet_' . uniqid();
        $imageName = $imageNameWithoutExtension.'.'.$extension;

        $directory = 'uploads'  . '/' . 'images' . '/' . 'rochet';
        $filename = '/' . $directory . '/' . $imageName;

        File::put(public_path('uploads/images/rochet'). '/' . $imageName, base64_decode($image));

        BoardHistoryAndRochet::create([
            'doctor_id' => auth()->user()->doctor->id,
            'patient_id' => $request->id,
            'link' => $filename,
            'type' => 'rochetBoard',
        ]);
        Flash::success(__('messages.common.rochet_saved_successfully'));

        return response()->json([
            'id' => $patient->id
        ]);
    }

    public function destroyImage(Request $request) {
        $image = BoardHistoryAndRochet::where('link', $request->image)->first();
        if ($image) {
            if ($image->link) {
                unlink(public_path().$image->link);
            }
        $image->delete();
        }
        return true;
    }

    public function createOrder($id) {
        $categoryLabs = labCategory::get();
        return view('patients.create_order', compact('categoryLabs', 'id'));
    }

    public function createOrderStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'labs' => 'required',
        ]);

        if ($validator->fails()) {
            Flash::error($validator->messages()->first());
            return redirect()->back();
        } else {
            $order = OrderLab::create([
                'doctor_id' => auth()->user()->doctor->id,
                'patient_id' => $request->patient_id,
                'status' => 1,
                'is_paid' => 0
            ]);

            foreach ($request->labs as $item) {
                $order_details = OrderLabDetails::create([
                    'order_lab_id' => $order->id,
                    'lab_type_id' => $item
                ]);
            }

            Flash::success(__('messages.prescription.success_order'));
            return redirect()->route('patients.show', $request->patient_id);
        }
    }

    public function createOrderShow($id) {
        $order = OrderLab::findOrFail($id);
        $categoryLabs = labCategory::get();
        $listSelectedLabs = [];
        foreach ($order->orderDetails as $item) {
            $listSelectedLabs[] = $item->lab_type_id;
        }
        return view('patients.show_order', compact('order', 'categoryLabs', 'listSelectedLabs'));
    }

    public function createOrderEdit($id) {
        $order = OrderLab::findOrFail($id);
        $categoryLabs = labCategory::get();
        $listSelectedLabs = [];
        foreach ($order->orderDetails as $item) {
            $listSelectedLabs[] = $item->lab_type_id;
        }
        return view('patients.edit_order', compact('order', 'categoryLabs', 'listSelectedLabs'));
    }

    public function updateOrder(Request $request) {
        $order = OrderLab::findOrFail($request->order_id);
        foreach ($order->orderDetails as $item) {
            $item->delete();
        }

        foreach ($request->labs as $item) {
            $order_details = OrderLabDetails::create([
                'order_lab_id' => $request->order_id,
                'lab_type_id' => $item
            ]);
        }
        Flash::success(__('messages.prescription.update_order'));
        return redirect()->back();
    }

}

<?php

namespace App\Http\Controllers;

use App\Exports\LabTechnicianExport;
use App\Http\Requests\CreateLabTechnicianRequest;
use App\Http\Requests\UpdateLabTechnicianRequest;
use App\Models\DocumentType;
use App\Models\EmployeePayroll;
use App\Models\labCategory;
use App\Models\labCategoryAddType;
use App\Models\LabTechnician;
use App\Models\OrderLab;
use App\Repositories\DocumentRepository;
use App\Repositories\LabTechnicianRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;

class LabTechnicianController extends AppBaseController
{
    /** @var LabTechnicianRepository */
    private $labTechnicianRepository;

    /** @var DocumentRepository */
    private $documentRepository;


    public function __construct(LabTechnicianRepository $labTechnicianRepo, DocumentRepository $documentRepo)
    {
        $this->labTechnicianRepository = $labTechnicianRepo;
        $this->documentRepository = $documentRepo;

    }

    /**
     * Display a listing of the LabTechnician.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = LabTechnician::STATUS_ARR;

        return view('lab_technicians.index', $data);
    }

    /**
     * Show the form for creating a new LabTechnician.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('lab_technicians.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created LabTechnician in storage.
     *
     * @param  CreateLabTechnicianRequest  $request
     * @return RedirectResponse|Redirector
     */
    public function store(CreateLabTechnicianRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $labTechnician = $this->labTechnicianRepository->store($input);

        Flash::success(__('messages.lab_technicians').' '.__('messages.common.saved_successfully'));

        return redirect(route('lab-technicians.index'));
    }

    /**
     * Display the specified LabTechnician.
     *
     * @param  LabTechnician  $labTechnician
     * @return Factory|View
     */
    public function show(LabTechnician $labTechnician)
    {
        $payrolls = $labTechnician->payrolls;

        return view('lab_technicians.show', compact('labTechnician', 'payrolls'));
    }

    /**
     * Show the form for editing the specified LabTechnician.
     *
     * @param  LabTechnician  $labTechnician
     * @return Factory|View
     */
    public function edit(LabTechnician $labTechnician)
    {
        $user = $labTechnician->user;
        $bloodGroup = getBloodGroups();

        return view('lab_technicians.edit', compact('labTechnician', 'user', 'bloodGroup'));
    }

    /**
     * Update the specified LabTechnician in storage.
     *
     * @param  LabTechnician  $labTechnician
     * @param  UpdateLabTechnicianRequest  $request
     * @return RedirectResponse|Redirector
     */
    public function update(LabTechnician $labTechnician, UpdateLabTechnicianRequest $request)
    {
        $labTechnician = $this->labTechnicianRepository->update($labTechnician, $request->all());

        Flash::success(__('messages.lab_technicians').' '.__('messages.common.updated_successfully'));

        return redirect(route('lab-technicians.index'));
    }

    /**
     * Remove the specified LabTechnician from storage.
     *
     * @param  LabTechnician  $labTechnician
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(LabTechnician $labTechnician)
    {
        $empPayRollResult = canDeletePayroll(EmployeePayroll::class, 'owner_id', $labTechnician->id, $labTechnician->user->owner_type);
        if ($empPayRollResult) {
            return $this->sendError(__('messages.lab_technicians').' '.__('messages.common.cant_be_deleted'));
        }
        $labTechnician->user()->delete();
        $labTechnician->address()->delete();
        $labTechnician->delete();

        return $this->sendSuccess(__('messages.lab_technicians').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $labTechnician = LabTechnician::findOrFail($id);
        $status = ! $labTechnician->user->status;
        $labTechnician->user()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function labTechnicianExport()
    {
        return Excel::download(new LabTechnicianExport, 'lab-technicians-'.time().'.xlsx');
    }


    public function labCategory() {
        $categories = labCategory::orderBy('created_at', 'desc')->get();
        return view('lab_technicians.lab_category', compact('categories'));
    }

    public function labCategoryStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', __('messages.web_menu.appointment').' '.$validator->messages()->first());
        } else {
            $labCategory = labCategory::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
            return redirect()->back()->with('success', __('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
        }
    }

    public function labCategoryUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', __('messages.web_menu.appointment').' '.$validator->messages()->first());
        } else {
            $category = labCategory::findOrFail($request->id);
            if ($category) {
                $category->update($request->all());
                return redirect()->back()->with('success', __('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
            }
        }
    }

    public function labCategoryDestroy($id) {
        $category = labCategory::findOrFail($id);
        foreach ($category->labs as $item) {
            $item->delete();
        }
        $category->delete();
        return true;
    }

    public function labCategoryAddType($id) {
        $labs = labCategoryAddType::where('category_id', $id)->get();
        return view('lab_technicians.lab_add_type', compact('labs', 'id'));
    }

    public function labCategoryAddTypeStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages()->first());
        } else {
            $labCategoryAddType = labCategoryAddType::create([
                'name' => $request->name,
                'code' => $request->code,
                'price' => $request->price,
                'category_id' => $request->category_id
            ]);
            return redirect()->back()->with('success', __('messages.common.saved_successfully'));
        }
    }

    public function labCategoryAddTypeUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages()->first());
        } else {
            $labCategoryAddType = labCategoryAddType::findOrFail($request->id);
            if ($labCategoryAddType) {
                $labCategoryAddType->update($request->all());
                return redirect()->back()->with('success', __('messages.common.saved_successfully'));
            }
        }
    }

    public function labCategoryAddTypeDestroy($id) {
        $category = labCategoryAddType::findOrFail($id);
        $category->delete();
        return true;
    }

    public function labOrderList() {
        $orderlabs = OrderLab::orderBy('created_at', 'desc')->where('is_paid', 1)->get();

        return view('patients.order_list', compact('orderlabs'));
    }

    public function labOrderRequestList() {
        $orderlabs = OrderLab::orderBy('created_at', 'desc')->get();

        return view('patients.order_request_list', compact('orderlabs'));
    }

    public function labOrderRequestListPaid(Request $request) {
        $order = OrderLab::findOrFail($request->order_lab_id);
        if (intval($request->price_after_discount) < 0) {
            return redirect()->back()->with('error', __('messages.check_value_paid'));
        } else {
            if (intval($request->price_after_discount) <= intval($request->original_price)) {
                $order->update([
                    'original_price' => $request->original_price,
                    'price_after_discount' => $request->price_after_discount,
                    'is_paid' => 1,
                ]);
                return redirect()->back()->with('success', __('messages.paid_successfully'));
            } else {
                return redirect()->back()->with('error', __('messages.paid_error'));
            }
        }
        
    }
    
    public function addFile(Request $request) {
        $order = OrderLab::findOrFail($request->order_lab_id);
        $docType = DocumentType::where('name', 'lab paper')->first();
        if (!$docType) {
            $docType = DocumentType::create(['name' => 'lab paper']);
        }   

        try {
            $input = $request->all();
            $input['document_type_id'] = $docType->id;
            $input['title'] = 'lab paper for patient';

            $this->documentRepository->store($input);
            $order->update(['status' => 2]);
            return redirect()->back()->with('success', __('messages.document.document').' '.__('messages.common.saved_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.document.document').' '.__('messages.incomes.document_error'));
        }
    }

}

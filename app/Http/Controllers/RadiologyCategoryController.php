<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRadiologyCategoryRequest;
use App\Http\Requests\UpdateRadiologyCategoryRequest;
use App\Models\DocumentType;
use App\Models\OrderRadiology;
use App\Models\RadiologyCategory;
use App\Models\radiologyCategoryAddType;
use App\Models\RadiologyTest;
use App\Repositories\RadiologyCategoryRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Validator;
use App\Repositories\DocumentRepository;

class RadiologyCategoryController extends AppBaseController
{
    /** @var RadiologyCategoryRepository */
    private $radiologyCategoryRepository;

    /** @var DocumentRepository */
    private $documentRepository;

    public function __construct(RadiologyCategoryRepository $radiologyCategoryRepo, DocumentRepository $documentRepo)
    {
        $this->radiologyCategoryRepository = $radiologyCategoryRepo;
        $this->documentRepository = $documentRepo;
    }

    /**
     * Display a listing of the RadiologyCategory.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        return view('radiology_categories.index');
    }

    public function radiologyCategoryAddType($id) {
        $radiologies = radiologyCategoryAddType::where('category_id', $id)->get();
        return view('radiology_categories.radiology_add_type', compact('radiologies', 'id'));
    }

    public function radiologyCategoryAddTypeStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages()->first());
        } else {
            $radiologyCategoryAddType = radiologyCategoryAddType::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id
            ]);
            return redirect()->back()->with('success', __('messages.common.saved_successfully'));
        }
    }

    public function radiologyCategoryAddTypeDestroy($id) {
        $category = radiologyCategoryAddType::findOrFail($id);
        $category->delete();
        return true;
    }

    public function radiologyCategoryAddTypeUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->messages()->first());
        } else {
            $radiologyCategoryAddType = radiologyCategoryAddType::findOrFail($request->id);
            if ($radiologyCategoryAddType) {
                $radiologyCategoryAddType->update($request->all());
                return redirect()->back()->with('success', __('messages.common.saved_successfully'));
            } else {
                return redirect()->back();
            }
        }
    }

    public function radiologyOrderList() {
        $ordersRadiology = OrderRadiology::orderBy('created_at', 'desc')->paginate(10);
        return view('radiology_categories.radiologyTestForReceptionist', compact('ordersRadiology'));
    }

    public function addFile(Request $request) {
        $order = OrderRadiology::findOrFail($request->order_radiology_id);

        $docType = DocumentType::where('name', 'radiology paper')->first();
        if (!$docType) {
            $docType = DocumentType::create(['name' => 'radiology paper']);
        }   

        try {
            $input = $request->all();
            $input['document_type_id'] = $docType->id;
            $input['title'] = 'radiology paper for patient';

            $this->documentRepository->store($input);
            $order->update(['status' => 2]);
            return redirect()->back()->with('success', __('messages.document.document').' '.__('messages.common.saved_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.document.document').' '.__('messages.incomes.document_error'));
        }
    }

    /**
     * Store a newly created RadiologyCategory in storage.
     *
     * @param  CreateRadiologyCategoryRequest  $request
     * @return JsonResponse
     */
    public function store(CreateRadiologyCategoryRequest $request)
    {
        $input = $request->all();
        $this->radiologyCategoryRepository->create($input);

        return $this->sendSuccess(__('messages.radiology_category.radiology_categories').' '.__('messages.common.saved_successfully'));
    }

    /**
     * Show the form for editing the specified RadiologyCategory.
     *
     * @param  RadiologyCategory  $radiologyCategory
     * @return JsonResponse
     */
    public function edit(RadiologyCategory $radiologyCategory)
    {
        return $this->sendResponse($radiologyCategory, 'Radiology Category retrieved successfully.');
    }

    /**
     * Update the specified RadiologyCategory in storage.
     *
     * @param  RadiologyCategory  $radiologyCategory
     * @param  UpdateRadiologyCategoryRequest  $request
     * @return JsonResponse
     */
    public function update(RadiologyCategory $radiologyCategory, UpdateRadiologyCategoryRequest $request)
    {
        $input = $request->all();
        $this->radiologyCategoryRepository->update($input, $radiologyCategory->id);

        return $this->sendSuccess(__('messages.radiology_category.radiology_categories').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified RadiologyCategory from storage.
     *
     * @param  RadiologyCategory  $radiologyCategory
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(RadiologyCategory $radiologyCategory)
    {
        $radiologyCategoryModels = [
            RadiologyTest::class,
        ];
        $result = canDelete($radiologyCategoryModels, 'category_id', $radiologyCategory->id);
        if ($result) {
            return $this->sendError(__('messages.radiology_category.radiology_categories').' '.__('messages.common.cant_be_deleted'));
        }

        $radiologyCategory->delete();

        return $this->sendSuccess(__('messages.radiology_category.radiology_categories').' '.__('messages.common.deleted_successfully'));
    }
}

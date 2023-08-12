<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExport;
use App\Http\Requests\CreateIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\FinancialTransaction;
use App\Models\Income;
use App\Repositories\IncomeRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Storage;
use Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IncomeController extends AppBaseController
{
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        $incomeHeads = Income::INCOME_HEAD;
        asort($incomeHeads);
        $filterIncomeHeads = Income::FILTER_INCOME_HEAD;
        asort($filterIncomeHeads);
        $total_earning = 0;
        $total_withdrawn = 0;
        $doctor_id = $request->doctor_id;
        $due = $request->due ?? date("Y-m-d");
        if ($request->has('due')) {
            $due = $request->due;
        }
        $dateby1 = '';
        $date = strtotime("+1 day", strtotime($due));
        $dateby1 = date("Y-m-d", $date);

        $appointments = Appointment::get();
        $doctors = Doctor::get();
        if (auth()->user()->owner_type == 'App\Models\Receptionist') {
            $doctors_search = Doctor::whereJsonContains('receptionists', (string) auth()->user()->owner_id)->get(); 
        } else {
            $doctors_search = Doctor::get();
        }
        
        if ($doctor_id && !$due) {
            $doctors = Doctor::where('id', $doctor_id)->get();
            $transactions = FinancialTransaction::where('id', $doctor_id)->get();
            $total_earning = $doctors[0]->appointments->where('is_completed', '!=', '3')->sum('fees');
            $total_withdrawn = $transactions->sum('transaction_amount');

        } elseif ($doctor_id && $due) {
        
            $doctors = Doctor::with(['appointments' => function($q) use ($due){
                $q->where('created_at', 'LIKE', '%' . $due . '%');
            }])->where('id', $doctor_id)->get();
            $total_earning = Appointment::where('doctor_id', $doctors[0]->id)->where('is_completed', '!=', '3')->where('created_at', 'LIKE', '%' . $due . '%')->sum('fees');
            $transactions = FinancialTransaction::where('doctor_id', $doctors[0]->id)->where('due_date', 'LIKE', '%' . $due . '%')->get();
            $total_withdrawn = $transactions->sum('transaction_amount');
           
        } elseif (!$doctor_id && $due) {
            if (auth()->user()->owner_type == 'App\Models\Receptionist') {
                $doctors = Doctor::with(['appointments' => function($q) use ($due){
                    $q->where('created_at', 'LIKE', '%' . $due . '%');
                }])->whereJsonContains('receptionists', (string) auth()->user()->owner_id)->orWhere('receptionists', null)->get();
                
                $doctorIds = [];
                foreach ($doctors as $doctor) {
                    $doctorIds[] = $doctor->id;
                }
                $total_earning = Appointment::where('created_at', 'LIKE', '%' . $due . '%')->where('is_completed', '!=', '3')->whereIn('doctor_id', $doctorIds)->sum('fees');
                $transactions = FinancialTransaction::where('due_date', 'LIKE', '%' . $due . '%')->whereIn('doctor_id', $doctorIds)->get();
                $total_withdrawn = $transactions->sum('transaction_amount');
            } else {
                $doctors = Doctor::with(['appointments' => function($q) use ($due){
                    $q->where('created_at', 'LIKE', '%' . $due . '%');
                }])->get();
                $total_earning = Appointment::where('created_at', 'LIKE', '%' . $due . '%')->where('is_completed', '!=', '3')->sum('fees');
                $transactions = FinancialTransaction::where('due_date', 'LIKE', '%' . $due . '%')->get();
                $total_withdrawn = $transactions->sum('transaction_amount');
            }
            
        } else {
            if (auth()->user()->owner_type == 'App\Models\Receptionist') {
                $doctors = Doctor::whereJsonContains('receptionists', (string) auth()->user()->owner_id)->orWhere('receptionists', null)->get();
                $doctorIds = [];
                foreach ($doctors as $doctor) {
                    $doctorIds[] = $doctor->id;
                }
                $total_earning = Appointment::where('is_completed', '!=', '3')->whereIn('doctor_id', $doctorIds)->sum('fees');
                $transactions = FinancialTransaction::whereIn('doctor_id', $doctorIds)->get();
                $total_withdrawn = $transactions->sum('transaction_amount');
            } else {
                $doctors = Doctor::get();
                $total_earning = Appointment::where('is_completed', '!=', '3')->sum('fees');
                $transactions = FinancialTransaction::get();
                $total_withdrawn = $transactions->sum('transaction_amount');
            }
        }

        return view('incomes.index', compact('incomeHeads', 'filterIncomeHeads', 'doctors', 'due', 'doctors_search', 'doctor_id', 'dateby1', 'total_earning', 'total_withdrawn'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIncomeRequest  $request
     * @return JsonResponse
     */
    public function store(CreateIncomeRequest $request)
    {
        $input = $request->all();
        $input['amount'] = removeCommaFromNumbers($input['amount']);
        $this->incomeRepository->store($input);
        $this->incomeRepository->createNotification($input);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.saved_successfully'));
    }

    /**
     * @param  Income  $income
     * @return Application|Factory|View
     */
    public function show(Income $income)
    {
        $incomes = $this->incomeRepository->find($income->id);
        $incomeHeads = Income::INCOME_HEAD;
        asort($incomeHeads);

        return view('incomes.show', compact('incomes', 'incomeHeads'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Income  $income
     * @return JsonResponse
     */
    public function edit(Income $income)
    {
        return $this->sendResponse($income, 'Income retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateIncomeRequest  $request
     * @param  Income  $income
     * @return JsonResponse
     */
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $this->incomeRepository->updateExpense($request->all(), $income->id);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Income  $income
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Income $income)
    {
        $this->incomeRepository->deleteDocument($income->id);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  Income  $income
     * @return ResponseFactory|\Illuminate\Http\Response
     *
     * @throws FileNotFoundException
     */
    public function downloadMedia(Income $income)
    {
        $documentMedia = $income->media[0];
        $documentPath = $documentMedia->getPath();
        if (config('app.media_disc') === 'public') {
            $documentPath = (Str::after($documentMedia->getUrl(), '/uploads'));
        }

        $file = Storage::disk(config('app.media_disc'))->get($documentPath);

        $headers = [
            'Content-Type' => $income->media[0]->mime_type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$income->media[0]->file_name}",
            'filename' => $income->media[0]->file_name,
        ];

        return response($file, 200, $headers);
    }

    /**
     * @return BinaryFileResponse
     */
    public function incomeExport()
    {
        return Excel::download(new IncomeExport, 'incomes-'.time().'.xlsx');
    }

    public function financialMore(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);
        $total_earning = 0;
        $total_withdrawn = 0;
        $due = $request->due ?? date("Y-m-d");
        if ($request->has('due')) {
            $due = $request->due;
        }
        $appointments = array();

        if ($due != null) {
            $transactions = FinancialTransaction::where('doctor_id', $doctor->id)->where('due_date', 'LIKE', '%' . $due . '%')->orderBy('id', 'DESC')->simplePaginate(25);
            $total_earning = Appointment::where('is_completed', '!=', '3')->where('doctor_id', $doctor->id)->where('created_at', 'LIKE', '%' . $due . '%')->sum('fees');
            $total_withdrawn = $transactions->sum('transaction_amount');
            $appointments = Appointment::where('doctor_id', $id)->whereDate('created_at', $due )->get();
        } else {
            $transactions = FinancialTransaction::where('doctor_id', $doctor->id)->orderBy('id', 'DESC')->simplePaginate(15);
            $total_earning = Appointment::where('is_completed', '!=', '3')->where('doctor_id', $doctor->id)->sum('fees');
            $total_withdrawn = FinancialTransaction::where('doctor_id', $doctor->id)->sum('transaction_amount');
            $appointments = Appointment::where('doctor_id', $id)->get();
        }

        return view('incomes.doctor_info', compact('doctor', 'transactions', 'total_earning', 'total_withdrawn', 'due', 'appointments'));
    }

    public function financialWithdraw(Request $request) {
        if (Session::has('last_request_time')) {
            $lastRequestTime = Session::get('last_request_time');
            $currentTime = time();
            $timeDiffInSeconds = $currentTime - $lastRequestTime;
            
            $minimumTimeBetweenRequests = 5;
            
            if ($timeDiffInSeconds < $minimumTimeBetweenRequests) {
                return redirect()->back()->with('error', __('messages.check_time_paid'));
            }
        }

        $doctor = Doctor::findOrFail($request->id);
        if ($request->transaction_amount <= 0) {
            return redirect()->back()->with('error', __('messages.check_value_paid'));
        } else {
            if ($request->remaining - $request->transaction_amount >= 0) {
                FinancialTransaction::create([
                    'doctor_id' => $request->id,
                    'type' => $request->type,
                    'transaction_amount' => $request->transaction_amount,
                    'due_date' => $request->created_at,
                    'note' => $request->note,
                ]);

                Session::put('last_request_time', time());
                return redirect()->back()->with('success','Paid successfully');
            } else {
                return redirect()->back()->with('error', 'Paid error');
            }
        }
        
        // return redirect()->route('incomes.index');
    }

    public function centerFinancial(Request $request) {
        $total_earning = 0;
        $due = $request->due ?? date("Y-m-d");
        if ($request->has('due')) {
            $due = $request->due;
        }
        if ($due != null) {
            $centerFees = FinancialTransaction::where('type', 'center')->whereDate('created_at', $due )->get();
        } else {
            $centerFees = FinancialTransaction::where('type', 'center')->get();
        }
        return view('incomes.center', compact('centerFees', 'total_earning', 'due'));
    }

    public function exportFinancialReportForDoctorAsPdf($doctor_id, $date = '') {
        if ($date == null) {
            $date = date('d-m-Y');
        }

        $doctor = Doctor::findOrFail($doctor_id);
        $app_date = date('Y-m-d', strtotime($date));
        $appointments = Appointment::where('doctor_id', $doctor_id)->whereDate('created_at', $app_date )->get();
        $transactions = FinancialTransaction::where('doctor_id', $doctor_id)->where('created_at', 'LIKE', '%' . $date . '%')->get();
        $pdf = \PDF::loadView('incomes.financial_report_for_doctor_pdf',compact('appointments', 'transactions', 'doctor', 'date')); 
        return $pdf->stream('document.pdf');

    }

    public function incomesPrintLastDay() {
        $doctors = Doctor::with(['appointments' => function($q) {
            $q->where('created_at', '>',  Carbon::yesterday())->where('created_at', '>',  Carbon::today());
        }])->get();
        $pdf = \PDF::loadView('incomes.incomes_print_last_day_pdf',compact('doctors')); 
        return $pdf->stream('PrintLastDay.pdf');
    }
}

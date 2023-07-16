<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // $doctorId = $this->request->get('doctor_id');
        // $doctorDepartmentId = Doctor::whereId($doctorId)->first();
        // $this->request->add(['department_id' => $doctorDepartmentId->doctor_department_id]);
        
    }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array
    //  */
    public function rules()
    {
        return [
            // 'doctor_id' => 'required',
            // 'department_id' => 'required',
            // 'opd_date' => 'required',
            // 'problem' => 'string|nullable',
        ];
    }

    // public static $rules = [
    //     // 'doctor_id' => 'required',
    //     // 'department_id' => 'required',
    //     // 'opd_date' => 'required',
    //     // 'problem' => 'string|nullable',
    // ];

}

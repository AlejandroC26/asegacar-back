<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDailyPayrollRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'id_guide' => 'required',        
            
            'entries' => 'required|array',
            'entries.*.code' => 'required',
            'entries.*.id_gender' => 'required',
            'entries.*.id_color' => 'required',
            'entries.*.id_age' => 'required',
            'entries.*.id_purpose' => 'required',
            'entries.*.id_outlet' => 'max:500',
            'entries.*.sacrifice_date' => 'max:500',
            'entries.*.special_order' => 'max:1000',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
        [
            'status'   => 'Error',
            'message'   => 'The given data was invalid',
            'data'      => 'null',
            'errors'      => $validator->errors()
        ]));
    }
}

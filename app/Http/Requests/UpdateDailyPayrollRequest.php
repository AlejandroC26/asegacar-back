<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDailyPayrollRequest extends FormRequest
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
            'entries' => 'required|array',
            'entries.*.code' => 'required',
            'entries.*.id_product_type' => 'required',
            'entries.*.id_outlet' => 'nullable',
            'entries.*.number' => 'nullable',
            'entries.*.sacrifice_date' => 'required',
            'entries.*.special_order' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [
            'entries.required' => 'Registra al menos un registro.',
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

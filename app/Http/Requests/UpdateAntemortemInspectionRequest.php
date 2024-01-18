<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAntemortemInspectionRequest extends FormRequest
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
            'entries' => 'required',
            'entries.*.id' => 'required',
            'entries.*.corral_number' => 'required',
            'entries.*.corral_entry' => 'required|date_format:H:i',
            'entries.*.rest_time' => 'nullable',
            'entries.*.findings_and_observations' => 'nullable',
            'entries.*.final_dictament' => 'nullable',
            'entries.*.cause_for_seizure' => 'nullable',
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostmoremInspectionsRequest extends FormRequest
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
            'id_master' => 'required',
            'id_antemortem_daily_record' => 'required',
            'id_intestines_cause' => 'max:500',
            'intestines_quantity' => 'max:500',
            'id_livers_cause' => 'max:500',
            'liver_quantity' => 'max:500',
            'id_lungs_cause' => 'max:500',
            'lungs_quantity' => 'max:500',
            'id_udders_cause' => 'max:500',
            'udders_quantity' => 'max:500',
            'id_legs_cause' => 'max:500',
            'legs_quantity' => 'max:500',
            'id_purges_cause' => 'max:500',
            'purges_quantity' => 'max:500',
            'other_organ' => 'max:500',
            'id_other_cause' => 'max:500',
            'other_quantity' => 'max:500',
            'insp_ganglions' => 'max:500',
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

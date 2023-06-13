<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVisceraDispatchRequest extends FormRequest
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
            'head' => 'max:500',
            'small_ints' => 'max:500',
            'large_ints' => 'max:500',
            'panolon' => 'max:500',
            'rennet' => 'max:500',
            'callus' => 'max:500',
            'liver' => 'max:500',
            'lung' => 'max:500',
            'legs' => 'max:500',
            'hands' => 'max:500',
            'udders' => 'max:500',
            'booklet' => 'max:500',
            'observations' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'id_master.required' => 'El parametro :attribute es requerido',
            'id_antemortem_daily_record.required' => 'El parametro :attribute es requerido',
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

<?php

namespace App\Http\Requests\V1;

use App\Exceptions\InputValidationException;
use App\Http\Requests\Request as FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SMSRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        /*
         * @todo
         * 1. customize the phone number validation based on country -
         *        write custom validatiors for all supported country if needed
         *        or use - https://github.com/Propaganistas/Laravel-Phone
         * 2. generally sms content length is fixed. can we have validation for the same ?
         */
        return [
            'u_id'     => 'required',
            'order_id' => 'required',
            'media'    => 'sometimes|url',
            'number'   => 'required|regex:/^[789]\d{9}$/',
            'body'     => 'required|string'
        ];
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     *
     * @throws \App\Exceptions\InputValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new InputValidationException;
    }
}

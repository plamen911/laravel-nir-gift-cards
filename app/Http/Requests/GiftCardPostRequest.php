<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftCardPostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required',
            'customAmount' => 'required_if:amount,==,Custom Amount',
            'quantity' => 'required',
            'sendto' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute is required.',
            'customAmount.required_if' => ':attribute is required.',
            'digits_between' => 'The :attribute must be between $:min and $:max.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'g-recaptcha-response' => 'reCAPTCHA validation',
            'amount' => 'Amount',
            'customAmount' => 'Custom Amount',
            'quantity' => 'Quantity',
            'sendto' => 'Send To'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes('customAmount', 'digits_between:25,5000', function ($input) {
            if ($input->amount === 'Custom Amount') {
                if ((float)$input->customAmount < 25 || (float)$input->customAmount > 5000) {
                    return true;
                }
            }
            return false;
        });
    }
}

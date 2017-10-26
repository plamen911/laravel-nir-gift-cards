<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressPostRequest extends FormRequest
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
            'recipient' => 'required',
            'email' => 'nullable|email',
            'address' => 'required_if:delivery_id,==,1',
            'city' => 'required_if:delivery_id,==,1',
            'state' => 'required_if:delivery_id,==,1',
            'zip' => 'required_if:delivery_id,==,1',
            'country' => 'required_if:delivery_id,==,1',
            'shipping_id' => 'required_if:delivery_id,==,1',
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
            'required_if' => ':attribute is required.',
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
            'recipient' => 'Recipient\'s Name',
            'email' => 'Recipient\'s Email',
            'address' => 'Shipping Address 1',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip Code',
            'country' => 'Country',
            'shipping_id' => 'Shipping Method',
        ];
    }
}

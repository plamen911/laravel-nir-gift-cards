<?php

namespace App\Http\Requests;

use App\Services\PaymentGatewayService;
use Illuminate\Foundation\Http\FormRequest;

class PurchasePostRequest extends FormRequest
{
    private $service;

    /**
     * PaymentGatewayController constructor.
     * @param PaymentGatewayService $paymentGatewayService
     */
    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->service = $paymentGatewayService;
    }

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
        $credentials = $this->service->credentials();
        $TEST_CREDIT_CARD = $credentials[4]->value;

        return [
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'cctype' => 'required',
            'ccnumber' => 'bail|required|numeric|digits_between:12,19|validateluhn:' . $TEST_CREDIT_CARD,
            'cvv' => 'required|digits_between:3,4',
            'ccexp_month' => 'required|integer|min:1|max:12|expires:ccexp_month,ccexp_year',
            'ccexp_year' => 'required|integer|min:' . date('y') . '|max:' . date('y', strtotime('+10 years')),
            'agree' => 'required',
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
            'agree.required' => 'You must agree with \'Terms & Conditions\' of Gift Card.',
            'required' => ':attribute is required.',
            'expires' => 'Card Card has expired.',
            'validateluhn' => 'Card Number is invalid.'
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
            'name' => 'Name',
            'email' => 'Email Receipt To',
            'address' => 'Billing Address 1',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip Code',
            'country' => 'Country',
            'cctype' => 'Credit Card Type',
            'ccnumber' => 'Credit Card Number',
            'cvv' => 'CVV',
            'ccexp_month' => 'Exp Month',
            'ccexp_year' => 'Exp Year',
        ];
    }
}

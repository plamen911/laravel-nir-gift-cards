<?php

namespace App\Http\Requests;

use App\Services\PaymentGatewayService;
use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayPostRequest extends FormRequest
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
            'merchant_id' => 'required',
            'merchant_key' => 'required',
            'developer_id' => 'required',
            'developer_key' => 'required',
            'test_ccard' => 'bail|required|numeric|digits_between:12,19|validateluhn:' . $TEST_CREDIT_CARD,
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
            'merchant_id' => 'Merchant ID',
            'merchant_key' => 'Merchant Key',
            'developer_id' => 'Developer ID',
            'developer_key' => 'Developer Key',
            'test_ccard' => 'Test Credit Card Number',
        ];
    }
}

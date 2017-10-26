<?php

namespace App\Services;

use App\Http\Requests\PaymentGatewayPostRequest;
use App\Models\PaymentGateway;

/**
 * Class PaymentGatewayService
 * @package App\Services
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class PaymentGatewayService
{
    /**
     * @param PaymentGatewayPostRequest $request
     * @return PaymentGateway[]
     * @throws \Exception
     */
    public function update(PaymentGatewayPostRequest $request)
    {
        try {
            PaymentGateway::where(['name' => 'merchant_id', 'site' => 'SagePay'])->update(['value' => $request->merchant_id]);
            PaymentGateway::where(['name' => 'merchant_key', 'site' => 'SagePay'])->update(['value' => $request->merchant_key]);
            PaymentGateway::where(['name' => 'developer_id', 'site' => 'SagePay'])->update(['value' => $request->developer_id]);
            PaymentGateway::where(['name' => 'developer_key', 'site' => 'SagePay'])->update(['value' => $request->developer_key]);
            PaymentGateway::where(['name' => 'test_ccard', 'site' => 'SagePay'])->update(['value' => $request->test_ccard]);

            return $this->credentials();

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * @return PaymentGateway[]
     */
    public function credentials()
    {
        return PaymentGateway::get();
    }
}
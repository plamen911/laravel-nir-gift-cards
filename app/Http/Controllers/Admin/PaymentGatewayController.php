<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentGatewayPostRequest;
use App\Http\Controllers\Controller;
use App\Services\PaymentGatewayService;

/**
 * Class PaymentGatewayController
 * @package App\Http\Controllers\Admin
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class PaymentGatewayController extends Controller
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
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data['result'] = $this->service->credentials();

        return view('admin.payment-gateway.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentGatewayPostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentGatewayPostRequest $request)
    {
        try {
            $this->service->update($request);
            flash('Updated Successfully')->success();
            return redirect()->route('admin.payment-gateway');

        } catch (\Exception $ex) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors([$ex->getMessage()]);
        }
    }
}

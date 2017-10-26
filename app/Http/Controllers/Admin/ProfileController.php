<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilePostRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Admin
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class ProfileController extends Controller
{
    private $service;

    /**
     * PaymentGatewayController constructor.
     * @param ProfileService $ProfileService
     */
    public function __construct(ProfileService $ProfileService)
    {
        $this->service = $ProfileService;
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data['result'] = $this->service->getUser();

        return view('admin.profile.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProfilePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProfilePostRequest $request)
    {
        try {
            $this->service->update($request);
            flash('Updated Successfully')->success();
            return redirect()->route('admin.profile');

        } catch (\Exception $ex) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors([$ex->getMessage()]);
        }
    }
}

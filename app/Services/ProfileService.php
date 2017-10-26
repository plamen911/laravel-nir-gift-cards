<?php

namespace App\Services;

use App\Http\Requests\ProfilePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileService
 * @package App\Services
 * @author Plamen Markov <plamen@lynxlake.org>
 */
class ProfileService
{
    /**
     * @param ProfilePostRequest $request
     * @return \App\User
     * @throws \Exception
     */
    public function update(ProfilePostRequest $request)
    {
        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return $this->getUser();

        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * @return \App\User
     */
    public function getUser()
    {
        return Auth::user();
    }
}
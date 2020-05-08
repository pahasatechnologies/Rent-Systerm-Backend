<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    // use ResetsPasswords;

    // protected function sendResetResponse(Request $request, $response)
    // {
    //     return response(['message'=> trans($response)]);

    // }

    // protected function sendResetFailedResponse(Request $request, $response)
    // {
    //     return response(['error'=> trans($response)], 422);
    // }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePassword($request) :
        $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')
            ->where(['email' => $request->email,
                'token' => $request->resetToken]);
    }

    private function tokenNotFoundResponse()
    {
        return response()->json(['error' => 'Token or Email is incorrect'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $this->getPasswordResetTableRow($request)->delete();

        $user->update(['password' => bcrypt($request->password)]);
        return response()->json(['data' => 'Password Successfully Changed'], Response::HTTP_CREATED);
    }
}

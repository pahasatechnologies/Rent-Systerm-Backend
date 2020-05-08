<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;


    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     dd("TEST");
    //     return response(['message'=> $response]);

    // }


    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {
    //     return response(['error'=> $response], 422);

    // }

    public function sendResetLinkEmail(Request $request)
    {
        if(!$this->validateEmail($request->email)) {
            return $this->failedResponse($request->email);
        }

        $this->sendEmail($request->email);
        return $this->successResponse();
    }

    public function sendEmail($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first()->token;
        if($oldToken) {
            return $oldToken;
        }

        $token = str_random(60);
        $this->saveToken($token,$email);
        return $token;
    }

    public function saveToken($token,$email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }


    public function validateEmail($email)
    {
        return !! User::where('email', $email)->first();
    }

    public function failedResponse($email)
    {
        return response()->json([
            'error' => 'Email '.$email.' doesn\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return response()->json([
            'data' => 'Reset Email send successfully, Please check inbox'
        ], Response::HTTP_OK);
    }


}

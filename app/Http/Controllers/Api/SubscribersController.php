<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Illuminate\Http\Request;
use Validator;

class SubscribersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $subscriber = Subscriber::whereEmail($request->email)->first();
        if ($subscriber) {
            return response()->json(["message" => "$request->email already subscribed"], 400);
        }

        Subscriber::create([
            'email' => $request->email,
        ]);
        return response()->json(["message" => "$request->email subscribed successfully"]);
    }
}

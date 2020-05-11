<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Illuminate\Http\Request;
use Validator;

class SubscribersController extends Controller
{
    private $paginateCount = 15;

    public function __construct()
    {
        $this->middleware('auth:api')->only([
            'subscribers',
            'remove_subscriber',
        ]);
    }

    public function subscribers()
    {
        $query = Subscriber::query();

        $results = $query->paginate($this->paginateCount);

        return response()->json($results);
    }

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

    public function change_status(Subscriber $subscriber, Request $request)
    {
        $subscriber->status = $request->status;
        $subscriber->save();
        return response()->json(["data" => $request->status], 200);
    }

    public function remove_subscriber(Subscriber $subscriber)
    {
        $subscriber->delete();
        return response()->json($subscriber, 200);
    }
}

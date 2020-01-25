<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        // User::with('relatedModel', 'relatedModelTwo')->get();
        $id = auth('api')->user()->id;
        return response()->json(User::with('profile', 'social_accounts')->where("id", $id)->first());
    }

    public function changePassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::find($request->id);
        $user->password = Hash::make($request->password);

        return response()->json($user->save(), 200);
    }

    public function saveUser(Request $request)
    {
        // $formData = json_decode($request->get('profile'), true); // assoc array
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find(auth('api')->user()->id);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');

        $user->save();
        return response()->json($user, 200);
    }

    public function saveProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'addressLineOne' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find(auth('api')->user()->id);

        $user->profile()->updateOrCreate(['user_id' => $user->id], $request->all());
        $user->save();

        return response()->json($user->profile, 200);
    }

    public function saveSocial(Request $request)
    {
        $user = User::find(auth('api')->user()->id);
        foreach ($request->get('social_accounts') as $account) {
            Log::debug('An informational message.   ' . $account['name']);
            $user->social_accounts()->updateOrCreate(['user_id' => $user->id, 'name' => $account['name']], $account);
        }

        return response()->json($user->social_accounts, 200);
    }

    public function saveImage(Request $request)
    {
        $user = User::find(auth('api')->user()->id);

        // $socialAccount = $user->social_accounts;
        $image = null;
        $profile_pic = $user['image'];

        if ($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                'file' => 'sometimes|image',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture = date('His') . '-' . $filename;
            if ($profile_pic) {
                unlink(public_path() . $profile_pic);
                // $file->delete(public_path('profile'), $profile_pic);
            }
            $file->move(public_path('profile'), $picture);
            $image = '/profile/' . $picture;

            $user->image = $image;
            $user->save();

            return response()->json(["message" => "Image Uploaded Succesfully"]);
        } else {
            return response()->json(["message" => "No Image found"], 422);
        }
    }
}

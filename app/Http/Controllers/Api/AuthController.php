<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public  function  register(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'password'=> ['required', 'string', 'min:6', 'confirmed'],
            'role'=> ['in:'.join(",",array_values(array_filter(\App\User::ROLES,  function($k) {
                return $k !== 'ADMIN';
            }, ARRAY_FILTER_USE_KEY)))]
        ]);
        if ($validator->fails()) {
            return  response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' =>  Hash::make($request->password),
            'role' =>  $request->role,
        ]);
        $token = auth('api')->login($user);
        return  response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
            ], 201);
    }
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return  response()->json($validator->errors(), 422);
        }
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return  response()->json(['error' => 'Invalid
             Credentials'], 400);
        }
        $current_user = $request->email;
            return  response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'current_user' => $current_user,
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(true); // Force token to blacklist
        return  response()->json(['success' => 'Logged out
         Successfully.'], 200);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

}

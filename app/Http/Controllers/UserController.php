<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function authenticate(LoginUserRequest $loginUserRequest) 
    {
        DB::beginTransaction();
        try {
            $loginUserRequest->validated();

            $user = User::where('email', $loginUserRequest->email)->first();

            if ($user && Hash::check($user->password, $loginUserRequest->password)) {
                $token = $user->createToken($user->username)->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ]);
            }

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack(); 
            return response()->json([
                'status' => 400,
                'message' => 'bad request'
            ], 400);  
        }
    }

    public function register(StoreUserRequest $storeUserRequest)
    {
        DB::beginTransaction();
        try {
            $store = User::create($storeUserRequest->validated());
            $token = $store->createToken($store->username)->plainTextToken;
            DB::commit();
            return response()->json([
                'user' => $store,
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => 'bad request'
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->where('tokenable_id', $request->user()->id)->delete();

        return response()->json([
            'status' => 200,
            'message' => 'logged out successfully'
        ], 200);
    }
}

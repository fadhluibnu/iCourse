<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function authenticate(LoginUserRequest $loginUserRequest)
    {
        DB::beginTransaction();
        try {
            $validated = $loginUserRequest->validated();

            $user = User::where('email', $loginUserRequest->email)->firstOrFail();
            // return $loginUserRequest->password;

            if (Auth::attempt($validated)) {
                $token = $user->createToken($user->username)->plainTextToken;
                DB::commit();
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ]);
            }
            
            return response()->json([
                'status' => '400',
                'message' => 'Invalid login'
            ], 400);
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
            // memvalidasi input
            $validate = $storeUserRequest->validated();

            // menyimpan dan menerima response dari api untuk menyimpan gambar
            $photo = fopen($storeUserRequest->file('photo'), 'r');
            $profil = Http::acceptJson()->attach(
                'image',
                $photo
            )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                'code' => '38@0$%8%^8/8471'
            ]);

            // // me-rewite ulang photo dan password yang sudah di hash
            $validate['photo'] = $profil['image'];
            $validate['password'] = Hash::make($validate['password']);

            // menyimpan user dan token user
            $store = User::create($validate);
            $token = $store->createToken($store->username)->plainTextToken;

            // commit database jika semua lancar
            DB::commit();

            // mengembalikan response json
            return response()->json([
                'user' => $store,
                'token' => $token
            ], 200);
        } catch (\Throwable $th) {

            // rollback database jika ada kesalahan
            DB::rollBack();

            // mengembalikan response json
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage()
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

    public function update(UpdateUserRequest $updateUserRequest, $username)
    {
        DB::beginTransaction();
        try {
            $validated = $updateUserRequest->validated();
            if ($updateUserRequest->file('photo')) {
                // menyimpan dan menerima response dari api untuk menyimpan gambar
                $photo = fopen($updateUserRequest->file('photo'), 'r');
                $profil = Http::acceptJson()->attach(
                    'image',
                    $photo
                )->post('https://image-api-icourse.000webhostapp.com/api/upload-image', [
                    'code' => '38@0$%8%^8/8471'
                ]);
                $validated['photo'] = $profil['image'];
            }
            if ($updateUserRequest->password) {
                $validated['password'] = Hash::make($validated->password);
            }
            User::where('username', $username)->update($validated);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Updated successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function profileWithPost($username)
    {
        try {
            $data = new UserResource(User::where('username', $username)->with([
                'posts' => [
                    'user',
                    'categories',
                    'comments' => [
                        'replyComments'
                    ],
                    'tutorials',
                ]
            ])->first());
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => $th->getMessage(),
                'data' => null
            ], 400);
        }
    }
}

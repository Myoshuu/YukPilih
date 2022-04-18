<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            if ($validator->fails() || !($token = JWTAuth::attempt($validator->validated()))) {
                return response()->json(["message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
            };
        } catch (JWTException $e) {
            return response()->json(['message' => 'Cannot create token'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(compact('token'), Response::HTTP_OK);
    }

    public function logout(Request $request)
    {

        JWTAuth::invalidate($request->token);
        try {
            auth()->logout();
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token not Found'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['message' => 'succesfully logged out'], Response::HTTP_OK);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function reset(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $verify = Hash::check($request->old_password, auth()->user()->password);

        if ($verify) {
            $new = $request->new_password;
            $confirm = $request->confirm_password;

            if ($new === $confirm) {
                $user->fill([
                    'password' => Hash::make($new),
                ])->save();
            } else {
                return response()->json(['message' => "password doesn't match"], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json(compact('user'));
        } else {
            return response()->json(['message' => "old password doesn't match with current password"], Response::HTTP_UNAUTHORIZED);
        }
    }
}

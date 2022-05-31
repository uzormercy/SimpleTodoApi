<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthenticationController extends Controller
{

    public const TOKEN_KEY= "7RYfwRRyiMJAWhavDBBPfJzzhq9uUY5HaH4";

    public function login(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'email' => "required|string ",
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json(['message' => $validate->messages()->first()], 422);
        }
        $user = User::whereEmail($request->email)->first();
        if(!$user){
            return response()->json(['message' => "Unknown user"], 422);
        }
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $token = $user->createToken(static::TOKEN_KEY)->accessToken;
            return response()->json([
			  "token" => $token,
				"user" => $user
			], 200);
        }

	return response()->json(["message" => "Invalid password or email address"], 422);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|string',
            "confirm_password" => 'required|string|same:password',
        ]);

        if ($validate->fails()){
            return response()->json(['message' => $validate->messages()->first()], 422);
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken(static::TOKEN_KEY)->accessToken;
        $data = [
            "user" => $user,
            "token" => $token
        ];
        return response()->json($data, 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        if(Auth::check()){
            $user = Auth::user();
            $user->token()->revoke();
            return response()->json(["message" => "logged out successfully"], 200);
        }
        return response()->json(["error" => "Something went wrong"], 500);
    }

}

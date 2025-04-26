<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Hautelook\Phpass\PasswordHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $userProfile = new UserProfile();
        $userProfile->user_id = $user->id;
        $userProfile->email = $request->email;
        $userProfile->save();
        $token = $user->createToken('client')->plainTextToken;

        $response = [
            'success' => true,
            'data'    => ['token' => $token],
            'message' => "",
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
        return response()->json(['error' => 'Invalid credentials'], 401);
        }
        if(substr($user->password, 0, 2) === '$P'){
            $hasher = new PasswordHash(8, true);
            if (!$hasher->CheckPassword($request->password, $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            $token = $user->createToken('client')->plainTextToken;
        }else if (Hash::check($request->password, $user->password)) {
        $token = $user->createToken('client')->plainTextToken;

        } else {
            // Password doesn't match any known hash format
            return response()->json(['error' => 'Invalid credentials'], 401);
        }


        $response = [
            'success' => true,
            'data'    => ['token' => $token,"is_show"=>$user->is_show],
            'message' => "",
        ];

        return response()->json($response, 200);
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth()->user()->createToken('admin')->plainTextToken;


        return response()->json(['token' => $token,"isAdmin"=>auth()->user()->isAdmin()]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        $response = [
            'success' => true,
            'data'    => [],
            'message' => "Successfully logged out",
        ];
        return response()->json($response, 200);
    }
}

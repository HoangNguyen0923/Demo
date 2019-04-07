<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Lcobucci\JWT\Parser;
use DB;
class AuthController extends Controller
{
    // Register user
    public function createUser(Request $request)
    {
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4']
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 204);
        }
        // $user = User::where('email', '=', Input::get('email'))->first();
        // return response()->json(['auth' => $user], 200);       
        // Check if record is existed?
        if (User::where('email', '=', Input::get('email'))->first()) {
            return response()->json(['auth' => 'user existed'], 204);
        } else {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
                return response()->json(['user' => $user], 200);
        }
    }

    // Display all users.
    public function getUsers()
    {
        $user = User::all();
        $response = [
            'user' => $user
        ];
        return response()->json($response, 200);
    }

    // Login user
    public function login(Request $request)
    {
        // $email = $request->input('email');
        // $password = $request->input('password');
        $username = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // if (Auth::attempt(['email' => $email, 'password' => $password])) {
        if (Auth::attempt($username)) {
            $userToken = Auth::user()->createToken('remember_token')->accessToken;
            return response()->json([
                'user_token' => $userToken,
                'user'=>Auth::user(),
                'auth'=>'Login success'
            ], 200);
        } else {
            return response()->json(['auth'=>'Login failed'], 200);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        // $value = $request->bearerToken();
        $value = $request->headers->all();
        // echo($value);
        return response()->json(['value'=> $value],200);
        // $id = (new Parser())->parse($value)->getHeader('jti');
        // return response()->json(['value'=> $id],200);
        // //  echo($id);
        // // $token = DB::table('oauth_access_tokens')->where('id', $id)->first();
        // // var_dump($token);
        // if (DB::table('oauth_access_tokens')->where('id', $id)->delete()){
        //     return response()->json(['auth' => 'Delete tokens success'], 200);
        // } else {
        //     return response()->json(['auth' => 'Delete token failed'], 404);
        // }
        // // Auth::logout();
    }

    // Reset Password
    // public function resetPassword(Request $request)
    // {
    //     $curr_password = $request->
    // }
}

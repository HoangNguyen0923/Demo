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
use Carbon\Carbon;
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
        // Check if record is existed?
        if (User::where('email', '=', Input::get('email'))->first()) {
            return response()->json(['auth' => 'user existed'], 204);
        } else {
            // Create user account
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
        $value = $request->bearerToken();
        // $value = $request->headers->all();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        if ($token->revoke()) {
            return response()->json(['auth' => 'Delete tokens success'], 200);
        } else {
            return response()->json(['auth' => 'Delete token failed'], 404);
        } 
        // $token = DB::table('oauth_access_tokens')->where('id', $id)->first();
        // var_dump($token);
        // if (DB::table('oauth_access_tokens')->where('id', $id)->delete()){
            // return response()->json(['auth' => 'Delete tokens success'], 200);
        // } else {
            // return response()->json(['auth' => 'Delete token failed'], 404);
        // }
    }

    // Create token when request forget password executed
    public function createTokenResetPassword(Request $request)
    {
        $email = $request->email;
        if (User::where('email', '=', $email)->first()) {
            $current_date_time = Carbon::now()->toDateTimeString();
            $value = [
                'email' => $email,
                'token' => str_random(255),
                'time' => $current_date_time
            ];
            DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', 
            [$value['email'],$value['token'],$value['time']]);
            return response()->json([
                'token' => $value['token'],
                'check' => 'success'],200);
        } else {
            return response()->json(['check' => 'failed'],200);
        }
    }

    // Send Token Reset Link
    public function sendTokenResetPasswordLink(Request $request)
    {
        $token = $request->token;
        $pw_reset_email = DB::table('password_resets')->where('token', $token)->first();
        $user_email = DB::table('users')->where('email', $pw_reset_email->email)->first();
        // $email = str_repeat("*", strlen($user_email->email));
        return response()->json([
            'email' => $user_email->email,
            'token' => $token,
            'check' => 'success'
        ], 200);
    }

    // Reset Password - New password
    public function resetPassword(Request $request)
    {
        // get request current password
        $curr_password = $request->curr_password;
        // get request new password
        $new_password = $request->new_password;

        $token = $request->token;
        $pw_reset_email = DB::table('password_resets')->where('token', $token)->first();
        $user_email = User::where('email', $pw_reset_email->email)->first();

        // check input password if matches user password in database
        if ($curr_password === $new_password) {
            return response()->json([
                'error' => 'New password is the same as the old'
            ], 200);
        } else {
            if (!Hash::check($curr_password, $user_email->password)) {
                return response()->json([
                    'result' => 'Not matched'
                ],200);
            } else {
                $user_email->fill(['password' => Hash::make($new_password)])->save();
                DB::delete('delete from password_resets where token = ?', [$token]);
                return response()->json([
                    'update' => 'Success'
                ], 200);
            }
        }
    }
}

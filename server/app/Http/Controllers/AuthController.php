<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordEmail;
use App\Mail\RegisterEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['bail', 'required'],
            'email' => 'required|min:10|unique:users|email',
            'tel' => 'required|min:10|max:10|unique:users',
            'password' => 'min:8',
        ]);

        $user = User::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'tel' => $validated['tel'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->tokens()->delete();

        $token = $user->createToken('myToken')->plainTextToken;
        Mail::to($user)->send(new RegisterEmail());

        return response(['status' => 'success', 'data' => ['user' => $user], 'token' => $token], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'min:8',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response(['status' => 'fail', 'message' => 'No user found with this email'], 404);
            // throw ValidationException::withMessages([
            //     'email' => ['The provided credentials are incorrect.'],
            // ]);
        }

        $isPasswordValid = Hash::check($validated['password'], $user->password);

        if (!$isPasswordValid) {
            return response(['status' => 'fail', 'message' => 'The entered Password is incorrect'], 400);
        }

        $user->tokens()->delete();

        $token = $user->createToken('myToken')->plainTextToken;

        return response(['status' => 'success', 'data' => ['user' => $user], 'token' => $token], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response(['status' => 'fail', 'message' => 'No user found or password is incorrect'], 404);
            exit;
        }

        $token = bin2hex(random_bytes(16));
        $user->resettoken = $token;
        $user->resettokencreatedat = time();
        $user->save();

        $link = "http://localhost:8000/api/auth/resetpassword/$token";

        Mail::to($user)->send(new ForgetPasswordEmail($link));

        return response([
            'status' => 'success',
            'message' => 'Email sent successfully successfully',
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function resetpassword($token, Request $request)
    {

        $user = User::where('resettoken', $token)->first();

        if (!$user) {
            return response(['status' => 'fail', 'message' => 'No user found or password is incorrect'], 404);
            exit;
        }

        if (($user->resettokencreatedat + 10 * 60) < time()) {
            $user->resettoken = '';
            $user->resettokencreatedat = '';
            $user->save();
            return response(['status' => 'fail', 'message' => 'Link has expired, please try again'], 400);
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8'],
            'confirmPassword' => ['required', 'string', 'min:8'],
        ]);

        if ($validated['password'] !== $validated['confirmPassword']) {
            return response(['status' => 'fail', 'message' => 'Please confirm your password'], 400);
        }

        $user->update(['password' => Hash::make($validated['password']), 'resettoken' => '', 'resettokencreatedat' => '']);
        return response([
            'status' => 'success',
            'message' => 'Password has been reset successfully',
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
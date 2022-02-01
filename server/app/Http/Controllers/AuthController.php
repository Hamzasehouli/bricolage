<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required',
            'tel' => 'required|min:10|max:10|unique:users',
            'password' => 'min:8',
        ]);

        $user = User::create([
            'fullname' => $validated['fullname'],
            'tel' => $validated['tel'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('myToken')->plainTextToken;

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
            'tel' => 'required|min:10|max:10',
            'password' => 'min:8',
        ]);

        $user = User::where('tel', $validated['tel'])->first();

        if (!$user) {
            return response(['status' => 'fail', 'message' => 'No user found with this phone number'], 400);
        }

        $isPasswordValid = Hash::check($validated['password'], $user->password);

        if (!$isPasswordValid) {
            return response(['status' => 'fail', 'message' => 'The entered Password is incorrect'], 400);
        }

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
            'tel' => 'required|min:10|max:10',
        ]);

        $user = User::where('tel', $validated['tel'])->first();

        if (!$user) {
            return response(['status' => 'fail', 'message' => 'No user found with this phone number'], 400);
        }

        $notif = new NotificationController();
        $notif->sendSmsNotificaition('0623839627', 'hi moh');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class MeController extends Controller
{
    /**
     * Show basic data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        return response()->json([
            'name' => $request->user()->name,
            'email' => $request->user()->email
        ]);
    }

    /**
     * Edit basic data
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        $request->validate([
            'name' => 'filled|string',
            'email' => 'filled|string|email|unique:users,email,' . $request->user()->id
        ]);

        auth()->user()->update($request->all());

        return $this->successResponse(Response::HTTP_OK);
    }

    /**
     * Edit password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editSecurity(Request $request) {
        $request->validate([
            'password_old' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        //Check which user knows the password
        if (Hash::check($request->password_old, $request->user()->password)) {
            $user = auth()->user();
            $user->password = bcrypt($request->password);
            $user->save();

            return $this->successResponse(Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'fail',
                'data' => 'Incorrect password'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}

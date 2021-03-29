<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MeController extends Controller
{
    /**
     * Show basic data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request) {
        try {
            return response()->json([
                'name' => $request->user()->name,
                'email' => $request->user()->email
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Edit basic data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,' . $request->user()->id
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            auth()->user()->update($request->all());

            return response()->json([
                'message' => 'Successfully edited user!'
            ], Response::HTTP_CREATED);

        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Edit password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editSecurity(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'password_old' => 'required|string',
                'password' => 'required|string|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            //Check which user knows the password
            if (Hash::check($request->password_old, $request->user()->password)) {
                $user = auth()->user();
                $user->password = bcrypt($request->password);
                $user->save();

                return response()->json([
                    'message' => 'Successfully edited user password!'
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'error' => 'Incorrect password'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}

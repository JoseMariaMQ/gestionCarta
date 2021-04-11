<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * User register
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function signUp(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return response()->json([
                'status' => 'Success',
                'data' => null
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
               'status' => 'fail',
                'data' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Login and token creation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request) {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_token' => 'boolean'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials))
                return response()->json([
                    'status' => 'fail',
                    'data' => 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');

            $token = $tokenResult->token;
            if ($request->remember_token)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'fail',
                'data' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Log out
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        try {
            $request->user()->token()->revoke();

            return response()->json([
                'status' => 'Success',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

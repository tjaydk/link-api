<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateForgotPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($validated = $request->validated()) {
            if (!Auth::attempt($validated)) {
                return response()->json('Invalid credentials', 401);
            }
            return response()
                ->json(['token' => auth()->user()->createToken($request->token_name || '')->plainTextToken]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json('OK');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        // If no token is sent then wait 3 seconds for extra security
        if ($status !== 'password.sent') {
            sleep(5);
        }

        return response()->json($status);
    }

    /**
     * @param Request $request
     * @param string $token
     * @return JsonResponse
     */
    public function resetPassword(Request $request, string $token): JsonResponse
    {
        // Do nothing
        return response()->json('OK');
    }

    /**
     * @param UpdateForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdateForgotPasswordRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => bcrypt($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return response()->json($status);
        }

        return response()->json('Something went wrong', 500);
    }
}

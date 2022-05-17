<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Laravel\Lumen\Application;

class AuthController extends Controller
{
    /**
     * Login User
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'access_token' => $user->generateToken(),
                'token_type' => 'Bearer',
                'expires_in' => time()+(60*60*6),
            ]);
        }

        return response()->json([
            'message' => __('The given data was invalid.'),
            'errors' => [
                'email' => [
                    __('Email or password is invalid')
                ],
            ]
        ]);
    }

    /**
     * User registration
     *
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create(array_merge(
            $request->validated(),
            ['password' => Hash::make($request->input('password'))]
        ));

        return response()->json([
            'access_token' => $user->generateToken(),
            'token_type' => 'Bearer',
            'expires_in' => time()+(60*60*6),
        ], 201);
    }

    /**
     * Generate reset token and Send reset password email
     *
     * @param RecoverPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function generateResetToken(RecoverPasswordRequest $request): JsonResponse
    {
        try {
            // Send password reset to the user with this email address
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            $response = false;
        }

        return response()->json(['data' => ['success' => $response == Password::RESET_LINK_SENT]]);
    }

    /**
     * Display the form to request a password reset link.
     *
     * @param Request $request
     *
     * @return View|Application
     */
    public function showLinkRequestForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => $request->input('email'),
            'token' => $request->input('token')
        ]);
    }

    /**
     * Change password by token
     *
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        // Reset the password
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->password = app('hash')->make($password);
                $user->save();
            }
        );

        return response()->json(['data' => ['success' => $response == Password::PASSWORD_RESET]]);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  Request  $request
     *
     * @return array
     */
    protected function credentials(Request $request): array
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker
    {
        return (new PasswordBrokerManager(app()))->broker();
    }
}

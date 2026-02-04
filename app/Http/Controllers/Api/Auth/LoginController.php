<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TermiiSmsService;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class LoginController extends Controller
{
     public function submit(Request $request, TermiiSmsService $termii)
    {
        $request->validate([
            'phone' => 'required|numeric|min:10',
        ]);

        // Find or create the user
        $user = User::firstOrCreate([
            'phone' => $request->phone,
        ]);

        // Generate a 6-digit OTP
        $code = random_int(111111, 999999);

        // Save OTP (hashed for security)
        $user->update([
            'login_code' => $code,
        ]);

        // Send OTP via Termii notification

        $user->notify(new LoginNeedsVerification($code));

        $response = [
            'user'=>$user,

            'message' => 'Verification code sent via SMS.',
        ];

        return response($response, 201);
    }

    public function verify(Request $request)
    {
        // validate the phone number and login_code

         $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|digits:6',
        ]);

        // check for user and login)code

        $user = User::where('phone', $request->phone)
            ->where('login_code', $request->login_code)
            ->first();

        // check if user exist or not

        if (! $user) {
            return response()->json([
                'message' => 'Invalid verification code'
            ], 422);
        }

        // update login_code for user

        $user->update([
            'login_code' => null,
        ]);

        return response()->json([
            'token' => $user->createToken('auth')->plainTextToken,
            'user' => $user,
            'message' => 'Login successful',
        ]);

    }
}

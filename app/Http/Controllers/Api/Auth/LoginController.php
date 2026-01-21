<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class LoginController extends Controller
{
     public function submit(Request $request)
    {
        // validate login details

         $request->validate([
            'phone' => 'required|numeric|min:10',
        ]);

        // find or create a new user deatils

        $user = User::firstOrCreate([
             'phone' => $request->phone
        ]);

        if (!$user) {
            return response()->json(['message' => 'Could not proceess user with that Phone number.'], 401);
        }

        // send use a one time code

        //$user->notify(new LoginNeedsVerification());

        //return back a response

        return response()->json([
            'message' => 'Text Message Notification Sent !!!'
        ]);
    }

    public function verify(Request $request)
    {
        // validate the incoming request

         $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111,999999',
        ]);

        // find user

        $user = User::where('phone', $request->phone)->where('login_code', $request->login_code)->first();

        // is the code provided the same one saved

        // if so return back on auth token

        if ($user) {

            $user->update([
                'login_code' => null
            ]);

            return $user->createToken($request->login_code)->plaintextToken;
        }

        // if not return back a error message.

        return response()->json(['message' => 'Invalid Verification Code']);
    }
}

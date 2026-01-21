<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class DriverController extends Controller
{
     public function show(Request $request)
    {
        // return back the user and associated driver model

        $user = $request->user();

        $user->load('driver');

        return $user;
    }

    public function update(Request $request)
    {
        // first Validate the Driver

        $request->validate([
            'year' => 'required|numeric|between:2010,2024',
            'make' => 'required',
            'model' => 'required',
            'color' => 'required|alpha',
            'license)plate' => 'required',
            'name' => 'required'
        ]);

        $user = $request->user();

        // update driver name only

        $user->update($request->only('name'));

        //create or update a driver associated with this user

        $user->driver()->update->updateOrCreate($request->only([
            'year',
            'make',
            'model',
            'color',
            'license_plate'
        ]));

        $user->load('driver');

        return $user;
    }
}

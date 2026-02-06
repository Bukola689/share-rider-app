<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Driver;
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
    
    $request->validate([
        'year' => 'required|numeric|between:2010,2024',
        'make' => 'required',
        'model' => 'required',
        'color' => 'required',
        'license_plate' => 'required',
        
    ]);

    $user = $request->user();

    // Safety check
    if (! $user) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    // Create or update driver
     $user->driver()->updateOrCreate($request->only(['year', 'make', 'model', 'color', 'license_plate', 'name']));

   // return response()->json(['message' => 'Driver information updated successfully.']);

    return response()->json(
        $user->load('driver')
    );
  }
}

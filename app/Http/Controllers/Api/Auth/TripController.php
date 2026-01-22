<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Driver;
use App\Notifications\TripAccepted;
use App\Notifications\TripStarted;
use App\Notifications\TripEnded;
use App\Notifications\DriverLocationUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TripController extends Controller
{
 public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'destination_name' => 'required'
        ]);

        return $request->user()->trips()->create($request->only([
            'origin',
            'destination',
            'destination_name'
        ]));
    }

    public function show(Request $request, Trip $trip)
    {
        // the trip is associated with the authorizeduser or the driver
        if ($trip->user_id !== $request->user()->id) {
            return $trip;
        }

        if($trip->driver && $request->user->driver) {
            if($trip->driver->id === $request->user()->driver->id) {
                //return response()->json(['message' => 'Unauthorized'], 403);
                return $trip;
            }
        }

        return response()->json(['message' => 'Cannot Find This Trip'], 404);
    }

    public function accept(Request $request, Trip $trip)
    {
       // Driver accept a Trip

       $request->validate([
        'driver_location' => 'required'
       ]);

       //update Trip with driver_id and status

         $trip->update([
          'driver_id' => $request->user()->id,
          'driver_location' => $request->driver_location,
         ]);

         $trip->load('driver.user');

         // Dispatch an event

         TripAccepted::dispatch($trip, $request->user());

         return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
        //update or start a trip

        $trip->update([
            'is_started' => true
        ]);

        $trio->load('driver.user');

        TripStarted::dispatch($trip, $request->user());

        return $trip;
    }

    public function end(Request $request, Trip $trip)
    {
        // final trip destination

         $trip->update([
            'is_complete' => true
        ]);

        $trio->load('driver.user');

        TripEnded::dispatch($trip, $request->user());

        return $trip;
    }

     public function location(Request $request, Trip $trip)
    {
        //validate driver location

        $request->validate([
            'driver_location' => 'required'
        ]);

        // update the driver location

        $trip->update([
            'driver_location' => $request->driver_location
        ]);

        //load relation between user driver

        $trip->load('driver.user');

        TripLocationUpdated::dispatch($trip, $request->user());

        return $trip;
    }
}

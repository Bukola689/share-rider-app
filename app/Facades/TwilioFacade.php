<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TwilioFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'twilio';
    }
}
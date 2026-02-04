<?php

return [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_TOKEN'),
    'from' => env('TWILIO_FROM'),
    'whatsapp_from' => env('TWILIO_WHATSAPP_FROM'),
    'messaging_service_sid' => env('TWILIO_MESSAGING_SERVICE_SID'),
    'debug' => env('TWILIO_DEBUG', false),
    'default_country_code' => env('TWILIO_DEFAULT_COUNTRY_CODE', '+1'),
];
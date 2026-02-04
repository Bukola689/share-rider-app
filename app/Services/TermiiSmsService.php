<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TermiiSmsService
{
    public function send(string $phone, string $message): array
    {
        return Http::post(
            'https://api.ng.termii.com/api/sms/send',
            [
                'api_key' => config('services.termii.key'),
                'to'      => $this->formatPhone($phone),
                'from'    => config('services.termii.sender_id'),
                'sms'     => $message,
                'type'    => 'plain',
                'channel' => 'generic',
            ]
        )->json();
    }

    private function formatPhone(string $phone): string
    {
        return str_starts_with($phone, '0')
            ? '234' . substr($phone, 1)
            : $phone;
    }
}

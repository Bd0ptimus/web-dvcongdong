<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;


class SMSNotificationController extends Controller
{
    public function sendSmsNotification(){
        $basic  = new \Nexmo\Client\Credentials\Basic(NEXMO_KEY, NEXMO_API_SECRETE);
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '79689240329',
            'from' => 'DVCONGDONG',
            'text' => 'Ma xac nhan cua ban la '.rand(100000,999999),
        ]);

        dd('SMS message has been delivered.');
    }
}

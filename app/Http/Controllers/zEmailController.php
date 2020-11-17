<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PharIo\Manifest\Email;

class zEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function test()
    {


        // $contact = '09068002030';
        // $newstring = substr($contact, -10);
        // return '63'.$newstring;
        // if (
        //     $contact == '639507599270' ||
        //     $contact == '639068002030' ||
        //     $contact == '639564510415' ||
        //     $contact == '639309008864'
        // ) {
        //     return $contact;
        // } else {
        //     return 'okay, just test';
        // }


         $digits = 5;
         $confirmation_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send(
            'emails.welcome',
            ['confirmation_code' => $confirmation_code],
            function ($message) {
                $message
                    ->from('epawn.online01@gmail.com', 'E-PAWN')
                    ->to('pj.abing@gmail.com', 'PJ Abing')
                    ->subject('E-pawn Email Verification!');
            }
        );

        ///Send SMS
        // 639507599270
        // 639564510415
        // 639309008864
        $contact = '639068002030';
        $basic  = new \Nexmo\Client\Credentials\Basic('22cf11ff', 'guV91Wel1v4Z9b3l');
        $client = new \Nexmo\Client($basic);
        $message = "Hi, This is Epawn your registration code is: [ " . $confirmation_code . " ]";
        $client->message()->send([
            'to' => $contact,
            'from' => 'E-pawn',
            'text' => $message
        ]);

        return "Email Sent and SMS sent";
    }
}

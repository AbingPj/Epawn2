<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use App\tbl_user;


class SMS extends Controller
{
    public function sendSMS(Request $request)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('22cf11ff', 'guV91Wel1v4Z9b3l');
        $client = new \Nexmo\Client($basic);


        if ($request->isRange != false) {
            $message = $request->pawnshop_name . " has appraised P" . $request->bidamount . " on your item of " . $request->itemName;
        } else {
            $message = $request->pawnshop_name . " has appraised from P" . $request->bid_from . " up to P" . $request->bid_to . " on your item of " . $request->itemName;
        }
        // dd($request->user_id);
        $user = tbl_user::find($request->user_id);

        // $client->message()->send([
        //     'to' => '639458375737',
        //     'from' => 'Epawn',
        //     'text' => $message
        // ]);

        $contact1 = $user->contact;
        $newstring = substr($contact1, -10);
        $newstring = '63'.$newstring;

        $contact = $newstring;
        if (
            $contact == '639068002030' ||
            $contact == '639458375737'
        ) {
            $client->message()->send([
                'to' => $contact,
                'from' => 'Epawn',
                'text' => $message
            ]);
        }

        //   $nexmo = app('Nexmo/Client');
        //   $nexmo->message()->send([
        //     'to'   => '14845551244',
        //     'from' => '16105552344',
        //     'text' => 'Using the instance to send a message.'
        //   ]);
    }
    public function dealClose(Request $request)
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('22cf11ff', 'guV91Wel1v4Z9b3l');
        $client = new \Nexmo\Client($basic);
        $message = "Your item of " . $request->item_name . " is in pending and is closed with the amount of "
            . $request->bid_price . ", Please visit any " . $request->fname . " branch. Open/Install Our mobile application
        to view " . $request->fname . "'s location";

        $contact = '639458375737';
        if (
            $contact == '639068002030' ||
            $contact == '639458375737'
        ) {
            $client->message()->send([
                'to' => $contact,
                'from' => 'Epawn',
                'text' => $message
            ]);
        }
    }
}

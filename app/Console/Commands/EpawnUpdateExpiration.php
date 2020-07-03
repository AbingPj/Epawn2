<?php

namespace App\Console\Commands;

use App\tbl_user;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class EpawnUpdateExpiration extends Command
{

    protected $signature = 'epawn:update-expiration';
    protected $description = 'set the pawnshops valids to expire';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        print("\n Start Setting up Expire Pawnshops ");
        $dateNow = Carbon::now('Asia/Manila');
        $strDateNow = $dateNow->format('M.d,Y');
        $dateNowParse = Carbon::parse($strDateNow);
        // $dateNow->addDays(32);
        $pawnshops = tbl_user::where('role_id', 2)
            ->where('isValid', 1)
            ->get();
        print("\n \t items:" . $pawnshops->count());
        foreach ($pawnshops as $key => $value) {
            $expirationDate = Carbon::parse($value->expiration);
            $strExpirationDate = $expirationDate->format('M.d,Y');
            $expirationDateParse = Carbon::parse($strExpirationDate);
            if ($dateNowParse >= $expirationDateParse) { 
                print("\n \t\t set expire: " .  $value->username . "\t / id :". $value->user_id);
                $user = tbl_user::find($value->user_id);
                $user->isValid = 3;
                $user->save();
            }
        }
        print("\n Successfully Setting up " . $strDateNow);
    }
}

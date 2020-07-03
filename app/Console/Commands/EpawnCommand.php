<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EpawnCommand extends Command
{
    protected $signature = 'epawn:sample';
    protected $description = 'Sample';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
       
        print("\n Just Sample ");
        for ($i=0; $i < 20 ; $i++) { 
           sleep(1);
           print("\n".$i);
        }
        // $digits = 5;
        // $confirmation_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        // $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        // $beautymail->send(
        //     'emails.welcome',
        //     ['confirmation_code' => $confirmation_code],
        //     function ($message) {
        //         $message
        //             ->from('epawn.online01@gmail.com', 'E-PAWN')
        //             ->to('pj.abing@gmail.com', 'PJ Abing')
        //             ->subject('E-pawn Email Verification!');
        //     }
        // );
    }
}

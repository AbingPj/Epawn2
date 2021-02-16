<?php

namespace App\Http\Controllers;

use App\tbl_user_itempost;
use Illuminate\Http\Request;
use App\zPackage;
// use App\zPackageDuration;
use App\tbl_package_duration;
use App\tbl_user;
use App\zPawnedItem;
use App\zPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use stdClass;

class zClarifyController extends Controller
{

    // public function zSavePawnedItem(Request $request)
    // {
    //     DB::transaction(function () use ($request) {

    //         if($request->days_deadline == "" || $request->days_deadline == null  ){
    //             $days_deadline = 3;
    //         }else{
    //             if($request->days_deadline > 15){
    //                 $days_deadline = 15;
    //             }else{
    //                 $days_deadline = $request->days_deadline;
    //             }
    //         }


    //         $pawned = new zPawnedItem;
    //         $pawned->item_id = $request->item_id;
    //         $pawned->pawnshop_id =  $request->pawnshop_id;
    //         $pawned->customer_id =  $request->customer_id;
    //         $pawned->package_id =  $request->package_id;
    //         $pawned->pawn_amount =  $request->pawn_amount;
    //         $pawned->date_pawned =  Carbon::now('Asia/Manila');
    //         $pawned->date_renew =  Carbon::now('Asia/Manila');
    //         $pawned->days_deadline =   $days_deadline;
    //         // $pawned->date_claimed =  Carbon::now('Asia/Manila');
    //         $pawned->is_claimed = 0;
    //         $pawned->is_confiscated = 0;
    //         $pawned->save();

    //         $item = tbl_user_itempost::find($request->item_id);
    //         $item->status = 2;
    //         $item->save();

    //         //Create Pdf


    //     });
    // }



    public function zConfiscateItem(Request $request)
    {
        DB::transaction(function () use ($request) {

            $id = $request->pawned_item_id;
            $pawned = zPawnedItem::find($id);
            $pawned->is_confiscated = 1;
            $pawned->save();

            // $item = tbl_user_itempost::find($request->item_id);
            // $item->status = 4;
            // $item->save();
        });
    }

    public function zRejectPendingItem(Request $request)
    {
        DB::transaction(function () use ($request) {
            $pawned = new zPawnedItem;
            $pawned->item_id = $request->item_id;
            $pawned->pawnshop_id =  $request->pawnshop_id;
            $pawned->customer_id =  $request->customer_id;
            $pawned->is_rejected = 1;
            // $pawned->reason = $request->reason;
            $pawned->save();

            $item = tbl_user_itempost::find($request->item_id);
            $item->status = 4;
            $item->save();
        });
    }

    public function zGetPawnedItemsByPawnshop($pawnshop_id){
        $items = zPawnedItem::all()->where('pawnshop_id', $pawnshop_id);
        foreach ($items as $key => $item) {
            $item->customer_name = $item->customer->username;
            $item->item_name = $item->item->item_name;
        }
        return response()->json($items);
    }

    public function getPawnedItemCalculations($package_id, $amount)
    {
        //  $dt = Carbon::now();
        $dt = Carbon::now('Asia/Manila');
        $package = zPackage::find($package_id);
        $durations = $package->durations;
        $specials = [];
        $monthly = [];
        $data = [];
        $dt->subDays(1);
        if ($package->if_has_special_offer == 1) {
            foreach ($durations as $key => $duration) {
                $dt->addDays(1);
                $dateFrom = $dt;
                $from = $dateFrom->format('M.d,Y');
                $number_of_days = (($duration->duration_to) - $duration->duration_from);
                $dateTo = $dt->addDays($number_of_days);
                $to = $dateTo->format('M.d,Y');
                $interest = $duration->interestRate / 100;
                $renewal = ($amount * $interest);
                $claim_without_advance_interest = ($amount + $renewal);
                // if ($package->if_advance_interest == 1) {
                $interest_percentage = $package->interest_per_month / 100;
                $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
                // }
                if ($package->if_advance_interest == 1) {
                    $redemption = $claim_with_advance_interest;
                 }else{
                    $redemption = $claim_without_advance_interest;
                 }
                $obj = array(
                    'index' => $key,
                    'from' => $from,
                    'to' => $to,
                    'number_of_days' => ($number_of_days + 1),
                    'interest' => $duration->interestRate,
                    'renewal' => $renewal,
                    'claim_without_advance_interest' => $claim_without_advance_interest,
                    'claim_with_advance_interest' =>  $claim_with_advance_interest,
                    'redemption' => $redemption
                );
                array_push($specials, $obj);
            }
        }



        // For Monthly Calculation

        $dt2 = Carbon::now('Asia/Manila');
        $number_of_month = $package->number_of_month;

        if ($package->if_has_special_offer == 1) {
            $index = 1;
            $dt2->addMonth();
        } else {
            $index = 0;

        }
        for ($i = $index; $i < $number_of_month; $i++) {
            $month = $dt2->addMonth();
            $interest = ($package->interest_per_month * ($i + 1)) / 100;
            $pinalty = ($package->pinalty_per_month * $i) / 100;
            $total_interest_rate = $interest + $pinalty;
            $total_interest = ($package->interest_per_month * ($i + 1)) + ($package->pinalty_per_month * $i);
            $renewal = ($amount * $interest) + ($amount * $pinalty);

            $claim_without_advance_interest  = $amount + $renewal;
            // if ($package->if_advance_interest == 1) {
            $interest_percentage = $package->interest_per_month / 100;
            $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
            // }
            if ($package->if_advance_interest == 1) {
                $redemption = $claim_with_advance_interest;
            } else {
                $redemption = $claim_without_advance_interest;
            }

            $obj = array(
                'index' => $i,
                'month' => $month->format('M.d,Y'),
                'total_interest' => $total_interest,
                'total_interest_rate' => $total_interest_rate,
                'amount' => $amount,
                'interest_per_month' => $package->interest_per_month,
                'interest' => $interest,
                'penalty' => $pinalty,
                'renewal' => $renewal,
                'claim_without_advance_interest' => $claim_without_advance_interest,
                'claim_with_advance_interest' =>  $claim_with_advance_interest,
                'redemption' => $redemption
            );
            array_push($monthly, $obj);
        }
        $obj = array(
            'package' => $package,
            'specials' => $specials,
            'monthly' => $monthly,
        );
        array_push($data, $obj);
        return response()->json($data);
    }

    public function getPawnedItemPaymentDetails($package_id, $amount, $date)
    {
        $dt = Carbon::parse($date);
        $datePawned = Carbon::parse($date);
        // $dateNow = Carbon::now('Asia/Manila');

        // $dt = Carbon::now('Asia/Manila');
        $package = zPackage::find($package_id);
        $durations = $package->durations;
        $specials = [];
        $monthly = [];
        $data = [];
        $dt->subDays(1);

        $dateNow = Carbon::now('Asia/Manila');
        // $dateNow = Carbon::parse('2020-02-10 14:50:11');
        $stop = false;
        $currentPayment = 0;
        $currentInterest = 0;
        $currentRenewal = 0;



        if ($package->if_has_special_offer == 1) {
            foreach ($durations as $key => $duration) {
                $dt->addDays(1);
                $dateFrom = $dt;
                $from = $dateFrom->format('M.d,Y');
                $number_of_days = (($duration->duration_to) - $duration->duration_from);
                $dateTo = $dt->addDays($number_of_days);

                $to = $dateTo->format('M.d,Y');
                $interest = $duration->interestRate / 100;
                $renewal = ($amount * $interest);
                $claim_without_advance_interest = ($amount + $renewal);
                // if ($package->if_advance_interest == 1) {
                $interest_percentage = $package->interest_per_month / 100;
                $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
                // }
                if ($package->if_advance_interest == 1) {
                    $redemption = $claim_with_advance_interest;
                 }else{
                    $redemption = $claim_without_advance_interest;
                 }

                if($dateNow <= $dateTo &&  $stop == false){
                    $currentPayment = $redemption;
                    $currentInterest = $duration->interestRate;
                    $currentRenewal = $renewal;
                    $stop = true;
                }




                $obj = array(
                    'index' => $key,
                    'from' => $from,
                    'to' => $to,
                    'number_of_days' => ($number_of_days + 1),
                    'interest' => $duration->interestRate,
                    'renewal' => $renewal,
                    'claim_without_advance_interest' => $claim_without_advance_interest,
                    'claim_with_advance_interest' =>  $claim_with_advance_interest,
                    'redemption' => $redemption
                );
                array_push($specials, $obj);
            }
        }


        // FOR MONTHLY CALCULATION

        // $dt2 = Carbon::now('Asia/Manila');
        $dt2 = Carbon::parse($date);
        $number_of_month = $package->number_of_month;

        if ($package->if_has_special_offer == 1) {
            $index = 1;
            $dt2->addMonth();
        } else {
            $index = 0;
        }
        // $index=0;
        for ($i = $index; $i < $number_of_month; $i++) {
            $month = $dt2->addMonth();
            $interest = ($package->interest_per_month * ($i + 1)) / 100;
            $pinalty = ($package->pinalty_per_month * $i) / 100;
            $total_interest_rate = $interest + $pinalty;
            $total_interest = ($package->interest_per_month * ($i + 1)) + ($package->pinalty_per_month * $i);
            $renewal = ($amount * $interest) + ($amount * $pinalty);

            $claim_without_advance_interest  = $amount + $renewal;
            // if ($package->if_advance_interest == 1) {
            $interest_percentage = $package->interest_per_month / 100;
            $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
            // }
            if ($package->if_advance_interest == 1) {
                $redemption = $claim_with_advance_interest;
            } else {
                $redemption = $claim_without_advance_interest;
            }

            if($dateNow <= $month &&  $stop == false){
                $currentPayment = $redemption;
                $currentInterest = $package->interest_per_month;
                $currentRenewal = $renewal;
                $stop = true;
            }

            $obj = array(
                'index' => $i,
                'month' => $month->format('M.d,Y'),
                'total_interest' => $total_interest,
                'total_interest_rate' => $total_interest_rate,
                'amount' => $amount,
                'interest_per_month' => $package->interest_per_month,
                'interest' => $interest,
                'penalty' => $pinalty,
                'renewal' => $renewal,
                'claim_without_advance_interest' => $claim_without_advance_interest,
                'claim_with_advance_interest' =>  $claim_with_advance_interest,
                'redemption' => $redemption
            );
            array_push($monthly, $obj);
        }
        $obj = array(
            'date_now' => $dateNow->format('M d, Y'),
            'current_renewal' => $currentRenewal,
            'current_payment' => $currentPayment,
            'current_interest_rate' => $currentInterest,
            'specials' => $specials,
            'monthly' => $monthly,
            'package' => $package,

        );
        array_push($data, $obj);
        return response()->json($data);
    }


       // echo $dt->addMonths(60);                 // 2017-01-31 00:00:00
        // echo $dt->addMonth();                    // 2017-03-03 00:00:00 equivalent of $dt->month($dt->month + 1); so it wraps
        // echo $dt->subMonth();                    // 2017-02-03 00:00:00
        // echo $dt->subMonths(60);                 // 2012-02-03 00:00:00
        // echo $dt->addDays(29);                   // 2012-03-03 00:00:00
        // echo $dt->addDay();                      // 2012-03-04 00:00:00
        // echo $dt->subDay();                      // 2012-03-03 00:00:00
        // echo $dt->subDays(29);
        //  $firstDayofPreviousMonth = $now->startOfMonth()->toDateString();
        //             $lastDayofPreviousMonth = $now->endOfMonth()->toDateString();
        //             $month = $PreviousMonth->month;
        //             $year = $PreviousMonth->year;


         // public function zSavePackage(Request $request)
    // {
    //     DB::transaction(function () use ($request) {
    //         $pack = new zPackage;
    //         $pack->pawnshop_id = $request->pawnshop_id;
    //         $pack->package_name =  $request->package_name;
    //         $pack->package_desc =  $request->package_desc;
    //         $pack->number_of_month =  $request->number_of_month;
    //         $pack->interest_per_month =  $request->interest_per_month;
    //         $pack->pinalty_per_month =  $request->pinalty_per_month;
    //         $pack->if_advance_interest =  $request->if_advance_interest;
    //         $count = count($request->durations);
    //         if ($count > 0) {
    //             $pack->if_has_special_offer = 1;
    //         } else {
    //             $pack->if_has_special_offer = 0;
    //         }
    //         $pack->save();
    //         foreach ($request->durations as $key => $duration) {
    //             // $dur = new zPackageDuration;

    //             $dur = new tbl_package_duration;
    //             $dur->package_id = $pack->id;
    //             $dur->from = $duration['from'];
    //             $dur->to = $duration['to'];
    //             $dur->interest = $duration['interest'];
    //             $dur->save();
    //         }
    //     });
    // }


    ///// Version 3



    public function zSavePawnedItem(Request $request)
    {
        // DB::transaction(function () use ($request) {

           DB::beginTransaction();

            if($request->days_deadline == "" || $request->days_deadline == null  ){
                $days_deadline = 3;
            }else{
                if($request->days_deadline > 15){
                    $days_deadline = 15;
                }else{
                    $days_deadline = $request->days_deadline;
                }
            }


            $pawned = new zPawnedItem;
            $pawned->item_id = $request->item_id;
            $pawned->pawnshop_id =  $request->pawnshop_id;
            $pawned->customer_id =  $request->customer_id;
            $pawned->package_id =  $request->package_id;
            $pawned->pawn_amount =  $request->pawn_amount;
            $pawned->date_pawned =  Carbon::now('Asia/Manila')->format('Y-m-d H:i:s');
            $pawned->date_renew =  Carbon::now('Asia/Manila');
            $pawned->days_deadline =   $days_deadline;
            // $pawned->date_claimed =  Carbon::now('Asia/Manila');
            $pawned->is_claimed = 0;
            $pawned->is_confiscated = 0;
            $pawned->save();

            $test = $pawned;

            $item = tbl_user_itempost::find($request->item_id);
            $item->status = 2;
            $item->save();

            // DB::rollback();
            DB::commit();
            return $test;

            //Create Pdf


        // });
    }

    public function getPdf(Request $request){

        $epawn_logo = public_path('/icon.png');
        $pawnshop = tbl_user::where('user_id', $request->pawnshop_id)->first();
        $customer = tbl_user::where('user_id', $request->customer_id)->first();
        $amount = number_format( $request->amount,2);

        $item = tbl_user_itempost::find($request->item_id);
        $pawned = zPawnedItem::find($request->zpawneditem_id);
        $details = $this->getPawnedItemPaymentDetailsForPDFandEMail($request->package_id, $request->amount, $request->date);

        // dd($item);
        // dd($pawnshop->atr_image_link);
        // dd($details['monthly']);
        $class = new stdClass;
        $class->epawn_logo = $epawn_logo;
        $class->pawnshop = $pawnshop;
        $class->customer = $customer;
        $class->details = $details;
        // $class->monthly = $details;
        $class->printed = Carbon::now('Asia/Manila')->format('m/d/Y');
        $class->datePawned = Carbon::parse($request->date)->format('M.d,Y');
        $class->item_name = $item->item_name;
        $class->item_desc = $item->item_description;
        $class->amount = $amount;
        $class->number = $pawned->id;
        // $class->number = 12345;
        $class->dateRenew = "";

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send(
            'emails.acceptrenew',
            ['class' => $class],
            function ($message) use ($class, $customer) {
                $message
                    ->from('epawn.online01@gmail.com', 'E-PAWN')
                    ->to($customer->email, $customer->fname)
                    ->subject('E-pawn Accept Pawned Item');
            }
        );


        $pdf = PDF::loadView('pdf.accept-pdf', compact('class'))->setPaper('a4', 'landscape');
        return $pdf->download('accept.pdf');
    }


    public function getPdfRenew(Request $request){

        $epawn_logo = public_path('/icon.png');
        $pawnshop = tbl_user::where('user_id', $request->pawnshop_id)->first();
        $customer = tbl_user::where('user_id', $request->customer_id)->first();
        $amount = number_format( $request->amount,2);

        $item = tbl_user_itempost::find($request->item_id);
        $pawned = zPawnedItem::find($request->zpawneditem_id);
        $details = $this->getPawnedItemPaymentDetailsForPDFandEMail($request->package_id, $request->amount, $pawned->date_renew);

        // dd($item);
        // dd($pawnshop->atr_image_link);
        // dd($details['monthly']);
        $class = new stdClass;
        $class->epawn_logo = $epawn_logo;
        $class->pawnshop = $pawnshop;
        $class->customer = $customer;
        $class->details = $details;
        // $class->monthly = $details;
        $class->printed = Carbon::now('Asia/Manila')->format('m/d/Y');
        $class->datePawned = Carbon::parse($pawned->date_pawned)->format('M.d,Y');
        $class->item_name = $item->item_name;
        $class->item_desc = $item->item_description;
        $class->amount = $amount;
        $class->number = $pawned->id;
        // $class->number = 12345;
        $class->dateRenew = "Date Renew: ". Carbon::parse($pawned->date_renew)->format('M.d,Y');

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send(
            'emails.acceptrenew',
            ['class' => $class],
            function ($message) use ($class, $customer) {
                $message
                    ->from('epawn.online01@gmail.com', 'E-PAWN')
                    ->to($customer->email, $customer->fname)
                    ->subject('E-pawn Renew Pawned Item');
            }
        );


        $pdf = PDF::loadView('pdf.accept-pdf', compact('class'))->setPaper('a4', 'landscape');
        return $pdf->download('accept.pdf');
    }

    public function getPdfClaim(Request $request){

        $epawn_logo = public_path('/icon.png');
        $pawnshop = tbl_user::where('user_id', $request->pawnshop_id)->first();
        $customer = tbl_user::where('user_id', $request->customer_id)->first();
        $amount = number_format( $request->amount,2);

        $item = tbl_user_itempost::find($request->item_id);
        $pawned = zPawnedItem::find($request->zpawneditem_id);
        $details = $this->getPawnedItemPaymentDetailsForPDFandEMail($request->package_id, $request->amount, $pawned->date_renew);

        // dd($item);
        // dd($pawnshop->atr_image_link);
        // dd($details['monthly']);
        $class = new stdClass;
        $class->epawn_logo = $epawn_logo;
        $class->pawnshop = $pawnshop;
        $class->customer = $customer;
        $class->details = $details;
        // $class->monthly = $details;
        $class->printed = Carbon::now('Asia/Manila')->format('m/d/Y');
        $class->datePawned = Carbon::parse($pawned->date_pawned)->format('M.d,Y');
        $class->item_name = $item->item_name;
        $class->item_desc = $item->item_description;
        $class->amount = $amount;
        $class->number = $pawned->id;
        $class->current_interest_rate = $request->current_interest_rate;
        $class->current_payment = number_format($request->current_payment,2);
        // $class->number = 12345;
        $class->dateRenew = "Date Renew: ". Carbon::parse($pawned->date_renew)->format('M.d,Y');


        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send(
            'emails.claim',
            ['class' => $class],
            function ($message) use ($class, $customer) {
                $message
                    ->from('epawn.online01@gmail.com', 'E-PAWN')
                    ->to($customer->email, $customer->fname)
                    ->subject('E-pawn Claim Pawned Item');
            }
        );


        $pdf = PDF::loadView('pdf.claim-pdf', compact('class'))->setPaper('a4', 'landscape');
        return $pdf->download('claim.pdf');
    }



    public function getPdfDataJson(){
        $details = $this->getPawnedItemPaymentDetailsForPDFandEMail(2, 3000, "2021-02-15 14:18:21");
        return response()->json($details, 200);
    }

    public function getPawnedItemPaymentDetailsForPDFandEMail($package_id, $amount, $date)
    {
        $dt = Carbon::parse($date);
        $datePawned = Carbon::parse($date);
        // $dateNow = Carbon::now('Asia/Manila');

        // $dt = Carbon::now('Asia/Manila');
        $package = zPackage::find($package_id);
        $durations = $package->durations;
        $specials = [];
        $monthly = [];
        $data = [];
        $dt->subDays(1);

        $dateNow = Carbon::now('Asia/Manila');
        // $dateNow = Carbon::parse('2020-02-10 14:50:11');
        $stop = false;
        $currentPayment = 0;
        $currentRenewal = 0;



        if ($package->if_has_special_offer == 1) {
            foreach ($durations as $key => $duration) {
                $dt->addDays(1);
                $dateFrom = $dt;
                $from = $dateFrom->format('M.d,Y');
                $number_of_days = (($duration->duration_to) - $duration->duration_from);
                $dateTo = $dt->addDays($number_of_days);

                $to = $dateTo->format('M.d,Y');
                $interest = $duration->interestRate / 100;
                $renewal = ($amount * $interest);
                $claim_without_advance_interest = ($amount + $renewal);
                // if ($package->if_advance_interest == 1) {
                $interest_percentage = $package->interest_per_month / 100;
                $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
                // }
                if ($package->if_advance_interest == 1) {
                    $redemption = $claim_with_advance_interest;
                 }else{
                    $redemption = $claim_without_advance_interest;
                 }

                if($dateNow <= $dateTo &&  $stop == false){
                    $currentPayment = $redemption;
                    $currentRenewal = $renewal;
                    $stop = true;
                }




                $obj = array(
                    'index' => $key,
                    'from' => $from,
                    'to' => $to,
                    'number_of_days' => ($number_of_days + 1),
                    'interest' => $duration->interestRate,
                    'renewal' => $renewal,
                    'renewal_f' => number_format($renewal,2),
                    'claim_without_advance_interest' => $claim_without_advance_interest,
                    'claim_with_advance_interest' =>  $claim_with_advance_interest,
                    'redemption' => $redemption,
                    'redemption_f' => number_format($redemption,2),
                );
                array_push($specials, $obj);
            }
        }


        // FOR MONTHLY CALCULATION

        // $dt2 = Carbon::now('Asia/Manila');
        $dt2 = Carbon::parse($date);
        $number_of_month = $package->number_of_month;

        if ($package->if_has_special_offer == 1) {
            $index = 1;
            $dt2->addMonth();
        } else {
            $index = 0;
        }
        // $index=0;
        for ($i = $index; $i < $number_of_month; $i++) {
            $month = $dt2->addMonth();
            $interest = ($package->interest_per_month * ($i + 1)) / 100;
            $pinalty = ($package->pinalty_per_month * $i) / 100;
            $total_interest_rate = $interest + $pinalty;
            $total_interest = ($package->interest_per_month * ($i + 1)) + ($package->pinalty_per_month * $i);
            $renewal = ($amount * $interest) + ($amount * $pinalty);

            $claim_without_advance_interest  = $amount + $renewal;
            // if ($package->if_advance_interest == 1) {
            $interest_percentage = $package->interest_per_month / 100;
            $claim_with_advance_interest = $claim_without_advance_interest - ($amount * $interest_percentage);
            // }
            if ($package->if_advance_interest == 1) {
                $redemption = $claim_with_advance_interest;
            } else {
                $redemption = $claim_without_advance_interest;
            }

            if($dateNow <= $month &&  $stop == false){
                $currentPayment = $redemption;
                $currentRenewal = $renewal;
                $stop = true;
            }

            $obj = array(
                'index' => $i,
                'month' => $month->format('M.d,Y'),
                'total_interest' => $total_interest,
                'total_interest_rate' => $total_interest_rate,
                'amount' => $amount,
                'interest_per_month' => $package->interest_per_month,
                'interest' => $interest,
                'penalty' => $pinalty,
                'renewal' => $renewal,
                'renewal_f' => number_format($renewal,2),
                'claim_without_advance_interest' => $claim_without_advance_interest,
                'claim_with_advance_interest' =>  $claim_with_advance_interest,
                'redemption' => $redemption,
                'redemption_f' => number_format($redemption,2),
            );
            array_push($monthly, $obj);
        }
        // $obj = array(
        //     'date_now' => $dateNow->format('M d, Y'),
        //     'current_renewal' => $currentRenewal,
        //     'current_payment' => $currentPayment,
        //     'specials' => $specials,
        //     'monthly' => $monthly,
        //     'package' => $package,

        // );
        // array_push($data, $obj);
        $class =  new stdClass;
        $class->date_now =  $dateNow->format('M d, Y');
        $class->current_renewal =  $currentRenewal;
        $class->current_payment =  $currentPayment;
        $class->specials = $specials;
        $class->monthly = $monthly;
        $class->package = $package;
        // $class->datePawned = $datePawned;

        return $class;
        // return response()->json($data);
    }

}

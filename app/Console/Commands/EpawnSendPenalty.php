<?php

namespace App\Console\Commands;

use App\zPackage;
use App\zPawnedItem;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EpawnSendPenalty extends Command
{
    protected $signature = 'epawn:send-penalty';
    protected $description = 'Send Penalty Warning';
    protected $last_due_date = "";
    protected $warning_date = "";
    protected $renewalPayment = 0;
    protected $claimPayment = 0;
    protected $overdue = "";
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        print("\n Start Warning For Payments and penalty ");

        $pawned_item = zPawnedItem::all()
            ->where('is_confiscated', 0)
            ->where('is_claimed', 0)
            ->where('is_rejected', 0);
        // return response()->json($pawned_item);
        $duedates = [];
        $dateNow = Carbon::now('Asia/Manila');
        $strDateNow = $dateNow->format('M.d,Y');
        $dateNowParse = Carbon::parse($strDateNow);


        foreach ($pawned_item as $key => $value) {

            $this->getPawnedItemPaymentDetails($value->package_id, $value->pawn_amount, $value->date_renew);
            $warningDate = Carbon::parse($this->warning_date);
            $warningDate->subDays($value->days_deadline);
            $final_warning_date = $warningDate->format('M.d,Y');
            $final_warning_date = Carbon::parse($final_warning_date);

            if ($this->overdue == 'false') {
                if ($value->is_confiscated == 0) {
                    if ($final_warning_date == $dateNowParse) {
                        $obj = array(
                            'pawned_id' => $value->id,
                            'last_due_date' => $this->last_due_date,
                            'current_due' => $this->warning_date,
                            'item_id' => $value->item_id,
                            'item' => $value->item->item_name,
                            'customer' => $value->customer->username,
                            'customer_phone' => $value->customer->contact,
                            'customer_email' => $value->customer->email,
                            'renewal_payment' =>  $this->renewalPayment,
                            'claim_payment' => $this->claimPayment,
                            'pawnshop' => $value->pawnshop->username,
                        );
                        array_push($duedates, $obj);
                    }
                };
            }
        }

        print("\n \t items:" . sizeof($duedates));
        foreach ($duedates as $key => $value) {
            sleep(5);
            ///Send Email
            $customer_email = $value['customer_email'];
            $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
            $beautymail->send(
                'emails.warning',
                [
                    'customer' =>  $value['customer'],
                    'item' => $value['item'],
                    'pawnshop' => $value['pawnshop'],
                    'duedate' => $value['current_due'],
                    'claim_payment' => $value['claim_payment'],
                    'renewal_payment' => $value['renewal_payment']
                ],

                function ($message) use ($customer_email) {
                    $message
                        ->from('epawn.online01@gmail.com', 'E-PAWN')
                        ->to($customer_email)
                        ->subject('E-pawn Confiscation Warning!');
                }
            );
            print("\n \t\t Item id:" . $value['item_id'] 
            . "/ Pawned id:" . $value['pawned_id'] 
            . "/ current due date:" . $value['current_due'] 
            .  " / Item:" . $value['item']
            .  " / Payments:" . $value['claim_payment'] ." | ". $value['renewal_payment'] );
        }

        print("\n Successfully Confiscate Items " . $strDateNow);
    }

    public function getPawnedItemPaymentDetails($package_id, $amount, $date)
    {


        $dt = Carbon::parse($date);
        $datePawned = Carbon::parse($date);
        // $dateNow = Carbon::now('Asia/Manila');

        // $dt = Carbon::now('Asia/Manila');
        $package = zPackage::find($package_id);

        $durations = $package->durations;
        $durations_count = $package->durations->count();
        $specials = [];
        $monthly = [];
        $data = [];
        $dt->subDays(1);

        $dateNow = Carbon::now('Asia/Manila');
        // $dateNow = Carbon::parse('2020-02-10 14:50:11');
        $stop = false;
        $overdue = "true";
        $currentPayment = 0;
        $currentRenewal = 0;
        $PenaltyLizeDate = "";



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
                } else {
                    $redemption = $claim_without_advance_interest;
                }

                if ($dateNow <= $dateTo &&  $stop == false) {
                    $currentPayment = $redemption;
                    $currentRenewal = $renewal;
                    // $PenaltyLizeDate = $to;
                    $stop = true;
                    $overdue = "false";
                }
                if ($key == $durations_count - 1) {
                    $this->last_due_date = $to;
                }
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

            if ($dateNow <= $month &&  $stop == false) {
                $currentPayment = $redemption;
                $currentRenewal = $renewal;
                $PenaltyLizeDate = $month->format('M.d,Y');
                $stop = true;
                $overdue = "false";
            }
            if ($i == $number_of_month - 1) {
                $this->last_due_date = $month->format('M.d,Y');
            }
        }
        // print("\n ".$overdue );

        $this->warning_date = $PenaltyLizeDate;
        $this->renewalPayment = $currentRenewal;
        $this->claimPayment = $currentPayment;
        $this->overdue = $overdue;
    }
}

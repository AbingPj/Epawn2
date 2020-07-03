<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;
use App\tbl_user;
use Nexmo\Laravel\Facade\Nexmo;
use App\Events\EpawnEvent;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function getUserDetails($userId)
    {
        return DB::table('tbl_users')->where('user_id', '=', $userId)->get();
    }
    public function loginUser(Request $request)
    {
        return DB::table('tbl_users')
            ->where('email', '=', $request->username)
            ->where('password', '=', $request->password)
            ->get();
    }
    public function saveProfileImage(Request $request)
    {
        $uploadDir = "images/";
        if ($request->file('profile') !== null) {
            $imageProfile = $request->file('profile');
            $imageProfileSanitizedName =  $imageProfile->getClientOriginalName();
            $imageProfile->move($uploadDir, $imageProfileSanitizedName);
        } else {
            $imageProfileSanitizedName = 'no-profile.png';
        }
    }
    public function verifyUserCode(Request $request)
    {
        return  DB::table('tbl_users')->where('email', '=', $request->email)
            ->where('confirmation_code', '=', $request->code)
            ->update(['is_email_verified' => 1]);
    }
    public function changeProfile(Request $request)
    {



        return DB::table('tbl_users')
            ->where('user_id', '=', $request->userId)
            ->update([
                'fname' => $request->fname,
                'address' => $request->address,
                'control_num' => $request->control_num,
                'business_permit' => $imagePermitSanitizedName,
                'contact' => $request->contact,
                'image' => $request->profile,
                'monthCofescation' =>  $request->confiscated
            ]);
    }

    public function changeUserProfile(Request $request)
    {

        $uploadDir = "images/";

        if ($request->file('profile') !== null) {
            $imagePermit = $request->file('profile');
            $imagePorifleSanitizedName = time() . $imagePermit->getClientOriginalName();
            $imagePermit->move($uploadDir, $imagePorifleSanitizedName);
        } else {
            $imagePorifleSanitizedName = 'no-image.png';
        }

        return DB::table('tbl_users')
            ->where('user_id', '=', $request->userId)
            ->update([
                'fname' => $request->fname,
                'address' => $request->address,
                'email' => $request->email,
                'contact' => $request->contact,
                'image' => $request->profile
            ]);
    }


    /// modified by abing (March 8, 2020)
    public function addUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'username' => 'required',
            'contact' => 'required|min:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => 'validation fail',
            ]);
        } else {
            $count = tbl_user::all()->where('email', $request->email)->count();
            if ($count > 0) {
                $exist = tbl_user::all()->where('email', $request->email)->first();
                return response()->json([
                    'user' =>  $exist,
                ]);
            } else {
                $lastTenDigits = substr($request->contact, -10);
                $newContact = '63' . $lastTenDigits;

                $digits = 5;
                $confirmation_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

                $user = new tbl_user;
                $user->fname = $request->username;
                $user->password = $request->password;
                $user->email = $request->email;
                $user->address = $request->address;
                $user->username = $request->username;
                $user->latitude = $request->lat;
                $user->longtitude = $request->long;
                $user->role_id = 3;
                $user->confirmation_code = $confirmation_code;
                $user->is_email_verified = 0;
                $user->contact = $newContact;
                $user->save();

                ///Send Email
                $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                $beautymail->send(
                    'emails.verification',
                    ['user' => $user],
                    function ($message) use ($user) {
                        $message
                            ->from('epawn.online01@gmail.com', 'E-PAWN')
                            ->to($user->email, $user->fname)
                            ->subject('E-pawn Email Verification!');
                    }
                );

                ///Send SMS 
                //if (
                //    $user->contact == '639507599270' ||
                //    $user->contact == '639068002030' ||
                //    $user->contact == '639564510415' ||
                //    $user->contact == '639381965306' ||
                //    $user->contact == '639666817407' ||
                //    $user->contact == '639309008864'
                //) {
                //    $basic  = new \Nexmo\Client\Credentials\Basic('7d5f097e', 'BA5EPguxLE0jbEed');
                //    $client = new \Nexmo\Client($basic);
                //    $message = "Hi " . $user->username . ", your registration code is: [   " . $user->confirmation_code . "  ]";
                //    $client->message()->send([
                //        'to' => $user->contact,
                //        'from' => 'E-pawn',
                //        'text' => $message
                //    ]);
                //}

                return response()->json([
                    'msg' => 'success',
                ]);
            }
        }
    }
    public function addStore(Request $request)
    {

        $uploadDir = "images/";
        $image = $request->file('permit');
        $imageSanitizedName = time() . $image->getClientOriginalName();
        $image->move($uploadDir, $imageSanitizedName);


        DB::table('tbl_users')->insert([
            'fname' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'contact' => $request->contact,
            'username' => $request->username,
            'control_num' => $request->control,
            'business_permit' => $imageSanitizedName,
            'latitude' => $request->lat,
            'longtitude' => $request->long,
            'address' => $request->address,
            'role_id' => '2'
        ]);
    }
    public function getPendingUsers(Request $request)
    {
        return DB::table('tbl_users')
            ->where('isValid', $request->status)
            ->where('role_id', '2')->get();
    }

    public function updateSatus(Request $request)
    {

        //added by abing 3/8/2020 10:43PM
        broadcast(new EpawnEvent('adminNotif'));

        //added by abing 3/12/2020 10:43PM
        $dateNow =  Carbon::now('Asia/Manila');
        if ($request->status == 1) {
            $nextMonth =  Carbon::now('Asia/Manila');
            $nextMonth->addMonth();
        } else {
            $nextMonth = "";
        }

        return DB::table('tbl_users')
            ->where('user_id', $request->userId)
            ->update([
                'isValid' => $request->status,
                'noticed' => date("Y-m-d H:i:s"),
                'expiration' => $nextMonth,
                'reason' => $request->reason
            ]);
            
    }
    public function changePassword(Request $request)
    {
        DB::table('tbl_users')
            ->where('user_id', $request->userId)
            ->update([
                'password' => $request->password
            ]);
    }
}

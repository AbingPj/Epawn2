<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllSeeder extends Seeder
{


    public function run()
    {





        Schema::disableForeignKeyConstraints();



        DB::table('tbl_bid_item')->truncate();
        DB::table('tbl_item_category')->truncate();
        DB::table('tbl_item_photo')->truncate();
        DB::table('tbl_package_duration')->truncate();
        DB::table('tbl_pawned_items')->truncate();
        DB::table('tbl_pawnshop_itemcategory')->truncate();
        DB::table('tbl_pawnshop_package')->truncate();
        DB::table('tbl_payment')->truncate();
        DB::table('tbl_users')->truncate();
        DB::table('tbl_user_itempost')->truncate();
        DB::table('tbl_user_reports')->truncate();
        DB::table('tbl_user_role')->truncate();
        DB::table('z_notifictions')->truncate();
        DB::table('z_packages')->truncate();
        DB::table('z_pawned_items')->truncate();
        DB::table('z_payments')->truncate();


        DB::table('tbl_users')->insert([
            'user_id' => 1,
            'fname' => 'admin',
            'gender_id' => 0,
            'username' => 'admin',
            'password' => 'admin',
            // 'address' => '',
            // 'contact' => '',
            'email' => 'admin@admin.com',
            // 'image' => '',
            // 'business_permit' => '',
            // 'control_num' => '',
            'role_id' => '1',
            // 'branch' => '',
            // 'latitude' => '',
            // 'longtitude' => '',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => '',
            'flag' => 0,
            'monthCofescation' => 0,
            // 'is_email_verified' => '',
            // 'confirmation_code' => '',
            // 'expiration' => '',
        ]);

        DB::table('tbl_users')->insert([
            'user_id' => 2,
            'fname' => 'Super Admin',
            'gender_id' => 0,
            'username' => 'Super Admin',
            'password' => 'admin',
            // 'address' => '',
            // 'contact' => '',
            'email' => 'admin@gmail.com',
            // 'image' => '',
            // 'business_permit' => '',
            // 'control_num' => '',
            'role_id' => 1,
            // 'branch' => '',
            // 'latitude' => '',
            // 'longtitude' => '',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => '',
            'flag' => 0,
            'monthCofescation' => 0,
            // 'is_email_verified' => '',
            // 'confirmation_code' => '',
            // 'expiration' => '',
        ]);


        $nextMonth =  Carbon::now('Asia/Manila');
        $nextMonth->addMonth();


        DB::table('tbl_users')->insert([
            'user_id' => 3,
            'fname' => 'RD Pawnshop',
            'gender_id' => 0,
            'username' => 'RD Pawnshop',
            'password' => 'rd123',
            'address' => 'Door 2, Building 1, Golden Matina Complex Building, 97 McArthur Highway, Matina, Davao City, 8000 Davao del Sur',
            'contact' => '09261143433',
            'email' => 'rd@gmail.com',
            'image' => 'seeds/1584585493Pinakamababa.png',
            'business_permit' => 'seeds/rdcon.jpg',
            'control_num' => '104006',
            'role_id' => 2,
            // 'branch' => '',
            'latitude' => '7.062819',
            'longtitude' => '125.598652',
            'isValid' => 1,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => date("Y-m-d H:i:s"),
            'noticed' => Carbon::now('Asia/Manila'),
            'flag' => 0,
            'monthCofescation' => 4,
            // 'is_email_verified' => '',
            // 'confirmation_code' => '',
            'expiration' => $nextMonth,
        ]);




        DB::table('tbl_users')->insert([
            'user_id' => 4,
            'fname' => 'MLHUILLIER',
            'gender_id' => 0,
            'username' => 'MLHUILLIER',
            'password' => 'ml123',
            'address' => 'UM Drive, Matina, Davao City, 8000 Davao del Sur',
            'contact' => '09197915459',
            'email' => 'ml@gmail.com',
            'image' => 'seeds/1583901019download.png',
            'business_permit' => 'seeds/mlcon.jpg',
            // 'control_num' => '',
            'role_id' => 2,
            // 'branch' => '',
            'latitude' => '7.063426',
            'longtitude' => '125.598706',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => date("Y-m-d H:i:s"),
            // 'noticed' => Carbon::now('Asia/Manila'),
            'flag' => 0,
            'monthCofescation' => 0,
            // 'is_email_verified' => '',
            // 'confirmation_code' => '',
            // 'expiration' => $nextMonth,
        ]);


        DB::table('tbl_users')->insert([
            'user_id' => 5,
            'fname' => 'Cebuana Lhuillier',
            'gender_id' => 0,
            'username' => 'Cebuana Lhuillier',
            'password' => 'cl123',
            'address' => 'Juna Avenue, corner McArthur Higway, Davao City, 8000 Davao del Sur',
            'contact' => '09381965306',
            'email' => 'cl@gmail.com',
            'image' => 'seeds/1583901232cebuana.png',
            'business_permit' => 'seeds/cbcon.jpg',
            // 'control_num' => '',
            'role_id' => 2,
            // 'branch' => '',
            'latitude' => '7.061738',
            'longtitude' => '125.593422',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => date("Y-m-d H:i:s"),
            // 'noticed' => Carbon::now('Asia/Manila'),
            'flag' => 0,
            'monthCofescation' => 0,
            // 'is_email_verified' => '',
            // 'confirmation_code' => '',
            // 'expiration' => $nextMonth,
        ]);



        DB::table('tbl_users')->insert([
            'user_id' => 6,
            'fname' => 'Abing Pj',
            'gender_id' => 0,
            'username' => 'Abing Pj',
            'password' => 'password',
            'address' => 'Matina, Davao City',
            'contact' => '639068002030',
            'email' => 'pj.abing@yahoo.com',
            'image' => 'seeds/user8-128x128',
            // 'business_permit' => '',
            // 'control_num' => '',
            'role_id' => 3,
            // 'branch' => '',
            'latitude' => '7.037520',
            'longtitude' => '125.576320',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => date("Y-m-d H:i:s"),
            // 'noticed' => Carbon::now('Asia/Manila'),
            'flag' => 0,
            'monthCofescation' => 0,
            'is_email_verified' => 1,
            'confirmation_code' => 88888,
            // 'expiration' => $nextMonth,
        ]);


        DB::table('tbl_users')->insert([
            'user_id' => 7,
            'fname' => 'Jeremiah Revil',
            'gender_id' => 0,
            'username' => 'Jeremiah Revil',
            'password' => '1234',
            'address' => 'Matina Pangi, Davao City',
            'contact' => '639507599270',
            'email' => 'maya_revil@yahoo.com',
            'image' => 'seeds/gray.jpg',
            // 'business_permit' => '',
            // 'control_num' => '',
            'role_id' => 3,
            // 'branch' => '',
            'latitude' => '7.061627',
            'longtitude' => '125.569936',
            'isValid' => 0,
            // 'reason' => '',
            'joined' => Carbon::now('Asia/Manila'),
            // 'noticed' => date("Y-m-d H:i:s"),
            // 'noticed' => Carbon::now('Asia/Manila'),
            'flag' => 0,
            'monthCofescation' => 0,
            'is_email_verified' => 1,
            'confirmation_code' => 12345,
            // 'expiration' => $nextMonth,
        ]);



        DB::table('tbl_item_category')->insert([
            'category_name' => 'Gold & Jewelries',
            'category_description' => 'Mga Gold og alahas',
            'valid' => '1',
            'fromUser' => '2',
        ]);
        DB::table('tbl_item_category')->insert([
            'category_name' => 'Gadgets / Devices',
            'category_description' => 'Mga gadgets',
            'valid' => '1',
            'fromUser' => '2',
        ]);

        DB::table('tbl_item_category')->insert([
            'category_name' => 'Appliances',
            'category_description' => 'Mga kagamitang de kuryente.',
            'valid' => '1',
            'fromUser' => '2',
        ]);


        DB::table('tbl_pawnshop_itemcategory')
        ->insert([
            'pawnshop_id' => 3,
            'category_id' => 1,
        ]);

        DB::table('tbl_pawnshop_itemcategory')
        ->insert([
            'pawnshop_id' => 3,
            'category_id' => 2,
        ]);



        DB::table('tbl_user_itempost')
        ->insert([
            'item_name' => 'Wedding Ring Classic Style',
            'item_description' => '2.5g pure saudi gold',
            'category_id' => 1,
            'user_id' => 7,
            'item_photo' =>'seeds/items/item1-1.jpg',
            'photo_1' =>'seeds/items/item1-1.jpg',
            'photo_2' =>'seeds/items/item1-2.jpg',
            'photo_3' =>'seeds/items/item1-3.jpg',
            'photo_4' =>'seeds/items/item1-4.jpg',
        ]);




        DB::table('tbl_user_itempost')
        ->insert([
            'item_name' => 'Engagement ring',
            'item_description' => '1.1 G',
            'category_id' => 1,
            'user_id' => 7,
            'item_photo' =>'seeds/items/item2-1.jpg',
            'photo_1' =>'seeds/items/item2-2.jpg',
            'photo_2' =>'seeds/items/item2-3.jpg',
            'photo_3' =>'seeds/items/item2-4.jpg',
            'photo_4' =>'seeds/items/item2-1.jpg',
        ]);

        DB::table('tbl_user_itempost')
        ->insert([
            'item_name' => 'Heart Necklace Gold',
            'item_description' => '18k saudi gold necklace',
            'category_id' => 1,
            'user_id' => 7,
            'item_photo' =>'seeds/items/item2-1.jpg',
            'photo_1' =>'seeds/items/item2-2.jpg',
            'photo_2' =>'seeds/items/item2-3.jpg',
            'photo_3' =>'seeds/items/item2-4.jpg',
            'photo_4' =>'seeds/items/item2-1.jpg',
        ]);

        DB::table('tbl_user_itempost')
        ->insert([
            'item_name' => 'Heart Necklace Gold',
            'item_description' => '18k saudi gold necklace',
            'category_id' => 1,
            'user_id' => 7,
            'item_photo' =>'seeds/items/item3-1.jpg',
            'photo_1' =>'seeds/items/item3-2.jpg',
            'photo_2' =>'seeds/items/item3-3.jpg',
            'photo_3' =>'seeds/items/item3-4.jpg',
            'photo_4' =>'seeds/items/item3-1.jpg',
        ]);


        Schema::enableForeignKeyConstraints();

    }
}

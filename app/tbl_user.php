<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_user extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $primaryKey  = 'user_id';

    public function reports()
    {
        return $this->hasMany('App\tbl_user_report', 'userId', 'user_id');
    }

    public function pawnshop_reports()
    {
        return $this->hasMany('App\tbl_user_report', 'pawnshopId', 'user_id');
    }

    public function pawnshop_notifications()
    {
        return $this->hasMany('App\zNotification', 'pawnshop_id', 'user_id');
    }

    public function packages()
    {
        return $this->hasMany('App\zPackage', 'pawnshop_id', 'user_id');
    }


    protected $appends = [
        'atr_image_link',
    ];

    public function getAtrImageLinkAttribute()
    {

        if (!empty($this->image)) {

            // // explode by /
            // $explode_path = explode('/', $this->image);
            // // removed first value in array wich is the public of the path
            // unset($explode_path[0]);
            // // return back to his format
            // $implode_path = implode('/', $explode_path);
            // $photo = url('storage/' . $implode_path);

            $photo = url('/images/'.$this->image);
        } else {
            // $photo = $this->is_bundle == 1 ? "/img/bundle.png" : "/img/no-product-image.png";
            $photo = "";
        }

        return $photo;
    }



}

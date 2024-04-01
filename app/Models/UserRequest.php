<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class UserRequest extends Model
{
    use HasFactory;

    public function vendors(){
        return $this->belongsTo(User::class,'vendor_id','id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id','id')->select('id','name','profile_image');
    }
    public function coupons(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
    public function vendorDetails(){
        return $this->belongsTo(User::class,'vendor_id','id')->with('reviewList',function($query){
            return $query->where('user_id',Auth::user()->id);
        });
    }
}

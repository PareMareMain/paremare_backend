<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Coupon extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['tag_name','what_inside','how_to_redeem','tag_title'];
    protected $appends = [
        'is_wishlist',
    ];
    public function scopeIsActive(){
        return $this->whereStatus('active');
    }
    public function vendorDetail(){
        return $this->belongsTo(User::class,'vendor_id','id')->select('id','name','profile_image','location');
    }
    public function scopeIsVendorsCoupons(){
        return $this->where('coupon_type','general')->where('user_type','vendor');
    }
    public function scopeIsAdminCoupons(){
        return $this->where('coupon_type','individual')->where('user_type','admin');
    }
    public function IsSaved(){
        $data=null;
        // $data = $this->hasOne(Wishlist::class,'vendor_id');
        if(Auth::check()){
            $data= Wishlist::where('coupon_id',$this->id)->where('user_id',Auth::user()->id)->first();
        }
        return $data;
    }
    public function getIsWishlistAttribute(){
        $data=$this->IsSaved();
        if($data){
            return true;
        }
        return false;
    }
}

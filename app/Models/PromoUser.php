<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'promo_id', 'transaction_id', 'price', 'discount', 'status'];

    public function user(){
        return $this->hasone(User::class,'id','user_id');
    }
    public function promo(){
        return $this->hasone(PromoCode::class,'id','promo_id');
    }
}

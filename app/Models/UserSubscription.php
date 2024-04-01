<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    public function plan(){
        return $this->hasMany(subscription::class, 'id', 'subscription_id');
    }
}

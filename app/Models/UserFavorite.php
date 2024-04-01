<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;

    public function vendors(){
        return $this->hasMany(User::class,'id','vendor_id');
    }
}

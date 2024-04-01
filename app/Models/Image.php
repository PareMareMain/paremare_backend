<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory,SoftDeletes;

    const STATE_PENDING = 0;

    const STATE_APPROVED = 1;

    public function vendor(){
        return $this->hasOne(User::class,'id','vendor_id');
    }
}

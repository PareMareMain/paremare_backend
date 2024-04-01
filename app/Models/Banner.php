<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Banner extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['name'];
    public function vendors(){
        return $this->belongsTo(User::class,'vendor_id','id');
    }
}

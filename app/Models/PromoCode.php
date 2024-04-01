<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['tag_title','promo_description'];
    protected $fillable = ['tag_title', 'promo_code', 'discount', 'promo_description', 'status'];
}

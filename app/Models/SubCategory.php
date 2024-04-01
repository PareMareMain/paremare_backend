<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    public $translatable = ['name'];
    protected $hidden = [
        'deleted_at',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function scopeIsActive(){
        return $this->whereStatus('active');
    }
}

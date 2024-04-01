<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;
    
    public $translatable = ['name'];
    protected $hidden = [
        'deleted_at',
    ];
    public function scopeIsActive(){
        return $this->whereStatus('active');
    }
    public function subcategory(){
        return $this->hasMany(SubCategory::class);
    }
}

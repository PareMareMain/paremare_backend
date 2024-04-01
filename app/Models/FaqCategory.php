<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use HasFactory,SoftDeletes,HasTranslations;

    protected $fillable = ['name','image','status'];

    public $translatable = ['name'];
    protected $hidden = [
        'deleted_at',
    ];
    public function scopeIsActive(){
        return $this->whereStatus('active');
    }

}

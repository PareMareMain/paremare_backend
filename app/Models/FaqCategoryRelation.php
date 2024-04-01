<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategoryRelation extends Model
{
    use HasFactory;

    protected $fillable = ['faq_id','category_id'];

}

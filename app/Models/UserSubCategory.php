<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'category_id', 'sub_category_id', 'sub_category_name', 'user_category_id'];
}

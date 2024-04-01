<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTag extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'tag_id'];

    public function category(){
        return $this->hasMany(Category::class,'id', 'category_id');
    }

    public function tag(){
        return $this->hasMany(tag::class,'id', 'tag_id');
    }
}

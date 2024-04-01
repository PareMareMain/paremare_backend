<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $appends = ['category_id'];


    public function category(){
        return $this->hasOne(FaqCategoryRelation::class,'faq_id');
    }

    public function getCategoryIdAttribute(){
        return ($this->category?$this->category->category_id:"");
    }

}

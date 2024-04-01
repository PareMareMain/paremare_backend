<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTag extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'tag_id'];

    public function tag(){
        return $this->hasMany(tag::class,'id', 'tag_id');
    }

}

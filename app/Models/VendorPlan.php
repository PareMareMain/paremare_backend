<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPlan extends Model
{
    use HasFactory;

    public function isActive(){
        return $this->status == 'active';
    }
}

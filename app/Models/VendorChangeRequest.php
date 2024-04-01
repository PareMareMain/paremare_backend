<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorChangeRequest extends Model
{
    use HasFactory;

    const STATE_PENDING = 0;

    const STATE_APPROVED = 1;

    const STATE_REJECTED = 2;

    protected $fillable = [
        'user_id',
        'field_name',
        'new_value',
        'is_approved'
    ];

    public function vendor(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

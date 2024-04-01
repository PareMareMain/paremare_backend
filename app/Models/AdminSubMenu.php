<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSubMenu extends Model
{
    use HasFactory;
    public function subMenu(){
        return $this->belongsTo(SubMenu::class,'sub_menu_id','id');
    }
}

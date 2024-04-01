<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    use HasFactory;

    public function children(){
        return $this->hasMany(AdminSubMenu::class)->with('subMenu');
    }
    public function menu(){
        return $this->belongsTo(Menu::class,'menu_id','id');
    }
}

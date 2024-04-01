<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    public function menu(){
        return $this->hasMany(AdminMenu::class);
    }
    public function submenu(){
        return $this->hasMany(SubMenu::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleAccess extends Model
{
    use HasFactory, SoftDeletes;

    public function role_name(){
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function sub_menu(){
        return $this->belongsTo(SubMenu::class, 'sub_menu_id', 'id');
    }

    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function main_menu(){
        return $this->belongsTo(MainMenu::class, 'main_menu_id', 'id');
    }

    public function deleted_actor(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function created_actor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_actor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}

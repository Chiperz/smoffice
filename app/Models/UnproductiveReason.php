<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnproductiveReason extends Model
{
    use HasFactory;

    public function created_actor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_actor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}

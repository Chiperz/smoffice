<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'nik',
        'phone',
        'address',
        'customer_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

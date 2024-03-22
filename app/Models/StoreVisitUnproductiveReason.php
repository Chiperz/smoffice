<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVisitUnproductiveReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_visit_id',
        'unproductive_reason_id'
    ];

    public function unproductive_reason(){
        return $this->belongsTo(UnproductiveReason::class, 'unproductive_reason_id', 'id');
    }
}
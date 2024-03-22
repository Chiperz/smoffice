<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletVisitUnproductiveReason extends Model
{
    use HasFactory;

    public function unproductive_reason(){
        return $this->belongsTo(UnproductiveReason::class, 'unproductive_reason_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailScheduleVisit extends Model
{
    use HasFactory;

    public function schedule(){
        return $this->belongsTo(ScheduleVisit::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}

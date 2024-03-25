<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOutletVisit extends Model
{
    use HasFactory;

    public function header_visit(){
        return $this->belongsTo(HeaderVisit::class, 'header_visit_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}

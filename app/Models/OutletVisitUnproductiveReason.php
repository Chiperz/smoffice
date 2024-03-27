<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OutletVisitUnproductiveReason extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['header_visit_id', 'unproductive_reason_id'])
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} data")
            ->useLogName('outlet_visit_unproductive_reason');
    }

    public function unproductive_reason(){
        return $this->belongsTo(UnproductiveReason::class, 'unproductive_reason_id', 'id');
    }
}

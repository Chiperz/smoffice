<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SegmentationUnproductiveReason extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} data")
            ->useLogName('segmentation-reason');
    }

    protected $fillable = [
        'name',
    ];

    public function unproductive_reason(){
        return $this->hasMany(UnproductiveReason::class, 'id', 'unproductive_reason_id');
    }

    public function store_reason(){
        return $this->hasManyThrough(
            StoreVisitUnproductiveReason::class, 
            UnproductiveReason::class, 
            'segmentation_id',
            'unproductive_reason_id',
            'id',
            'id');
    }
}

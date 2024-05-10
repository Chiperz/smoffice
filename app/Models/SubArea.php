<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SubArea extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions{
        return LogOptions::defaults()
            ->logOnly(['branch_id', 'area_id', 'name'])
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName} data")
            ->useLogName('sub_area');
    }
}

<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

trait LoggingTraits{
    public function createLog($activity, $userid,$log, $subject){
        activity($activity)
            ->causedBy($userid)
            // ->performedOn($content)
            ->log($log)
            ->subject($subject);
    }
}
<?php

use App\Models\ActivityLog;

function activity_log($action,$type,$id)
{

    ActivityLog::create([
        'user_id'=>auth()->id(),
        'action'=>$action,
        'subject_type'=>$type,
        'subject_id'=>$id
    ]);

}
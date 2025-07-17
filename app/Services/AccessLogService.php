<?php

namespace App\Services;

use App\Models\AccessLog;
use App\Models\Archive;

class AccessLogService
{
    public function logAccess(Archive $archive, string $action)
    {
        return AccessLog::create([
            'archive_id' => $archive->id,
            'action' => $action
        ]);
    }
} 
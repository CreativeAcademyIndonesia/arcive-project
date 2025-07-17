<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    protected $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    public function index()
    {
        $backups = $this->backupService->getBackupHistories();
        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        $result = $this->backupService->createBackup();

        if ($result['success']) {
            return redirect()->route('backup.index')->with('success', $result['message']);
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }

    public function restore($id)
    {
        $result = $this->backupService->restore($id);

        if ($result['success']) {
            return redirect()->route('backup.index')->with('success', $result['message']);
        }

        return redirect()->route('backup.index')->with('error', $result['message']);
    }
}

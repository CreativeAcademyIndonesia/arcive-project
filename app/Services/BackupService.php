<?php

namespace App\Services;

use App\Models\BackupHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupService
{
    public function createBackup()
    {
        try {
            // Generate nama file dengan timestamp
            $fileName = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            $filePath = 'backups/' . $fileName;

            // Dapatkan konfigurasi database
            $database = config('database.connections.mysql.database');
            $user = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Buat direktori backup jika belum ada
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            // Command untuk backup
            $command = sprintf(
                'mysqldump -u%s -p%s %s > %s',
                $user,
                $password,
                $database,
                storage_path('app/' . $filePath)
            );

            // Jalankan command backup
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                // Simpan record backup
                BackupHistory::create([
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'status' => 'success',
                    'notes' => 'Backup created successfully'
                ]);

                return [
                    'success' => true,
                    'message' => 'Backup berhasil dibuat',
                    'file_path' => $filePath
                ];
            }

            throw new \Exception('Backup failed');

        } catch (\Exception $e) {
            // Catat kegagalan
            BackupHistory::create([
                'file_name' => $fileName ?? 'unknown',
                'file_path' => $filePath ?? 'unknown',
                'status' => 'failed',
                'notes' => 'Error: ' . $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Backup gagal: ' . $e->getMessage()
            ];
        }
    }

    public function restore($backupId)
    {
        try {
            $backup = BackupHistory::findOrFail($backupId);
            
            if (!Storage::exists($backup->file_path)) {
                throw new \Exception('File backup tidak ditemukan');
            }

            // Dapatkan konfigurasi database
            $database = config('database.connections.mysql.database');
            $user = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Command untuk restore
            $command = sprintf(
                'mysql -u%s -p%s %s < %s',
                $user,
                $password,
                $database,
                storage_path('app/' . $backup->file_path)
            );

            // Jalankan command restore
            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return [
                    'success' => true,
                    'message' => 'Database berhasil di-restore ke backup ' . $backup->created_at
                ];
            }

            throw new \Exception('Restore failed');

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Restore gagal: ' . $e->getMessage()
            ];
        }
    }

    public function getBackupHistories()
    {
        return BackupHistory::where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->get();
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil 5 arsip terbaru
        $latestArchives = Archive::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Mengambil semua arsip untuk daftar lengkap
        $allArchives = Archive::orderBy('created_at', 'desc')->get();

        return view('dashboard', compact('latestArchives', 'allArchives'));
    }

    public function riwayat_akses()
    {
        $accessLogs = AccessLog::with('archive')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat.index', compact('accessLogs'));
    }
} 
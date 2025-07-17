<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Category;
use App\Services\AccessLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    protected $accessLogService;

    public function __construct(AccessLogService $accessLogService)
    {
        $this->accessLogService = $accessLogService;
    }

    public function index(Request $request)
    {
        $query = Archive::query();

        // Filter berdasarkan nama klien
        if ($request->filled('nama_klien')) {
            $query->where('nama_klien', 'like', '%' . $request->nama_klien . '%');
        }

        // Filter berdasarkan nomor akta
        if ($request->filled('nomor_akta')) {
            $query->where('nomor_akta', 'like', '%' . $request->nomor_akta . '%');
        }

        // Filter berdasarkan tanggal akta
        if ($request->filled('tanggal_akta')) {
            $query->whereDate('tanggal_akta', $request->tanggal_akta);
        }

        // Urutkan berdasarkan tanggal akta terbaru dan tambahkan pagination
        $archives = $query->orderBy('tanggal_akta', 'desc')->paginate(10);

        // Append query parameters ke pagination links
        $archives->appends($request->all());

        return view('archives.index', compact('archives'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama', 'asc')->get();
        return view('archives.create', compact('categories')); 
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nomor_akta' => 'required|string|max:255',
                'nama_klien' => 'required|string|max:255', 
                'jenis_dokumen' => 'required|string',
                'kategori_id' => 'required|exists:categories,id',
                'tanggal_akta' => 'required|date',
                'lampiran' => 'required|mimes:pdf|max:2048',
            ]);

            $file = $request->file('lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('arsip', $fileName, 'public');

            Archive::create([
                'nomor_akta' => $request->nomor_akta,
                'nama_klien' => $request->nama_klien,
                'jenis_dokumen' => $request->jenis_dokumen,
                'tanggal_akta' => $request->tanggal_akta,
                'kategori_id' => $request->kategori_id,
                'lampiran' => $path,
            ]);

            return redirect()->route('archives.index')
                ->with('success', 'Arsip berhasil ditambahkan.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log::error('Validation error: ' . $e->getMessage()); // Original code had this line commented out
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa kembali data yang dimasukkan.');
                
        } catch (\Exception $e) {
            // Log::error('Error storing archive: ' . $e->getMessage()); // Original code had this line commented out
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function viewPdf(Archive $archive)
    {
        $this->accessLogService->logAccess($archive, 'view');
        
        // Redirect ke URL file PDF
        return redirect(Storage::url($archive->lampiran));
    }

    public function show(Archive $archive)
    {
        $this->accessLogService->logAccess($archive, 'view');
        return view('archives.show', compact('archive'));
    }
    public function download(Archive $archive)
    {
        try {
            \Log::info('Mencoba mengunduh file: ' . $archive->lampiran);
            
            $this->accessLogService->logAccess($archive, 'download');
            
            $filePath = public_path('storage/' . $archive->lampiran);
            
            if (!file_exists($filePath)) {
                \Log::error('File tidak ditemukan: ' . $filePath);
                throw new \Exception('File tidak ditemukan');
            }

            \Log::info('Berhasil mengunduh file: ' . $archive->lampiran);
            return response()->download($filePath, $archive->nomor_akta . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('Gagal mengunduh file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh file. File tidak ditemukan atau rusak.');
        }
    }
    public function destroy(Archive $archive)
    {
        try {
            // Log the delete action first
            $this->accessLogService->logAccess($archive, 'delete');
            
            // Delete the archive record only
            $archive->delete();
            
            return redirect()->route('archives.index')->with('success', 'Arsip berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus arsip: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus arsip');
        }
    }
}

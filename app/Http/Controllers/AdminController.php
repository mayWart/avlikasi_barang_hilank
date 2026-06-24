<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA
        $totalUsers = User::count();
        $lostCount = Post::where('type', 'lost')->where('status', 'active')->count();
        $foundCount = Post::where('type', 'found')->where('status', 'active')->count();
        $resolvedCount = Post::where('status', 'resolved')->count();

        // 2. DATA LIVE LOG POSTINGAN TERBARU
        $recentPosts = Post::with('user')->latest()->take(5)->get();

        // 3. MANAJEMEN USER (Kecuali akun admin itu sendiri)
        $allUsers = User::where('email', '!=', 'admin@gmail.com')
                        ->where('name', '!=', 'Admin')
                        ->latest()->get();

        // 4. FILTER KONTEN SENSITIF (SARA, JUDI, SLOT, DLL)
        // Definisikan kata kunci blokir
        $badWords = ['judi', 'slot', 'sara', 'gacor', 'casino', 'taruhan', 'porn', 'open bo', 'bojo'];
        
        $flaggedPosts = Post::with('user')
            ->where(function($query) use ($badWords) {
                foreach($badWords as $word) {
                    $query->orWhere('item_name', 'LIKE', "%{$word}%")
                          ->orWhere('description', 'LIKE', "%{$word}%");
                }
            })->latest()->get();

        // 5. DATA UNTUK GRAFIK LINE CHART (TREN BULANAN)
        $currentYear = date('Y');
        $lostMonthly = Post::where('type', 'lost')->whereYear('created_at', $currentYear)->selectRaw('MONTH(created_at) as month, count(*) as count')->groupBy('month')->pluck('count', 'month')->toArray();
        $foundMonthly = Post::where('type', 'found')->whereYear('created_at', $currentYear)->selectRaw('MONTH(created_at) as month, count(*) as count')->groupBy('month')->pluck('count', 'month')->toArray();
        
        $chartLostData = []; $chartFoundData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartLostData[] = $lostMonthly[$m] ?? 0;
            $chartFoundData[] = $foundMonthly[$m] ?? 0;
        }

        // 6. DATA UNTUK GRAFIK DOUGHNUT (KATEGORI)
        $categoryDataGroup = Post::selectRaw('category, count(*) as count')->groupBy('category')->pluck('count', 'category')->toArray();
        $categoryLabels = ['Dompet & Tas', 'KTP & Dokumen', 'Kunci', 'Elektronik (HP/Laptop)', 'Kendaraan', 'Lainnya'];
        $chartCategoryData = [];
        foreach ($categoryLabels as $label) {
            $chartCategoryData[] = $categoryDataGroup[$label] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'lostCount', 'foundCount', 'resolvedCount', 'recentPosts',
            'allUsers', 'flaggedPosts', 'chartLostData', 'chartFoundData', 
            'categoryLabels', 'chartCategoryData'
        ));
    }

    // Fungsi menghapus akun pengguna oleh admin
    public function destroyUser(User $user)
    {
        // Proteksi ekstra agar tidak bisa menghapus admin utama
        if ($user->email === 'admin@adminsuper.com') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun administrator utama.');
        }

        $user->delete(); // Postingan milik user ini otomatis terhapus jika Anda memasang cascade di database
        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus secara permanen.');
    }
}
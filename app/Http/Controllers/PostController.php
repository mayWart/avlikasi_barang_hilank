<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Search dan Filter
        $query = Post::with('user')->latest();

        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $posts = $query->get();
        return view('dashboard', compact('posts'));
    }

    // ... (biarkan fungsi uploadImage tetap ada) ...

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:lost,found',
            'category' => 'required|string',
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url', 
            'wa_number' => 'required|string',
        ]);

        $formatted_wa = preg_replace('/^0/', '62', $request->wa_number);
        $formatted_wa = preg_replace('/[^0-9]/', '', $formatted_wa);

        Post::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'category' => $request->category,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'image_path' => $request->image_url, 
            'wa_number' => $formatted_wa,
            'status' => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Informasi berhasil disebarkan!');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function uploadImage(Request $request)
    {
        try {
            // 1. Validasi file
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // 2. ULTIMATE BYPASS: Koneksi manual langsung ke Cloudinary
            // Ini akan mengabaikan .env dan cache Laragon sepenuhnya
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => 'dkfrghcfu',
                    'api_key'    => '171859724341858',
                    'api_secret' => 'mjGkhE4_60BY-WoFduRcTHmZSas', // Pastikan teks ini tepat sesuai dengan rahasia di dashboard Anda
                ],
            ]);

            // 3. Eksekusi Upload
            $result = $cloudinary->uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'info_kehilangan'
            ]);

            // 4. Kembalikan URL yang sukses
            return response()->json([
                'success' => true,
                'url' => $result['secure_url']
            ]);

        } catch (\Exception $e) {
            // Tangkap jika masih ada error jaringan/autentikasi
            return response()->json([
                'success' => false,
                'message' => 'Error Server: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function markAsFound(Post $post)
    {
        if(auth()->id() !== $post->user_id) abort(403);
        $post->update(['status' => 'resolved']);
        return back()->with('success', 'Status barang telah diubah menjadi ditemukan!');
    }

   public function destroy(Post $post)
    {
        $isAdmin = auth()->user()->email === 'admin@adminsuper.com' || auth()->user()->name === 'admin';
        
        // Cek: Apakah dia pemilik ATAU dia admin?
        if (auth()->id() !== $post->user_id && !$isAdmin) {
            abort(403, 'Unauthorized action.');
        }
        
        $post->delete(); 
        return back()->with('success', 'Postingan berhasil dihapus.');
    }

    public function myPosts()
    {
        // Ambil postingan berdasarkan ID user yang sedang login
        $posts = Post::where('user_id', auth()->id())->latest()->get();
        
        return view('posts.my_posts', compact('posts'));
    }
}
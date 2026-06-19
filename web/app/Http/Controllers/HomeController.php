<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama SkinQuo.
     */
    public function index()
    {
        // =========================================================
        // CEK LOGIN ADMIN: 
        // Jika sudah login dan role-nya Admin, langsung lempar ke Dashboard Admin
        // =========================================================
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->role_id == 1 || ($user->role && $user->role->role_name === 'admin')) {
                return redirect()->route('admin.dashboard');
            }
        }

        // =========================================================
        // JIKA BUKAN ADMIN / BELUM LOGIN, TAMPILKAN HOMEPAGE BIASA
        // =========================================================
        
        // Menggunakan scope 'published' buatan temanmu yang sudah kita amankan
        $articles = Article::published()
                            ->latest('created_at')
                            ->take(8)
                            ->get();

        // Ambil feedback dengan rating >= 4 untuk Community Voices section
        // Menggunakan whereRaw agar aman dari bug konversi integer PDO di PostgreSQL
        $communityVoices = Feedback::with('user')
            ->whereNotNull('text')
            ->where('rating', '>=', 4)
            ->whereRaw('is_reviewed = true')
            ->latest('id')
            ->take(3)
            ->get();

        // Ambil 3 produk best seller
        $bestSellers = Product::orderByDesc('harga_max')
                              ->take(3)
                              ->get();

        if ($bestSellers->isEmpty()) {
            $bestSellers = collect([]);
        }

        return view('pages.home', compact('articles', 'communityVoices', 'bestSellers'));
    }
}
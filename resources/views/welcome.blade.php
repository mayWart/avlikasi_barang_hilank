<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Laporan Kehilangan & Penemuan Barang</title>

    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #030712; color: #e5e7eb; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Animations */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 10s infinite alternate; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        /* Glass Panel */
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-nav {
            background: rgba(3, 7, 18, 0.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="antialiased relative overflow-x-hidden selection:bg-blue-500/30 selection:text-blue-200">

    {{-- Decorative Glowing Orbs --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-blue-600/20 rounded-full mix-blend-screen filter blur-[120px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[35rem] h-[35rem] bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[45rem] h-[45rem] bg-purple-600/10 rounded-full mix-blend-screen filter blur-[120px] animate-blob animation-delay-4000"></div>
    </div>

    {{-- Navbar Corporate --}}
    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.4)]">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v2.25m0 0v2.25m0-2.25h-2.25m2.25 0h2.25" /></svg>
                    </div>
                    <span class="font-bold text-xl tracking-wide text-white">Lost<span class="text-blue-400">Found</span></span>
                </div>
                
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-300">
                    <a href="#fitur" class="hover:text-white transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-white transition-colors">Cara Kerja</a>
                    
                    <div class="h-6 w-px bg-white/10"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all border border-white/10">Ke Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-full shadow-[0_0_20px_rgba(79,70,229,0.4)] hover:shadow-[0_0_30px_rgba(79,70,229,0.6)] transition-all font-semibold transform hover:-translate-y-0.5 active:scale-95">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="relative z-10 pt-32 pb-16 lg:pt-40 lg:pb-24">
        
        {{-- HERO SECTION --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center animate-fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel border-blue-500/30 text-blue-400 text-sm font-semibold mb-8 shadow-[0_0_20px_rgba(59,130,246,0.15)]">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                </span>
                Platform Pintar Penemuan Barang
            </div>
            
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6">
                Temukan Kembali <br class="hidden md:block" />
                Barang Anda yang <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Hilang</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-400 leading-relaxed mb-10">
                Pusat informasi kehilangan dan penemuan barang tercepat dan terpercaya. Lapor, hubungi penemu, dan dapatkan barang Anda kembali dengan aman.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-900 font-bold rounded-2xl hover:bg-gray-100 shadow-[0_0_30px_rgba(255,255,255,0.3)] transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                    Mulai Buat Laporan
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
                <a href="#cara-kerja" class="w-full sm:w-auto px-8 py-4 glass-panel text-white font-bold rounded-2xl hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    Pelajari Cara Kerjanya
                </a>
            </div>

            {{-- Mockup / Preview Dashboard (Optional visual anchor) --}}
            <div class="mt-20 relative mx-auto w-full max-w-5xl animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2.5rem] blur opacity-20"></div>
                <div class="relative glass-panel rounded-[2rem] border border-white/10 shadow-2xl p-2 sm:p-4 bg-[#030712]/80 backdrop-blur-2xl">
                    <img src="https://images.unsplash.com/photo-1618761714954-0b8cd0026356?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="App Interface Preview" class="rounded-2xl w-full object-cover h-[300px] md:h-[500px] opacity-60 border border-white/5">
                    
                    {{-- Overlay elements to make it look like our app --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="glass-panel px-6 py-4 rounded-2xl flex items-center gap-4 shadow-2xl">
                            <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center border border-green-500/30">
                                <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-white font-bold">Dompet Ditemukan!</p>
                                <p class="text-sm text-gray-400">2 menit yang lalu di Gedung A</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FITUR SECTION --}}
        <div id="fitur" class="max-w-7xl mx-auto px-6 lg:px-8 mt-32">
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-sm font-bold text-blue-400 tracking-widest uppercase mb-3">Nilai Tambah</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-white">Mengapa Memilih Platform Kami?</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Fitur 1 --}}
                <div class="glass-panel p-8 rounded-[2rem] hover:-translate-y-2 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center border border-blue-500/20 mb-6">
                        <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Lapor Secara Real-time</h4>
                    <p class="text-gray-400 leading-relaxed text-sm">Postingan Anda akan langsung masuk ke beranda publik detik itu juga. Meningkatkan peluang barang segera ditemukan.</p>
                </div>

                {{-- Fitur 2 --}}
                <div class="glass-panel p-8 rounded-[2rem] hover:-translate-y-2 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center border border-indigo-500/20 mb-6">
                        <svg class="w-7 h-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Komunikasi Aman</h4>
                    <p class="text-gray-400 leading-relaxed text-sm">Terintegrasi langsung dengan WhatsApp. Cukup satu klik untuk menghubungi penemu atau pemilik barang tanpa ribet.</p>
                </div>

                {{-- Fitur 3 --}}
                <div class="glass-panel p-8 rounded-[2rem] hover:-translate-y-2 transition-transform duration-300 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="w-14 h-14 bg-purple-500/10 rounded-2xl flex items-center justify-center border border-purple-500/20 mb-6">
                        <svg class="w-7 h-7 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v2.25m0 0v2.25m0-2.25h-2.25m2.25 0h2.25" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-3">Filter Cerdas & Rapi</h4>
                    <p class="text-gray-400 leading-relaxed text-sm">Cari berdasarkan kategori spesifik seperti Dompet, Elektronik, hingga Kunci dengan sistem filter yang cepat dan responsif.</p>
                </div>
            </div>
        </div>

        {{-- CARA KERJA SECTION --}}
        <div id="cara-kerja" class="max-w-7xl mx-auto px-6 lg:px-8 mt-32 mb-10">
            <div class="glass-panel rounded-[3rem] p-10 md:p-16 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full filter blur-[80px]"></div>
                
                <div class="text-center mb-16 relative z-10">
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">Cara Kerja Semudah 1-2-3</h3>
                    <p class="text-gray-400">Tidak perlu proses berbelit untuk mulai mencari atau mengembalikan barang.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                    {{-- Step 1 --}}
                    <div class="text-center relative">
                        <div class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-blue-500/50 to-transparent"></div>
                        <div class="w-16 h-16 mx-auto bg-[#030712] border-2 border-blue-500 rounded-full flex items-center justify-center text-xl font-bold text-white mb-6 shadow-[0_0_20px_rgba(59,130,246,0.3)] relative z-10">1</div>
                        <h4 class="text-xl font-bold text-white mb-2">Buat Laporan</h4>
                        <p class="text-sm text-gray-400">Daftar akun, foto barangnya, dan tulis deskripsi singkat berserta lokasi kejadian.</p>
                    </div>
                    {{-- Step 2 --}}
                    <div class="text-center relative">
                        <div class="hidden md:block absolute top-8 left-1/2 w-full h-[2px] bg-gradient-to-r from-blue-500/50 to-transparent"></div>
                        <div class="w-16 h-16 mx-auto bg-[#030712] border-2 border-blue-500 rounded-full flex items-center justify-center text-xl font-bold text-white mb-6 shadow-[0_0_20px_rgba(59,130,246,0.3)] relative z-10">2</div>
                        <h4 class="text-xl font-bold text-white mb-2">Pencocokan & Kontak</h4>
                        <p class="text-sm text-gray-400">Pengunjung lain melihat postingan Anda dan menekan tombol chat WhatsApp otomatis.</p>
                    </div>
                    {{-- Step 3 --}}
                    <div class="text-center relative">
                        <div class="w-16 h-16 mx-auto bg-blue-500 rounded-full flex items-center justify-center text-xl font-bold text-white mb-6 shadow-[0_0_30px_rgba(59,130,246,0.6)] relative z-10">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-2">Barang Kembali</h4>
                        <p class="text-sm text-gray-400">Tentukan lokasi pertemuan untuk serah terima barang dan ubah status laporan menjadi selesai.</p>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-white/10 bg-[#030712] relative z-10 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-2 mb-6 opacity-80">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </div>
                <span class="font-bold text-lg text-white">Lost<span class="text-blue-400">Found</span></span>
            </div>
            <p class="text-gray-500 text-sm mb-8 max-w-md mx-auto">
                Platform korporat modern untuk memfasilitasi pelaporan dan pencarian barang secara cepat, akurat, dan terpercaya.
            </p>
            <div class="text-gray-600 text-sm">
                &copy; {{ date('Y') }} Platform Lost & Found Terpadu. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
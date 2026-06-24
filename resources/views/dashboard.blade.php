<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .font-sans { font-family: 'Inter', sans-serif; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Modern fluid animations */
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 10s infinite alternate; }
        .animation-delay-2000 { animation-delay: 2s; }

        .live-dot {
            width: 8px; height: 8px; border-radius: 50%; background: #34D399;
            box-shadow: 0 0 10px #34D399;
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(0.8); } }

        /* Glass interactive styles */
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .chip, .action-btn { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .chip:active { transform: scale(0.95); }

        .feed-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .feed-card:hover { 
            border-color: rgba(59, 130, 246, 0.3); 
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.15); 
            transform: translateY(-4px); 
            background: rgba(255, 255, 255, 0.05);
        }

        .post-img { transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
        .feed-card:hover .post-img { transform: scale(1.05); }
    </style>

    {{-- Main Wrapper --}}
    <div class="relative bg-[#030712] min-h-screen font-sans text-gray-200 pb-16">
        
        {{-- Decorative Glowing Orbs (Fixed Position) --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-purple-600/10 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
        </div>

        {{-- Layout Grid (30% Kiri, 70% Kanan pada Desktop via grid-cols-10) --}}
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-8 items-start">

                {{-- ===== KIRI (30%): Sticky Sidebar ===== --}}
                <div class="lg:col-span-3 lg:sticky lg:top-24 space-y-6 animate-fade-in-up">
                    
                    {{-- Header & Button Lapor --}}
                    <div>
                        <h2 class="font-bold text-xl text-white tracking-tight flex items-center gap-3 mb-6">
                            <div class="p-2 bg-blue-500/10 rounded-xl border border-blue-500/20">
                                <svg class="w-5 h-5 text-blue-400 drop-shadow-[0_0_8px_rgba(96,165,250,0.8)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v2.25m0 0v2.25m0-2.25h-2.25m2.25 0h2.25" /></svg>
                            </div>
                            Feed Kehilangan
                        </h2>
                        
                        {{-- Tombol Pembuat Laporan (Sekarang Membuka Modal Pop-up) --}}
                        <button type="button" onclick="openModal()" class="group flex items-center justify-center gap-2 w-full bg-white text-gray-900 px-5 py-3.5 rounded-2xl hover:bg-gray-100 hover:shadow-[0_0_20px_rgba(255,255,255,0.3)] active:scale-95 font-bold text-sm transition-all duration-300">
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Buat Laporan
                        </button>
                    </div>

                    {{-- Kotak Filter --}}
                    <div class="glass-panel p-6 rounded-3xl">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col gap-6">
                            
                            {{-- Search Bar --}}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 group-focus-within:text-blue-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="w-full pl-12 pr-4 py-3 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-500 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner">
                            </div>

                            {{-- Type Filter --}}
                            <div>
                                <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Tipe Laporan</h3>
                                <div class="flex flex-col gap-2.5">
                                    @php
                                        $typeOptions = ['' => 'Semua', 'lost' => 'Hilang', 'found' => 'Ditemukan'];
                                    @endphp
                                    @foreach($typeOptions as $value => $label)
                                        <div>
                                            <input type="radio" name="type" id="type-{{ $value ?: 'all' }}" value="{{ $value }}" class="hidden peer" onchange="this.form.submit()" {{ request('type', '') == $value ? 'checked' : '' }}>
                                            <label for="type-{{ $value ?: 'all' }}" class="chip block px-4 py-3 rounded-xl text-sm font-medium border cursor-pointer
                                                peer-checked:bg-gradient-to-r peer-checked:from-blue-600 peer-checked:to-indigo-600 peer-checked:border-transparent peer-checked:text-white peer-checked:shadow-[0_0_15px_rgba(79,70,229,0.4)]
                                                bg-white/[0.02] text-gray-400 border-white/10 hover:bg-white/[0.06] hover:text-gray-200">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Category Filter --}}
                            <div class="pt-2 border-t border-white/5">
                                <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Kategori</h3>
                                <div class="flex flex-col gap-2">
                                    @php
                                        $categoryOptions = ['' => 'Semua Kategori', 'Dompet & Tas' => 'Dompet & Tas', 'KTP & Dokumen' => 'KTP & Dokumen', 'Kunci' => 'Kunci', 'Elektronik (HP/Laptop)' => 'Elektronik', 'Kendaraan' => 'Kendaraan', 'Lainnya' => 'Lainnya'];
                                    @endphp
                                    @foreach($categoryOptions as $value => $label)
                                        <div>
                                            <input type="radio" name="category" id="cat-{{ Str::slug($value ?: 'semua') }}" value="{{ $value }}" class="hidden peer" onchange="this.form.submit()" {{ request('category', '') == $value ? 'checked' : '' }}>
                                            <label for="cat-{{ Str::slug($value ?: 'semua') }}" class="chip block px-4 py-2.5 rounded-lg text-sm font-medium border cursor-pointer
                                                peer-checked:bg-white/10 peer-checked:text-white peer-checked:border-white/20
                                                bg-transparent text-gray-500 border-transparent hover:text-gray-300 hover:bg-white/5">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Reset Filter Link --}}
                            @if(request()->has('search') || request()->has('type') || request()->has('category'))
                                <div class="pt-3">
                                    <a href="{{ route('dashboard') }}" class="flex justify-center items-center gap-2 w-full text-xs font-semibold text-red-400 hover:text-white bg-red-500/10 hover:bg-red-500/30 px-4 py-3 rounded-xl transition-colors border border-red-500/20">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                        Hapus Filter
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                {{-- ===== KANAN (70%): Postingan / Feed ===== --}}
                <div class="lg:col-span-7 w-full">
                    
                    {{-- Flash Message --}}
                    @if(session('success'))
                        <div class="glass-panel border-green-500/30 text-green-400 px-5 py-4 mb-8 rounded-2xl shadow-lg shadow-green-900/20 font-medium flex items-center gap-3 animate-fade-in-up">
                            <div class="p-1.5 bg-green-500/20 rounded-full">
                                <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-8">
                        @forelse($posts as $post)
                            <article class="feed-card glass-panel rounded-[2rem] overflow-hidden flex flex-col animate-fade-in-up" style="animation-delay: {{ 0.2 + ($loop->index * 0.1) }}s;">

                                {{-- Card Header --}}
                                <div class="p-6 flex justify-between items-start">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-base shrink-0 shadow-[0_0_15px_rgba(79,70,229,0.5)] ring-2 ring-white/10">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-100 text-lg leading-tight">{{ $post->user->name }}</h4>
                                            <div class="text-sm text-gray-400 flex items-center gap-2 mt-1.5 font-medium">
                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                                <span aria-hidden="true" class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>
                                                <span class="text-blue-400">{{ $post->category }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($post->status == 'resolved')
                                        <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="bg-white/5 border border-white/10 text-gray-200 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-2 shadow-sm shrink-0">
                                            <span class="live-dot"></span> Aktif
                                        </span>
                                    @endif
                                </div>

                                {{-- Card Content --}}
                                <div class="px-6 pb-6">
                                    <div class="flex items-center gap-2.5 mb-3 flex-wrap">
                                        @if($post->type == 'lost')
                                            <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[11px] tracking-widest font-bold px-3 py-1 rounded-lg uppercase">Hilang</span>
                                        @else
                                            <span class="bg-teal-500/10 text-teal-400 border border-teal-500/20 text-[11px] tracking-widest font-bold px-3 py-1 rounded-lg uppercase">Ditemukan</span>
                                        @endif
                                        <h3 class="font-bold text-white text-xl leading-snug">{{ $post->item_name }}</h3>
                                    </div>

                                    <p id="desc-{{ $post->id }}" class="text-gray-300 text-base whitespace-pre-line leading-relaxed line-clamp-3 font-normal opacity-90">{{ $post->description }}</p>
                                    <button type="button"
                                        onclick="const d=document.getElementById('desc-{{ $post->id }}'); d.classList.toggle('line-clamp-3'); this.textContent = d.classList.contains('line-clamp-3') ? 'Baca selengkapnya' : 'Sembunyikan';"
                                        class="text-sm font-semibold text-blue-400 hover:text-blue-300 mt-3 focus:outline-none transition-colors">
                                        Baca selengkapnya
                                    </button>
                                </div>

                                {{-- Image Display --}}
                                <div class="w-full relative overflow-hidden bg-black/40 border-y border-white/5">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/50 via-transparent to-transparent z-10 pointer-events-none"></div>
                                    <img src="{{ $post->image_path }}" class="post-img w-full max-h-[600px] object-cover cursor-zoom-in" alt="{{ $post->item_name }}" loading="lazy">
                                </div>

                                {{-- Interactive Card Actions --}}
                                <div class="flex items-center divide-x divide-white/5 bg-white/[0.02]">
                                    @if($post->status == 'active')
                                        <a href="https://wa.me/{{ $post->wa_number }}" target="_blank" class="action-btn flex-1 flex justify-center items-center gap-2 py-4 text-gray-300 hover:text-white hover:bg-green-500/20 font-semibold text-sm">
                                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                            Chat Pembuat
                                        </a>
                                    @endif

                                    @php
                                        $shareText = "Bantu Sebarkan! " . ($post->type == 'lost' ? 'Telah hilang' : 'Telah ditemukan') . " barang berupa: " . $post->item_name . ". Lihat detailnya di: " . url()->current();
                                    @endphp
                                    <a href="https://wa.me/?text={{ urlencode($shareText) }}" target="_blank" class="action-btn flex-1 flex justify-center items-center gap-2 py-4 text-gray-300 hover:text-white hover:bg-blue-500/20 font-semibold text-sm">
                                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" /></svg>
                                        Bagikan
                                    </a>

                                    @if(auth()->id() == $post->user_id)
                                        <a href="{{ route('posts.mine') }}" class="action-btn flex-1 flex justify-center items-center gap-2 py-4 text-gray-300 hover:text-white hover:bg-white/10 font-semibold text-sm">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            Kelola
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div class="glass-panel rounded-3xl p-12 text-center flex flex-col items-center justify-center min-h-[350px] animate-fade-in-up">
                                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-5 border border-white/10 shadow-[0_0_30px_rgba(255,255,255,0.05)]">
                                    <svg class="w-10 h-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2 tracking-wide">Belum ada laporan</h3>
                                <p class="text-sm text-gray-400 max-w-sm leading-relaxed">Pencarian tidak membuahkan hasil. Ubah kata kunci filter Anda atau mulailah membuat laporan pertama.</p>
                                
                                @if(request()->has('search') || request()->has('type') || request()->has('category'))
                                    <a href="{{ route('dashboard') }}" class="mt-8 px-6 py-3 bg-white text-gray-900 hover:bg-gray-200 font-bold rounded-full transition-all text-sm shadow-[0_0_20px_rgba(255,255,255,0.2)] hover:scale-105 active:scale-95">
                                        Kembalikan Filter
                                    </a>
                                @endif
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ===== COMPONENT MODAL POP-UP (FORMS TERINTEGRASI) ===== --}}
    <div id="createModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        
        {{-- Backdrop Hitam Blur --}}
        <div class="absolute inset-0 bg-[#030712]/80 backdrop-blur-md cursor-pointer" onclick="closeModal()"></div>

        {{-- Konten Modal --}}
        <div id="modalContent" class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto no-scrollbar mx-4 glass-panel p-8 rounded-[2rem] border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform scale-95 transition-transform duration-300">
            
            {{-- Header Modal --}}
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-white/10">
                <h2 class="font-bold text-2xl text-white tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-blue-500/10 rounded-xl border border-blue-500/20">
                        <svg class="w-6 h-6 text-blue-400 drop-shadow-[0_0_8px_rgba(96,165,250,0.8)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    Buat Postingan Baru
                </h2>
                <button type="button" onclick="closeModal()" class="p-2 bg-white/5 hover:bg-white/10 rounded-full text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Form Laporan --}}
            <form action="{{ route('posts.store') }}" method="POST" id="postForm" class="space-y-6">
                @csrf

                {{-- Jenis Informasi (Custom Radio mirip Filter Dashboard) --}}
                <div>
                    <label class="block font-medium text-sm text-gray-300 mb-3">Jenis Informasi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <input type="radio" name="type" id="type-lost-modal" value="lost" class="hidden peer" checked>
                            <label for="type-lost-modal" class="block px-4 py-3.5 rounded-xl text-sm font-bold border cursor-pointer text-center transition-all peer-checked:bg-red-500/20 peer-checked:border-red-500/50 peer-checked:text-red-400 peer-checked:shadow-[0_0_15px_rgba(239,68,68,0.2)] bg-white/[0.02] text-gray-400 border-white/10 hover:bg-white/[0.06]">
                                Saya Kehilangan Barang
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="type" id="type-found-modal" value="found" class="hidden peer">
                            <label for="type-found-modal" class="block px-4 py-3.5 rounded-xl text-sm font-bold border cursor-pointer text-center transition-all peer-checked:bg-teal-500/20 peer-checked:border-teal-500/50 peer-checked:text-teal-400 peer-checked:shadow-[0_0_15px_rgba(20,184,166,0.2)] bg-white/[0.02] text-gray-400 border-white/10 hover:bg-white/[0.06]">
                                Saya Menemukan Barang
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Kategori & Nama Barang Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-sm text-gray-300 mb-2">Kategori Barang</label>
                        <select name="category" class="w-full px-4 py-3.5 bg-[#030712]/50 border border-white/10 text-gray-200 focus:bg-[#030712] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all outline-none" required>
                            <option value="" disabled selected class="bg-gray-900">Pilih Kategori...</option>
                            <option value="Dompet & Tas" class="bg-gray-900">Dompet & Tas</option>
                            <option value="KTP & Dokumen" class="bg-gray-900">KTP & Dokumen</option>
                            <option value="Kunci" class="bg-gray-900">Kunci</option>
                            <option value="Elektronik (HP/Laptop)" class="bg-gray-900">Elektronik (HP/Laptop)</option>
                            <option value="Kendaraan" class="bg-gray-900">Kendaraan</option>
                            <option value="Lainnya" class="bg-gray-900">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-300 mb-2">Nama Barang</label>
                        <input type="text" name="item_name" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all outline-none" placeholder="Contoh: Kunci Motor Honda..." required>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block font-medium text-sm text-gray-300 mb-2">Deskripsi & Lokasi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all outline-none no-scrollbar" placeholder="Ceritakan ciri-ciri barang dan lokasi terakhir terlihat atau ditemukan..." required></textarea>
                </div>

                {{-- Upload Gambar (Tema Transparan Gelap) --}}
                <div class="p-5 bg-white/[0.02] border border-white/5 rounded-2xl">
                    <label class="block font-medium text-sm text-gray-300 mb-3">Upload Gambar Barang (Maks 2MB)</label>
                    
                    <input type="file" id="imageInput" class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20 file:cursor-pointer cursor-pointer border border-white/10 rounded-xl bg-[#030712]/50 outline-none" accept="image/*" required>
                    
                    {{-- Loading State --}}
                    <div id="loadingIndicator" class="hidden flex items-center gap-3 mt-4 text-blue-400 p-3 bg-blue-500/10 rounded-xl border border-blue-500/20">
                        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium">Mengunggah gambar... Mohon tunggu sebentar.</span>
                    </div>

                    {{-- Success State --}}
                    <div id="successIndicator" class="hidden mt-4">
                        <span class="text-sm font-medium text-green-400 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            Upload Berhasil!
                        </span>
                        <img id="imagePreview" src="" class="h-32 w-auto rounded-xl border border-white/10 shadow-lg object-cover">
                    </div>

                    {{-- Error State --}}
                    <div id="errorIndicator" class="hidden mt-4 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-sm font-medium text-red-400"></div>

                    <input type="hidden" name="image_url" id="imageUrlInput">
                </div>

                {{-- Nomor WA --}}
                <div>
                    <label class="block font-medium text-sm text-gray-300 mb-2">Nomor WhatsApp Aktif</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884Z"/></svg>
                        </div>
                        <input type="text" name="wa_number" class="w-full pl-12 pr-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all outline-none" placeholder="Contoh: 081234567890" required>
                    </div>
                </div>

                {{-- Tombol Aksi Akhir Form --}}
                <div class="flex justify-end gap-4 pt-6 mt-4 border-t border-white/5">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-white/5 text-gray-300 rounded-xl font-bold text-sm hover:bg-white/10 transition">Batal</button>
                    <button type="submit" id="submitBtn" class="px-6 py-3 bg-white/10 text-gray-500 rounded-xl font-bold text-sm cursor-not-allowed transition duration-300" disabled>
                        Posting Laporan
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- ===== JAVASCRIPT LOGIC ===== --}}
    <script>
        // --- LOGIKA POP-UP MODAL ---
        function openModal() {
            const modal = document.getElementById('createModal');
            const content = document.getElementById('modalContent');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll halaman utama
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('createModal');
            const content = document.getElementById('modalContent');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            document.body.style.overflow = ''; // Aktifkan kembali scroll halaman utama
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Tutup otomatis jika tombol ESC ditekan
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });

        // --- LOGIKA AJAX ASYNC UPLOAD GAMBAR BARANG ---
        document.getElementById('imageInput').addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) return;

            const loading = document.getElementById('loadingIndicator');
            const success = document.getElementById('successIndicator');
            const error = document.getElementById('errorIndicator');
            const preview = document.getElementById('imagePreview');
            const hiddenInput = document.getElementById('imageUrlInput');
            const submitBtn = document.getElementById('submitBtn');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Reset status indikator
            success.classList.add('hidden');
            error.classList.add('hidden');
            
            // Kunci tombol kirim saat proses mengunggah berlangsung
            submitBtn.disabled = true;
            submitBtn.classList.replace('bg-blue-600', 'bg-white/10');
            submitBtn.classList.replace('text-white', 'text-gray-500');
            submitBtn.classList.remove('shadow-[0_0_20px_rgba(37,99,235,0.4)]');
            submitBtn.classList.add('cursor-not-allowed');
            
            loading.classList.remove('hidden');

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch("{{ route('posts.uploadImage') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: formData
                });

                const textResponse = await response.text(); 
                let data;

                try {
                    data = JSON.parse(textResponse);
                } catch (parseError) {
                    throw new Error("Server mengembalikan error sistem. Hubungi tim IT atau cek log backend.");
                }

                if (response.ok && data.success) {
                    hiddenInput.value = data.url; 
                    preview.src = data.url; 
                    loading.classList.add('hidden');
                    success.classList.remove('hidden');
                    
                    // Aktifkan tombol kirim (Glow Efek Biru Modern)
                    submitBtn.disabled = false;
                    submitBtn.classList.replace('bg-white/10', 'bg-blue-600');
                    submitBtn.classList.replace('text-gray-500', 'text-white');
                    submitBtn.classList.add('shadow-[0_0_20px_rgba(37,99,235,0.4)]');
                    submitBtn.classList.remove('cursor-not-allowed');
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan pada server.';
                    if (data.errors) errorMessage = Object.values(data.errors)[0][0];
                    throw new Error(errorMessage);
                }
            } catch (err) {
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                error.innerText = err.message; 
                this.value = ''; 
            }
        });
    </script>
</x-app-layout>
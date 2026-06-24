<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        .font-sans { font-family: 'Inter', sans-serif; }

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
            width: 8px; height: 8px; border-radius: 50%; background: #ef4444;
            box-shadow: 0 0 10px #ef4444;
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

        .feed-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .feed-card:hover { 
            border-color: rgba(59, 130, 246, 0.3); 
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.15); 
            transform: translateY(-4px); 
            background: rgba(255, 255, 255, 0.05);
        }
    </style>

    {{-- Main Wrapper Tema Gelap --}}
    <div class="relative bg-[#030712] min-h-screen font-sans text-gray-200 pb-16">
        
        {{-- Decorative Glowing Orbs --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-purple-600/10 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
            
            {{-- Header --}}
            <div class="mb-10 animate-fade-in-up">
                <h2 class="font-bold text-3xl text-white tracking-tight flex items-center gap-4">
                    <div class="p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20 shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                        <svg class="w-7 h-7 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Kelola Postingan Saya
                </h2>
                <p class="text-gray-400 mt-2 text-sm">Kelola status laporan barang hilang dan temuan Anda.</p>
            </div>
            
            {{-- Flash Message Success --}}
            @if(session('success'))
                <div class="glass-panel border-green-500/30 text-green-400 px-5 py-4 mb-8 rounded-2xl shadow-lg shadow-green-900/20 font-medium flex items-center gap-3 animate-fade-in-up">
                    <div class="p-1.5 bg-green-500/20 rounded-full shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            {{-- List Postingan --}}
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="feed-card glass-panel rounded-[1.5rem] overflow-hidden flex flex-col md:flex-row animate-fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        
                        {{-- Gambar Postingan --}}
                        <div class="md:w-2/5 relative h-56 md:h-auto border-b md:border-b-0 md:border-r border-white/5 bg-black/40">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/60 to-transparent z-10 pointer-events-none md:bg-gradient-to-r"></div>
                            <img src="{{ $post->image_path }}" class="w-full h-full object-cover" alt="{{ $post->item_name }}">
                        </div>
                        
                        {{-- Konten Postingan --}}
                        <div class="p-6 md:w-3/5 flex flex-col justify-between relative z-20">
                            <div>
                                <div class="flex justify-between items-start gap-4 mb-2">
                                    <h3 class="text-xl font-bold text-white leading-tight">{{ $post->item_name }}</h3>
                                    
                                    {{-- Badge Status Dinamis --}}
                                    @if($post->status == 'resolved')
                                        <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-[11px] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm shrink-0 whitespace-nowrap uppercase tracking-wider">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[11px] font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-sm shrink-0 whitespace-nowrap uppercase tracking-wider">
                                            <span class="live-dot"></span> Belum Ketemu
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="text-xs text-gray-400 flex items-center gap-2 font-medium mb-4">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    Diposting: {{ $post->created_at->format('d M Y') }}
                                </div>
                                
                                <p class="text-gray-300 text-sm leading-relaxed line-clamp-2 opacity-90">{{ $post->description }}</p>
                            </div>

                            {{-- Tombol Aksi Kelola --}}
                            <div class="mt-6 flex flex-wrap gap-3 border-t border-white/5 pt-5">
                                @if($post->status == 'active')
                                    <form action="{{ route('posts.found', $post->id) }}" method="POST" class="flex-1 min-w-[140px]">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-blue-500/10 text-blue-400 hover:text-white hover:bg-blue-600 border border-blue-500/20 hover:border-blue-500 hover:shadow-[0_0_15px_rgba(37,99,235,0.4)] px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 active:scale-95">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Tandai Selesai
                                        </button>
                                    </form>
                                @endif

                                {{-- FORM HAPUS (Diubah agar memanggil modal) --}}
                                <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="{{ $post->status == 'active' ? 'flex-1 min-w-[120px]' : 'w-full' }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-form-{{ $post->id }}')" class="w-full flex justify-center items-center gap-2 bg-red-500/10 text-red-400 hover:text-white hover:bg-red-600 border border-red-500/20 hover:border-red-500 hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Kondisi Kosong --}}
                    <div class="glass-panel rounded-[2rem] border border-dashed border-white/20 p-16 text-center flex flex-col items-center justify-center min-h-[400px] animate-fade-in-up">
                        <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6 border border-white/10 shadow-[0_0_30px_rgba(255,255,255,0.02)]">
                            <svg class="w-12 h-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3 tracking-wide">Belum Ada Postingan</h3>
                        <p class="text-base text-gray-400 max-w-md leading-relaxed mb-8">Anda belum pernah membuat laporan kehilangan atau temuan barang.</p>
                        
                        <a href="{{ route('dashboard') }}" class="px-8 py-3.5 bg-blue-600 text-white hover:bg-blue-500 font-bold rounded-xl transition-all duration-300 text-sm shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_30px_rgba(37,99,235,0.6)] hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Ke Dashboard
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ===== COMPONENT MODAL KONFIRMASI HAPUS ===== --}}
    <div id="deleteConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        
        {{-- Backdrop Hitam Blur --}}
        <div class="absolute inset-0 bg-[#030712]/80 backdrop-blur-md cursor-pointer" onclick="closeDeleteModal()"></div>

        {{-- Konten Modal --}}
        <div id="deleteModalContent" class="relative w-full max-w-md mx-4 glass-panel p-8 rounded-[2rem] border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform scale-95 transition-transform duration-300 text-center">
            
            {{-- Icon Peringatan --}}
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/20 shadow-[0_0_30px_rgba(239,68,68,0.3)]">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            {{-- Teks --}}
            <h3 class="text-2xl font-bold text-white mb-2">Hapus Postingan?</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                Apakah Anda yakin ingin menghapus postingan ini secara permanen? Tindakan ini tidak dapat dibatalkan.
            </p>
            
            {{-- Tombol Aksi --}}
            <div class="flex gap-3">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-white/5 text-gray-300 rounded-xl font-bold text-sm hover:bg-white/10 transition-colors duration-300">
                    Batal
                </button>
                <button type="button" onclick="executeDelete()" class="flex-1 px-4 py-3 bg-red-500/10 text-red-400 hover:text-white hover:bg-red-600 border border-red-500/20 hover:border-red-500 hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] rounded-xl font-bold text-sm transition-all duration-300">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- ===== JAVASCRIPT LOGIC ===== --}}
    <script>
        // Variabel global untuk menyimpan form mana yang akan dihapus
        let formToSubmit = null;

        function confirmDelete(formId) {
            formToSubmit = document.getElementById(formId);
            
            const modal = document.getElementById('deleteConfirmModal');
            const content = document.getElementById('deleteModalContent');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll
            
            // Timeout kecil untuk trigger animasi CSS
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            const content = document.getElementById('deleteModalContent');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            document.body.style.overflow = ''; // Buka scroll
            
            // Tunggu animasi selesai baru hidden
            setTimeout(() => {
                modal.classList.add('hidden');
                formToSubmit = null; // Reset
            }, 300);
        }

        function executeDelete() {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        }

        // Tutup modal jika tombol ESC ditekan
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeDeleteModal();
            }
        });
    </script>

</x-app-layout>
<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

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

        /* Glass interactive styles */
        .glass-panel {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .stat-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover {
            border-color: rgba(59, 130, 246, 0.25);
            box-shadow: 0 10px 30px -10px rgba(59, 130, 246, 0.15);
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.04);
        }

        /* Print Styling */
        @media print {
            body { background: #ffffff !important; color: #000000 !important; font-size: 12pt; }
            .fixed, .animate-blob, button, form, nav, .tab-buttons, .aksi-moderasi { display: none !important; }
            .glass-panel { background: transparent !important; border: none !important; backdrop-filter: none !important; box-shadow: none !important; }
            .text-white, h2, h3, h4, td, th { color: #000000 !important; }
            .stat-card { border: 1px solid #ddd !important; margin-bottom: 10px; page-break-inside: avoid; }
            canvas { max-width: 100% !important; height: auto !important; }
            .print-area { display: block !important; width: 100% !important; }
        }
    </style>

    {{-- Main Wrapper --}}
    <div class="relative bg-[#030712] min-h-screen font-sans text-gray-200 pb-16">
        
        {{-- Decorative Glowing Orbs --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-10%] left-1/4 w-96 h-96 bg-blue-600/10 rounded-full mix-blend-screen filter blur-[120px] animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-indigo-600/15 rounded-full mix-blend-screen filter blur-[120px] animate-blob"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 space-y-8" x-data="{ activeTab: 'overview' }">
            
            {{-- ===== HEADER DASHBOARD ADMIN ===== --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6 animate-fade-in-up">
                <div>
                    <h2 class="font-bold text-3xl text-white tracking-tight flex items-center gap-3.5">
                        <div class="p-2.5 bg-indigo-500/10 rounded-xl border border-indigo-500/20 shadow-[0_0_15px_rgba(99,102,241,0.3)]">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                        </div>
                        Panel Kontrol Utama Admin
                    </h2>
                    <p class="text-sm text-gray-400 mt-1.5">Manajemen terpadu sistem informasi kehilangan dan penemuan barang regional.</p>
                </div>
                
                {{-- Tombol Cetak Laporan --}}
                <button onclick="window.print()" class="group flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-5 py-3 rounded-2xl hover:shadow-[0_0_25px_rgba(59,130,246,0.4)] active:scale-95 font-bold text-xs transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0a2.25 2.25 0 01-2.25 2.25H8.59a2.25 2.25 0 01-2.25-2.25M16.5 13.829V10.5a3.75 3.75 0 00-3.75-3.75h-1.5A3.75 3.75 0 007.5 10.5v3.329m9 0H18A2.25 2.25 0 0120.25 16v1.5a2.25 2.25 0 01-2.25 2.25h-.165m-15.337 0H2.25A2.25 2.25 0 010 16.5V15a2.25 2.25 0 012.25-2.25h.165" /></svg>
                    Cetak Laporan Sistem
                </button>
            </div>

            {{-- ===== TOMBOL NAVIGATION TABS ===== --}}
            <div class="tab-buttons flex gap-3 border-b border-white/5 pb-2 animate-fade-in-up">
                <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/10' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all duration-200">
                    Analisis & Grafik
                </button>
                <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/10' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all duration-200 flex items-center gap-1.5">
                    Manajemen Pengguna
                    <span class="bg-white/10 px-1.5 py-0.5 rounded text-[10px]">{{ count($allUsers) }}</span>
                </button>
                <button @click="activeTab = 'moderation'" :class="activeTab === 'moderation' ? 'bg-red-600/30 text-red-400 border border-red-500/30' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition-all duration-200 flex items-center gap-1.5">
                    Moderasi Konten Sensitif 
                    <span class="bg-red-500/20 px-1.5 py-0.5 rounded text-[10px] text-red-400 font-black">{{ count($flaggedPosts) }}</span>
                </button>
            </div>

            {{-- ======================================================== --}}
            {{-- TAB MENU 1: RINGKASAN ANALISIS & GRAFIK                  --}}
            {{-- ======================================================== --}}
            <div x-show="activeTab === 'overview'" class="space-y-8 animate-fade-in-up">
                
                {{-- Grid Statistik Merinci --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat-card glass-panel p-6 rounded-3xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pengguna</p>
                            <h3 class="text-3xl font-extrabold text-white tracking-tight">{{ number_format($totalUsers) }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1.5 font-medium">Entitas terverifikasi</p>
                        </div>
                        <div class="p-4 bg-blue-500/10 rounded-2xl border border-blue-500/20 text-blue-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                    </div>
                    <div class="stat-card glass-panel p-6 rounded-3xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Barang Hilang</p>
                            <h3 class="text-3xl font-extrabold text-red-400 tracking-tight">{{ number_format($lostCount) }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1.5 font-medium">Status publik aktif</p>
                        </div>
                        <div class="p-4 bg-red-500/10 rounded-2xl border border-red-500/20 text-red-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                    </div>
                    <div class="stat-card glass-panel p-6 rounded-3xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Barang Temuan</p>
                            <h3 class="text-3xl font-extrabold text-teal-400 tracking-tight">{{ number_format($foundCount) }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1.5 font-medium">Proses pencocokan</p>
                        </div>
                        <div class="p-4 bg-teal-500/10 rounded-2xl border border-teal-500/20 text-teal-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                    <div class="stat-card glass-panel p-6 rounded-3xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kasus Selesai</p>
                            <h3 class="text-3xl font-extrabold text-emerald-400 tracking-tight">{{ number_format($resolvedCount) }}</h3>
                            <p class="text-[11px] text-emerald-400 mt-1.5 font-medium">Arsip terselesaikan</p>
                        </div>
                        <div class="p-4 bg-emerald-500/10 rounded-2xl border border-emerald-500/20 text-emerald-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Charts Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 glass-panel p-6 rounded-[2rem] h-[360px]">
                        <h4 class="font-bold text-base text-white mb-4">Tren Aktivitas Laporan Bulanan</h4>
                        <div class="w-full h-64"><canvas id="activityTrendChart"></canvas></div>
                    </div>
                    <div class="glass-panel p-6 rounded-[2rem] h-[360px]">
                        <h4 class="font-bold text-base text-white mb-4">Distribusi Kategori Objek</h4>
                        <div class="w-full h-60 flex items-center justify-center"><canvas id="categoryDistributionChart"></canvas></div>
                    </div>
                </div>

                {{-- Tabel Log Merinci --}}
                <div class="glass-panel rounded-[2rem] p-6">
                    <h4 class="font-bold text-lg text-white mb-4">Aktivitas Postingan Terbaru</h4>
                    <div class="w-full overflow-x-auto no-scrollbar">
                        <table class="w-full text-left text-sm text-gray-300">
                            <thead>
                                <tr class="border-b border-white/5 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                    <th class="pb-3 pl-2">ID Post</th>
                                    <th class="pb-3">Waktu Masuk</th>
                                    <th class="pb-3">Nama Pelapor</th>
                                    <th class="pb-3">Nama Objek Barang</th>
                                    <th class="pb-3">Kategori</th>
                                    <th class="pb-3">Klasifikasi Tipe</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($recentPosts as $post)
                                    <tr class="hover:bg-white/[0.01] transition-colors">
                                        <td class="py-3.5 pl-2 text-xs font-mono text-gray-500">#{{ str_pad($post->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="py-3.5 text-xs text-gray-400">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3.5">{{ $post->user->name ?? 'User' }}</td>
                                        <td class="py-3.5 text-white font-semibold">{{ $post->item_name }}</td>
                                        <td class="py-3.5 text-gray-400 text-xs">{{ $post->category }}</td>
                                        <td class="py-3.5">
                                            <span class="px-2.5 py-0.5 rounded text-[10px] uppercase font-black tracking-wider {{ $post->type === 'lost' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-teal-500/10 text-teal-400 border border-teal-500/20' }}">
                                                {{ $post->type === 'lost' ? 'Kehilangan' : 'Penemuan' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="py-6 text-center text-gray-500 text-xs">Belum ada data laporan masuk pada sistem.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- TAB MENU 2: MANAJEMEN USER DENGAN POP-UP KUSTOM           --}}
            {{-- ======================================================== --}}
            <div x-show="activeTab === 'users'" class="glass-panel rounded-[2rem] p-6 animate-fade-in-up" style="display: none;">
                <h4 class="font-bold text-xl text-white mb-2">Manajemen Basis Data Pengguna</h4>
                <p class="text-xs text-gray-400 mb-6">Otoritas peninjauan akun, pembatasan hak akses, atau penghapusan identitas pengguna secara permanen.</p>

                <div class="w-full overflow-x-auto no-scrollbar">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead>
                            <tr class="border-b border-white/5 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <th class="pb-3 pl-2">ID User</th>
                                <th class="pb-3">Nama Lengkap</th>
                                <th class="pb-3">Alamat Email Sistem</th>
                                <th class="pb-3">Tanggal Registrasi</th>
                                <th class="pb-3 text-right pr-2">Tindakan Otoritas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($allUsers as $user)
                                <tr class="hover:bg-white/[0.01] transition-colors">
                                    <td class="py-4 pl-2 text-xs font-mono text-gray-500">USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 font-bold text-white">{{ $user->name }}</td>
                                    <td class="py-4 text-gray-400 text-xs">{{ $user->email }}</td>
                                    <td class="py-4 text-xs text-gray-400">{{ $user->created_at->format('d M Y, H:i') }} WIB</td>
                                    <td class="py-4 text-right pr-2">
                                        
                                        {{-- FORM HAPUS USER (MENGGUNAKAN POPUP MODAL) --}}
                                        <form id="delete-user-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="triggerAdminConfirm('delete-user-{{ $user->id }}', 'Konfirmasi Penghapusan Pengguna', 'Apakah Anda yakin ingin menghapus akun {{ $user->name }} secara permanen? Seluruh data laporan yang terkait dengan pengguna ini akan dieliminasi secara total dari sistem.')" class="px-3 py-1.5 bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-600 hover:text-white rounded-xl text-xs font-bold transition-all duration-200">
                                                Hapus Akun
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-8 text-center text-gray-500 text-xs">Tidak ada data pengguna eksternal terdaftar pada sistem.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- TAB MENU 3: MODERASI KONTEN NEGATIF DENGAN POP-UP KUSTOM --}}
            {{-- ======================================================== --}}
            <div x-show="activeTab === 'moderation'" class="glass-panel rounded-[2rem] p-6 border-red-500/20 animate-fade-in-up" style="display: none;">
                <div class="mb-6">
                    <h4 class="font-bold text-xl text-red-400 flex items-center gap-2">
                        Sistem Pemantauan Otomatis Kebijakan Konten
                    </h4>
                    <p class="text-xs text-gray-400 mt-1">Daftar entitas postingan publik yang terindikasi melanggar hukum dan regulasi platform (Pelanggaran SARA, Perjudian, Slot, atau Spam Komersial).</p>
                </div>

                <div class="w-full overflow-x-auto no-scrollbar">
                    <table class="w-full text-left text-sm text-gray-300">
                        <thead>
                            <tr class="border-b border-white/5 text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <th class="pb-3 pl-2">ID Post</th>
                                <th class="pb-3">Data Pelapor</th>
                                <th class="pb-3">Judul Objek</th>
                                <th class="pb-3 w-1/3">Detail Deskripsi Konten</th>
                                <th class="pb-3">Status Indikasi</th>
                                <th class="pb-3 text-right pr-2">Tindakan Moderasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($flaggedPosts as $fPost)
                                <tr class="bg-red-500/[0.02] hover:bg-red-500/[0.04] transition-colors">
                                    <td class="py-4 pl-2 text-xs font-mono text-gray-500">#{{ str_pad($fPost->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 text-xs">
                                        <span class="font-bold text-white block">{{ $fPost->user->name ?? 'User' }}</span>
                                        <span class="text-gray-500 font-mono">{{ $fPost->user->email ?? '' }}</span>
                                    </td>
                                    <td class="py-4 text-red-300 font-bold text-sm">{{ $fPost->item_name }}</td>
                                    <td class="py-4 text-xs text-gray-400 leading-relaxed pr-4">{{ $fPost->description }}</td>
                                    <td class="py-4">
                                        <span class="px-2.5 py-1 rounded text-[10px] font-black bg-red-500/20 text-red-400 border border-red-500/30 uppercase tracking-wide">Terindikasi Pelanggaran</span>
                                    </td>
                                    <td class="py-4 text-right pr-2 aksi-moderasi">
                                        
                                        {{-- FORM HAPUS POSTINGAN SENSITIF (MENGGUNAKAN POPUP MODAL) --}}
                                        <form id="delete-flagged-post-{{ $fPost->id }}" action="{{ route('posts.destroy', $fPost->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="triggerAdminConfirm('delete-flagged-post-{{ $fPost->id }}', 'Konfirmasi Eliminasi Konten', 'Apakah Anda yakin ingin menghapus paksa postingan ini karena rekam jejak teks terindikasi melanggar kebijakan hukum SARA / Perjudian platform?')" class="px-3 py-1.5 bg-red-600 text-white hover:bg-red-500 text-xs font-bold rounded-xl shadow-lg transition-all">
                                                Hapus Postingan
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-emerald-400 font-semibold bg-emerald-500/[0.01] text-xs uppercase tracking-wider">
                                        Sistem Bersih: Tidak ditemukan indikasi pelanggaran konten atau spam ilegal pada database saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== COMPONENT MODAL POP-UP KONFIRMASI OTORITAS ADMIN ===== --}}
    <div id="adminConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        
        {{-- Backdrop Gelap Lembut --}}
        <div class="absolute inset-0 bg-[#030712]/85 backdrop-blur-md cursor-pointer" onclick="closeAdminConfirmModal()"></div>

        {{-- Konten Modal Kaca --}}
        <div id="adminModalContent" class="relative w-full max-w-md mx-4 glass-panel p-8 rounded-[2rem] border border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.6)] transform scale-95 transition-transform duration-300 text-center shadow-black">
            
            {{-- Icon Peringatan Otoritas --}}
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-red-500/20 shadow-[0_0_30px_rgba(239,68,68,0.3)]">
                <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            {{-- Judul dan Deskripsi Dinamis dari Script --}}
            <h3 id="confirmTitle" class="text-2xl font-bold text-white mb-2 tracking-tight">Konfirmasi Tindakan</h3>
            <p id="confirmMessage" class="text-gray-400 text-sm leading-relaxed mb-8">Apakah Anda yakin ingin menjalankan instruksi pembatasan otoritas sistem ini?</p>
            
            {{-- Tombol Konfirmasi Akhir --}}
            <div class="flex gap-4">
                <button type="button" onclick="closeAdminConfirmModal()" class="flex-1 px-4 py-3 bg-white/5 text-gray-300 rounded-xl font-bold text-sm hover:bg-white/10 transition-all duration-200">
                    Batalkan Aksi
                </button>
                <button type="button" onclick="executeAdminAction()" class="flex-1 px-4 py-3 bg-red-500/10 text-red-400 hover:text-white hover:bg-red-600 border border-red-500/20 hover:border-red-500 hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] rounded-xl font-bold text-sm transition-all duration-300">
                    Eksekusi Sistem
                </button>
            </div>
        </div>
    </div>

    {{-- ===== INJEKSI CHART SCRIPT DARI DATA DATABASE ===== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = 'rgba(255, 255, 255, 0.4)';

        // 1. Line Chart Tren Bulanan
        const ctxTrend = document.getElementById('activityTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Barang Hilang',
                        data: @json($chartLostData),
                        borderColor: '#ef4444',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: false
                    },
                    {
                        label: 'Barang Temuan',
                        data: @json($chartFoundData),
                        borderColor: '#14b8a6',
                        borderWidth: 3,
                        tension: 0.35,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: '#fff', font: { weight: 'bold' } } } },
                scales: {
                    x: { grid: { display: false } },
                    y: { grid: { color: 'rgba(255, 255, 255, 0.04)' } }
                }
            }
        });

        // 2. Doughnut Chart Kategori
        const ctxCat = document.getElementById('categoryDistributionChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($chartCategoryData),
                    backgroundColor: ['#3b82f6', '#6366f1', '#a855f7', '#14b8a6', '#f59e0b', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { color: 'rgba(255,255,255,0.7)', font: { size: 10 } } }
                },
                cutout: '75%'
            }
        });

        // --- SCRIPT POP-UP MODAL KONFIRMASI KUSTOM ADMIN ---
        let formTargetPointer = null;

        function triggerAdminConfirm(formId, titleText, messageText) {
            // Simpan referensi form yang memicu aksi
            formTargetPointer = document.getElementById(formId);
            
            // Masukkan parameter teks ke dalam komponen modal
            document.getElementById('confirmTitle').innerText = titleText;
            document.getElementById('confirmMessage').innerText = messageText;
            
            const modal = document.getElementById('adminConfirmModal');
            const content = document.getElementById('adminModalContent');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Mengunci scrollbar halaman utama
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeAdminConfirmModal() {
            const modal = document.getElementById('adminConfirmModal');
            const content = document.getElementById('adminModalContent');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            document.body.style.overflow = ''; // Mengembalikan scrollbar
            
            setTimeout(() => {
                modal.classList.add('hidden');
                formTargetPointer = null; // Bersihkan pointer form
            }, 300);
        }

        function executeAdminAction() {
            if (formTargetPointer) {
                formTargetPointer.submit(); // Kirim form ke route tujuan Laravel
            }
        }

        // Penutupan modal otomatis jika mendeteksi keyboard ESC ditekan
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeAdminConfirmModal();
            }
        });
    </script>
</x-app-layout>
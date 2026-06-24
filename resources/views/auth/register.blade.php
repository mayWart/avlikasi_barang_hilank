<x-guest-layout>

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

        /* Glass interactive styles */
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>

    {{-- Main Wrapper Tema Gelap --}}
    <div class="fixed inset-0 z-0 bg-[#030712] overflow-y-auto no-scrollbar font-sans text-gray-200 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- Decorative Glowing Orbs (Animasi Latar Belakang) --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-600/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
        </div>

        {{-- Kotak Form Pendaftaran (Glassmorphism) --}}
        <div class="relative z-10 w-full max-w-md glass-panel p-8 sm:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.4)] animate-fade-in-up">
            
            {{-- Header Logo & Judul --}}
            <div class="mb-8 text-center">
                <div class="inline-flex p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20 mb-4 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Daftar Akun Baru</h2>
                <p class="text-gray-400 text-sm mt-1.5">Bergabung untuk mulai berbagi info kehilangan di Bangkalan</p>
            </div>

            {{-- Form Breeze --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                {{-- Input Nama --}}
                <div>
                    <label for="name" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Nama Lengkap</label>
                    <input id="name" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="text" name="name" :value="old('name')" placeholder="Masukkan nama lengkap Anda" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Alamat Email</label>
                    <input id="email" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Password</label>
                    <input id="password" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- Input Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Konfirmasi Password</label>
                    <input id="password_confirmation" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- Tombol Bawah & Link --}}
                <div class="flex items-center justify-between pt-4 mt-2">
                    <a class="text-sm text-gray-400 hover:text-white transition-colors duration-300 underline underline-offset-4 decoration-white/20 hover:decoration-white" href="{{ route('login') }}">
                        Sudah punya akun?
                    </a>

                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-sm rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.5)] transition-all duration-300 transform active:scale-95">
                        Daftar Akun
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-guest-layout>
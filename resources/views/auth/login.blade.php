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
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-blue-600/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-indigo-600/15 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
        </div>

        {{-- Kotak Form Login (Glassmorphism) --}}
        <div class="relative z-10 w-full max-w-md glass-panel p-8 sm:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.4)] animate-fade-in-up">
            
            {{-- Status Sesi Bawaan Breeze --}}
            <x-auth-session-status class="mb-4 text-sm text-green-400 p-3 bg-green-500/10 rounded-xl border border-green-500/20" :status="session('status')" />

            {{-- Header Logo & Judul --}}
            <div class="mb-8 text-center">
                <div class="inline-flex p-3 bg-blue-500/10 rounded-2xl border border-blue-500/20 mb-4 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Masuk ke Akun</h2>
                <p class="text-gray-400 text-sm mt-1.5">Info Kehilangan Bangkalan</p>
            </div>

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Alamat Email</label>
                    <input id="email" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="email" name="email" :value="old('email')" placeholder="nama@email.com" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block font-medium text-xs text-gray-400 uppercase tracking-wider mb-2 px-1">Password</label>
                    <input id="password" class="w-full px-4 py-3.5 bg-white/[0.02] border border-white/10 text-gray-100 placeholder-gray-600 focus:bg-white/[0.05] focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 rounded-xl text-sm transition-all duration-300 outline-none shadow-inner" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                </div>


                {{-- Tombol Bawah & Link Pengalihan Ke Register --}}
                <div class="flex items-center justify-between pt-4 mt-2">
                    <a class="text-sm text-gray-400 hover:text-white transition-colors duration-300 underline underline-offset-4 decoration-white/20 hover:decoration-white" href="{{ route('register') }}">
                        Belum punya akun?
                    </a>

                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-sm rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.5)] transition-all duration-300 transform active:scale-95">
                        Log In
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-guest-layout>
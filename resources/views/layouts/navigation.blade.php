<nav x-data="{ open: false }" class="bg-[#030712]/90 backdrop-blur-md border-b border-white/5 font-sans sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ (auth()->user()->email === 'admin@gmail.com' || auth()->user()->name === 'Admin' || (auth()->user()->role ?? '') === 'admin') ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:bg-blue-500 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v2.25m0 0v2.25m0-2.25h-2.25m2.25 0h2.25" /></svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-white hidden sm:block">
                            Find<span class="text-blue-500">It</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop Grid) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(strtolower(Auth::user()->email) === 'admin@gmail.com' || strtolower(Auth::user()->name) === 'admin' || strtolower(Auth::user()->role ?? '') === 'admin')
                        {{-- ===== MENU KHUSUS ADMIN ===== --}}
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium transition duration-150 ease-in-out">
                            {{ __('Analisis Admin') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium transition duration-150 ease-in-out">
                            {{ __('Feed Utama') }}
                        </a>
                    @else
                        {{-- ===== MENU KHUSUS USER BIASA ===== --}}
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium transition duration-150 ease-in-out">
                            {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('posts.mine') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('posts.mine') ? 'border-blue-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-600' }} text-sm font-medium transition duration-150 ease-in-out">
                            {{ __('Postingan Saya') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Desktop Right) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="inline-flex items-center gap-2 px-3 py-2 border border-white/5 text-sm leading-4 font-medium rounded-xl text-gray-300 bg-white/[0.03] backdrop-blur-md hover:text-white hover:bg-white/[0.07] focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>
                    
                    {{-- Badge Indikator Jika yang Login adalah Admin --}}
                    @if(strtolower(Auth::user()->email) === 'admin@gmail.com' || strtolower(Auth::user()->name) === 'admin' || strtolower(Auth::user()->role ?? '') === 'admin')
                        <span class="px-2 py-0.5 text-[10px] bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 rounded-md font-bold uppercase tracking-wider">Admin</span>
                    @endif

                    <div class="ms-0.5">
                        <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>

                <!-- Dropdown Menu Item -->
                <div x-show="dropdownOpen" 
                     x-transition:enter="transition ease-out duration-200" 
                     x-transition:enter-start="transform opacity-0 scale-95" 
                     x-transition:enter-end="transform opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-75" 
                     x-transition:leave-start="transform opacity-100 scale-100" 
                     x-transition:leave-end="transform opacity-0 scale-95" 
                     class="absolute right-0 top-full mt-2 w-48 rounded-xl shadow-2xl bg-[#0d121f] border border-white/10 divide-y divide-white/5 z-50 overflow-hidden shadow-black/80" 
                     style="display: none;">
                    
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition-colors">
                            {{ __('Profile') }}
                        </a>
                    </div>
                    
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-red-500/10 hover:text-red-400 transition-colors">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger (Mobile Toggle) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu Links -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#030712]/95 backdrop-blur-lg border-b border-white/5 absolute w-full z-40 shadow-2xl">
        <div class="pt-2 pb-3 space-y-1">
            @if(strtolower(Auth::user()->email) === 'admin@gmail.com' || strtolower(Auth::user()->name) === 'admin' || strtolower(Auth::user()->role ?? '') === 'admin')
                {{-- Link Mobile Admin --}}
                <a href="{{ route('admin.dashboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500 text-indigo-400 bg-indigo-500/10' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5' }} text-base font-medium transition duration-150 ease-in-out">
                    {{ __('Analisis Admin') }}
                </a>
                <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-400 bg-blue-500/10' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5' }} text-base font-medium transition duration-150 ease-in-out">
                    {{ __('Feed Utama') }}
                </a>
            @else
                {{-- Link Mobile User --}}
                <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-blue-400 bg-blue-500/10' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5' }} text-base font-medium transition duration-150 ease-in-out">
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('posts.mine') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 {{ request()->routeIs('posts.mine') ? 'border-blue-500 text-blue-400 bg-blue-500/10' : 'border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5' }} text-base font-medium transition duration-150 ease-in-out">
                    {{ __('Postingan Saya') }}
                </a>
            @endif
        </div>

        <!-- User Info Mobile Detail -->
        <div class="pt-4 pb-3 border-t border-white/5">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold border border-white/10 shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-base text-gray-200 leading-tight flex items-center gap-2">
                        {{ Auth::user()->name }}
                        @if(strtolower(Auth::user()->email) === 'admin@gmail.com' || strtolower(Auth::user()->name) === 'admin' || strtolower(Auth::user()->role ?? '') === 'admin')
                            <span class="px-1.5 py-0.5 text-[9px] bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 rounded font-bold uppercase">Admin</span>
                        @endif
                    </div>
                    <div class="font-medium text-sm text-gray-500 mt-0.5">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-gray-400 hover:text-gray-200 hover:bg-white/5 text-base font-medium transition duration-150 ease-in-out">
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-gray-400 hover:text-red-400 hover:bg-white/5 text-base font-medium transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
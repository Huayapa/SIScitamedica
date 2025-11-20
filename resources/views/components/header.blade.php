<header class="bg-slate-900 border-b border-slate-800 px-4 md:px-6 py-4">
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 flex-1">
            <!-- Mobile menu button -->
            <button class="lg:hidden p-2 hover:bg-slate-800 rounded-lg transition-colors"
             @click="sidebarOpen = !sidebarOpen">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Search bar -->
            {{-- <div class="relative flex-1 max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    type="text"
                    placeholder="Buscar pacientes, médicos, citas..."
                    class="w-full pl-10 pr-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div> --}}
        </div>

        <!-- Notifications -->
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-800 transition-colors">
            <span class="material-icons">person</span>
            Perfil
        </a>

    </div>
</header>
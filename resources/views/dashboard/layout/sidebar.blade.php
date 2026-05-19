<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

$logout = function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
};
?>

@volt
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white flex flex-col shadow-sm border-r border-[#E8EAF0] transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out font-['DM_Sans',sans-serif]">

    <div class="flex items-center gap-3 px-6 py-5 border-b border-[#E8EAF0] flex-shrink-0">
        <svg width="36" height="36" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="19" cy="19" r="17" stroke="#F97316" stroke-width="1.5" stroke-dasharray="3 2"/>
            <line x1="12" y1="19" x2="26" y2="19" stroke="#F97316" stroke-width="1.5"/>
            <circle cx="27" cy="19" r="2" fill="#F97316"/>
            <circle cx="19" cy="13" r="2" fill="#F97316"/>
            <circle cx="19" cy="25" r="2" fill="#F97316"/>
            <line x1="19" y1="12" x2="19" y2="14" stroke="#F97316" stroke-width="1.5"/>
            <line x1="19" y1="24" x2="19" y2="26" stroke="#F97316" stroke-width="1.5"/>
        </svg>
        <div>
            <div class="font-['Bebas_Neue',sans-serif] text-xl tracking-widest text-gray-900 leading-none">POLAM SARL</div>
            <div class="font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.2em] uppercase text-orange-500 mt-0.5">Administration</div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

        <div class="font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.18em] uppercase text-gray-400 px-3 mb-2 mt-2">Principal</div>

        <a id="menu_dashboard" href="{{ route('admin_dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-['Syne',sans-serif] font-bold text-gray-500 hover:bg-[#F5F6FA] hover:text-orange-500 rounded-l-sm transition-all border-r-[3px] border-transparent">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="1.8" stroke-linecap="round"/></svg>
            Tableau de bord
        </a>

        @if(auth()->user()->permissions['articles'] === 'full' || auth()->user()->permissions['articles'] === 'view' || auth()->user()->permissions['articles'] === 'author')
        <a id="menu_articles" href="{{ route('articles.index') }}"
            class="flex items-center px-3 py-2.5 text-sm font-['Syne',sans-serif] font-bold text-gray-500 hover:bg-[#F5F6FA] hover:text-orange-500 rounded-l-sm transition-all border-r-[3px] border-transparent">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" stroke-width="1.8"></path>
                <path d="M14 2v6h6" stroke-width="1.8"></path>
            </svg>
            Articles Blog
        </a>
        @endif

        @if(auth()->user()->permissions['contacts'] === 'full' || auth()->user()->permissions['contacts'] === 'view')
        <a id="menu_contact" href="{{ route('admin.contact.index') }}"
            class="flex items-center px-3 py-2.5 text-sm font-['Syne',sans-serif] font-bold text-gray-500 hover:bg-[#F5F6FA] hover:text-orange-500 rounded-l-sm transition-all border-r-[3px] border-transparent justify-between">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Contacts
            </span>
        </a>
        @endif

        <div class="font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.18em] uppercase text-gray-400 px-3 mb-2 mt-5">Système</div>

        @if(auth()->user()->permissions['profile'] === 'full' || auth()->user()->permissions['profile'] === 'view')
        <a id="menu_users" href="{{ route('user.index') }}"
            class="flex items-center px-3 py-2.5 text-sm font-['Syne',sans-serif] font-bold text-gray-500 hover:bg-[#F5F6FA] hover:text-orange-500 rounded-l-sm transition-all border-r-[3px] border-transparent">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Utilisateurs
        </a>
        @endif

        @if(auth()->user()->permissions['settings'] === 'full' || auth()->user()->permissions['settings'] === 'view')
        <a id="menu_settings" href="{{ route('settings.index') }}"
            class="flex items-center px-3 py-2.5 text-sm font-['Syne',sans-serif] font-bold text-gray-500 hover:bg-[#F5F6FA] hover:text-orange-500 rounded-l-sm transition-all border-r-[3px] border-transparent">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3" stroke-width="1.8"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" stroke-width="1.8"/>
            </svg>
            Paramètres
        </a>
        @endif
    </nav>

    <div class="px-4 py-4 border-t border-[#E8EAF0] relative overflow-hidden flex-shrink-0" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10 30 H25 M35 30 H50 M30 10 V25 M30 35 V50\' stroke=\'%23F97316\' stroke-width=\'0.5\' stroke-opacity=\'0.15\' fill=\'none\'/%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\' fill=\'%23F97316\' fill-opacity=\'0.12\'/%3E%3Ccircle cx=\'10\' cy=\'30\' r=\'1.5\' fill=\'%23F97316\' fill-opacity=\'0.1\'/%3E%3Ccircle cx=\'50\' cy=\'30\' r=\'1.5\' fill=\'%23F97316\' fill-opacity=\'0.1\'/%3E%3C/svg%3E'); background-size: 40px 40px;">
        <div class="flex items-center gap-3 bg-white/90 backdrop-blur-sm border border-[#E8EAF0] rounded-sm p-2 shadow-sm relative z-10">
            <div class="w-8 h-8 rounded-sm bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center font-['Syne',sans-serif] font-bold text-white text-[10px] flex-shrink-0 shadow-sm">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider text-gray-900 truncate">{{ Auth::user()->name }}</div>
                <div class="text-[9px] text-gray-400 truncate font-['DM_Sans',sans-serif]">{{ Auth::user()->email }}</div>
            </div>
            <button wire:click="logout" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Déconnexion">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const activeSegment = getActiveSegment();
        const menuItem = document.getElementById(`menu_${activeSegment}`);

        if (menuItem) {
            // Remplacement des classes CSS dynamiques pour le design Polam SARL
            menuItem.classList.add('bg-[#FFF7ED]', 'text-orange-500', 'border-orange-500');
            menuItem.classList.remove('text-gray-500', 'hover:bg-[#F5F6FA]', 'border-transparent');
        }
    });

    /**
     * Récupère le segment de l'URL situé après /admin/ (ou selon l'architecture)
     */
    function getActiveSegment() {
        const path = window.location.pathname;
        const segments = path.split('/').filter(segment => segment !== "");
        // Ajuste cet index si ton administration n'est pas à la racine (ex: /admin/dashboard)
        return segments[1] || 'dashboard';
    }
</script>
@endvolt

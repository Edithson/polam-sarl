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
    class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out">
    <div class="flex items-center justify-center h-20 bg-slate-950">
        <img src="{{ asset('media/img/logo.png') }}" alt="logo cinv-corsa" class="w-8 h-8 object-contain">
        <span class="text-xl font-black tracking-tighter text-emerald-400">CINV-COR <span
                class="text-white">ADMIN</span></span>
    </div>

    <nav class="mt-6 px-4 space-y-2">
        <a id="menu_dashboard" href="{{ route('admin_dashboard') }}" class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Tableau de bord
        </a>
        @if(auth()->user()->permissions['articles'] === 'full' || auth()->user()->permissions['articles'] === 'view' || auth()->user()->permissions['articles'] === 'author')
        <a id="menu_articles" href="{{ route('articles.index') }}"
            class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                <path d="M14 2v6h6"></path>
            </svg>
            Articles Blog
        </a>
        @endif
        @if(auth()->user()->permissions['contacts'] === 'full' || auth()->user()->permissions['contacts'] === 'view')
        <a id="menu_contact" href="{{ route('admin.contact.index') }}"
            class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            Contacts
        </a>
        @endif
        @if(auth()->user()->permissions['profile'] === 'full' || auth()->user()->permissions['profile'] === 'view')
        <a id="menu_users" href="{{ route('user.index') }}"
            class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Utilisateurs
        </a>
        @endif
        @if(auth()->user()->permissions['settings'] === 'full' || auth()->user()->permissions['settings'] === 'view')
        <a id="menu_settings" href="{{ route('settings.index') }}"
            class="flex items-center px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Paramètres
        </a>
        @endif
    </nav>

    <div class="absolute bottom-0 w-full p-4">
        <button wire:click="logout" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all group">
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="font-bold">Quitter la session</span>
        </button>
    </div>
    </aside>

    <script>
            // Met en surbrillance l'élément de menu actif
        document.addEventListener('DOMContentLoaded', function () {
            const activeSegment = getActiveSegment();
            const menuItem = document.getElementById(`menu_${activeSegment}`);
            if (menuItem) {
                menuItem.classList.add('bg-emerald-600', 'text-white');
                menuItem.classList.remove('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
            }
        });
        /**
         * Récupère le segment de l'URL situé après /admin/
         */
        function getActiveSegment() {
            const path = window.location.pathname;
            const segments = path.split('/').filter(segment => segment !== "");
            return segments[1] || 'dashboard'; // 'dashboard' par défaut si vide
        }

    </script>
@endvolt

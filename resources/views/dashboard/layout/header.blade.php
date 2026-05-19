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
<header class="fixed top-0 right-0 left-0 lg:left-64 bg-white border-b border-[#E8EAF0] px-6 py-3 flex items-center justify-between flex-shrink-0 z-40 font-['DM_Sans',sans-serif]">

    <div class="flex items-center gap-2">
        <button id="menu-btn" class="lg:hidden mr-2 text-gray-500 hover:text-orange-500 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div class="hidden sm:flex items-center gap-2">
            <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
            <span class="font-['Syne',sans-serif] text-xs font-bold text-gray-900 uppercase tracking-wider">Administration</span>
            <span class="text-gray-300 text-xs px-1">/</span>
            <span class="font-['Syne',sans-serif] text-xs font-bold text-gray-400 uppercase tracking-wider">Vue Générale</span>
        </div>
    </div>

    <div class="flex items-center gap-4">

        <button class="relative text-gray-500 hover:text-orange-500 transition-colors p-1.5 hidden md:block">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-orange-500 border border-white rounded-full"></span>
        </button>

        <div class="relative md:ml-3 border-l border-transparent md:border-[#E8EAF0] md:pl-4" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 p-1.5 rounded-sm hover:bg-[#F5F6FA] transition-all focus:outline-none border border-transparent hover:border-[#E8EAF0]">
                <div class="text-right hidden md:block">
                    <p class="font-['Syne',sans-serif] text-[10px] font-bold text-gray-900 uppercase tracking-wider">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <div class="h-8 w-8 rounded-sm bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-['Syne',sans-serif] font-bold text-[10px] shadow-sm flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white border border-[#E8EAF0] rounded-sm shadow-lg z-50 overflow-hidden"
                 style="display: none;">

                <div class="px-4 py-3 bg-[#F5F6FA] border-b border-[#E8EAF0]">
                    <p class="text-[9px] text-gray-400 font-['Syne',sans-serif] font-bold tracking-[0.15em] uppercase">Mon Compte</p>
                </div>

                <div class="p-2 space-y-1">
                    <a href="{{route('profile')}}" class="flex items-center gap-3 px-3 py-2 font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider text-gray-600 hover:bg-[#FFF7ED] hover:text-orange-500 rounded-sm transition-colors group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        Paramètres Profil
                    </a>

                    <button wire:click="logout" class="w-full flex items-center gap-3 px-3 py-2 font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider text-red-600 hover:bg-[#FEF2F2] rounded-sm transition-colors group">
                        <svg class="w-4 h-4 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
@endvolt

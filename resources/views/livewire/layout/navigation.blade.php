<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<nav x-data="{ open: false }" class="bg-white border-b border-[#E8EAF0] flex-shrink-0 z-20 font-['DM_Sans',sans-serif]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                        <svg width="24" height="24" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="19" cy="19" r="17" stroke="#F97316" stroke-width="2" stroke-dasharray="3 2"/>
                            <line x1="12" y1="19" x2="26" y2="19" stroke="#F97316" stroke-width="2"/>
                            <circle cx="27" cy="19" r="2" fill="#F97316"/>
                            <circle cx="19" cy="13" r="2" fill="#F97316"/>
                            <circle cx="19" cy="25" r="2" fill="#F97316"/>
                            <line x1="19" y1="12" x2="19" y2="14" stroke="#F97316" stroke-width="2"/>
                            <line x1="19" y1="24" x2="19" y2="26" stroke="#F97316" stroke-width="2"/>
                        </svg>
                        <span class="font-['Bebas_Neue',sans-serif] text-xl tracking-widest text-gray-900 leading-none mt-1">POLAM</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider text-gray-500 hover:text-orange-500 focus:text-orange-500 border-orange-500 transition-colors">
                        {{ __('Tableau de bord') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 bg-[#F5F6FA] hover:bg-[#FFF7ED] px-3 py-1.5 rounded-sm border border-[#E8EAF0] hover:border-orange-200 transition-all focus:outline-none">
                            <div class="w-6 h-6 rounded-sm bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center font-['Syne',sans-serif] font-bold text-white text-[9px] flex-shrink-0">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <div class="text-left hidden md:block">
                                <div class="font-['Syne',sans-serif] font-bold text-[10px] text-gray-900 uppercase tracking-wider" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                            </div>
                            <svg class="fill-current h-3 w-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-[#E8EAF0]">
                            <p class="text-xs text-gray-500 font-['DM_Sans',sans-serif]">{{ auth()->user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile')" wire:navigate class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-[#FFF7ED] hover:text-orange-500">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-red-50 hover:text-red-600">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-sm text-gray-400 hover:text-orange-500 hover:bg-[#FFF7ED] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-[#E8EAF0]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-orange-500 hover:bg-[#FFF7ED] border-orange-500">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-[#E8EAF0] bg-[#F5F6FA]">
            <div class="px-4">
                <div class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-['DM_Sans',sans-serif] text-xs text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:text-orange-500 hover:bg-[#FFF7ED]">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:text-red-600 hover:bg-red-50 text-red-500">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>

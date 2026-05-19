<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['password' => '']);

rules(['password' => ['required', 'string']]);

$confirmPassword = function () {
    $this->validate();

    if (! Auth::guard('web')->validate([
        'email' => Auth::user()->email,
        'password' => $this->password,
    ])) {
        throw ValidationException::withMessages([
            'password' => __('auth.password'),
        ]);
    }

    session(['auth.password_confirmed_at' => time()]);

    $this->redirectIntended(default: route('admin_dashboard', absolute: false), navigate: true);
};

?>

<div class="min-h-screen flex items-center justify-center bg-[#F5F6FA] py-12 px-4 sm:px-6 lg:px-8 font-['DM_Sans',sans-serif]">
    <div class="max-w-md w-full bg-white rounded-sm shadow-sm border border-[#E8EAF0] p-8">

        <div class="flex flex-col items-center justify-center text-center mb-8">
            <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold font-['Syne',sans-serif] text-gray-900">Zone Sécurisée</h2>
            <p class="mt-2 text-sm text-gray-500">Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.</p>
        </div>

        <form wire:submit="confirmPassword" class="space-y-4">
            <div x-data="{ show: false }">
                <label for="password" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1.5">Mot de passe</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>

                    <input wire:model="password" id="password"
                        :type="show ? 'text' : 'password'"
                        name="password"
                        required autocomplete="current-password"
                        class="w-full pl-10 pr-10 py-2.5 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm font-['DM_Sans',sans-serif] text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all"
                        placeholder="••••••••">

                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-orange-500 transition-colors focus:outline-none">
                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            <button type="submit" class="w-full flex justify-center items-center gap-2 mt-6 py-3 px-4 border border-transparent rounded-sm shadow-sm text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-white bg-orange-500 hover:bg-[#EA580C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all active:scale-[0.98]">
                Confirmer l'accès
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>
    </div>
</div>

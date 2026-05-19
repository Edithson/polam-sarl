<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state('token')->locked();

state([
    'email' => fn () => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$resetPassword = function () {
    $this->validate();

    $status = Password::reset(
        $this->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) {
            $user->forceFill([
                'password' => Hash::make($this->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    if ($status != Password::PASSWORD_RESET) {
        $this->addError('email', __($status));

        return;
    }

    Session::flash('status', __($status));

    $this->redirectRoute('login', navigate: true);
};

?>

<div class="min-h-screen flex items-center justify-center bg-[#F5F6FA] py-12 px-4 sm:px-6 lg:px-8 font-['DM_Sans',sans-serif]">
    <div class="max-w-md w-full bg-white rounded-sm shadow-sm border border-[#E8EAF0] p-8">

        <div class="flex flex-col items-center justify-center text-center mb-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-6 transition-transform hover:scale-105">
                <svg width="36" height="36" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="19" cy="19" r="17" stroke="#F97316" stroke-width="1.5" stroke-dasharray="3 2"/>
                    <line x1="12" y1="19" x2="26" y2="19" stroke="#F97316" stroke-width="1.5"/>
                    <circle cx="27" cy="19" r="2" fill="#F97316"/>
                    <circle cx="19" cy="13" r="2" fill="#F97316"/>
                    <circle cx="19" cy="25" r="2" fill="#F97316"/>
                    <line x1="19" y1="12" x2="19" y2="14" stroke="#F97316" stroke-width="1.5"/>
                    <line x1="19" y1="24" x2="19" y2="26" stroke="#F97316" stroke-width="1.5"/>
                </svg>
                <div class="text-left">
                    <div class="font-['Bebas_Neue',sans-serif] text-2xl tracking-widest text-gray-900 leading-none">POLAM SARL</div>
                    <div class="font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.2em] uppercase text-orange-500 mt-0.5">Administration</div>
                </div>
            </a>
            <h2 class="text-2xl font-bold font-['Syne',sans-serif] text-gray-900">Nouveau mot de passe</h2>
            <p class="mt-2 text-sm text-gray-500">Veuillez définir votre nouveau mot de passe sécurisé.</p>
        </div>

        <form wire:submit="resetPassword" class="space-y-4">
            <div>
                <label for="email" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1.5">Adresse Email</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input wire:model="email" type="email" name="email" id="email" required autofocus class="w-full pl-10 pr-4 py-2.5 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm font-['DM_Sans',sans-serif] text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all" placeholder="nom@entreprise.cm" autocomplete="username">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <div x-data="{ show: false }">
                <label for="password" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1.5">Nouveau mot de passe</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>

                    <input wire:model="password" id="password"
                        :type="show ? 'text' : 'password'"
                        name="password"
                        required autocomplete="new-password"
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

            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1.5">Confirmation</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>

                    <input wire:model="password_confirmation" id="password_confirmation"
                        :type="show ? 'text' : 'password'"
                        name="password_confirmation" required autocomplete="new-password"
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
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
            </div>

            <button type="submit" class="w-full flex justify-center items-center gap-2 mt-6 py-3 px-4 border border-transparent rounded-sm shadow-sm text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-white bg-orange-500 hover:bg-[#EA580C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all active:scale-[0.98]">
                Mettre à jour
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </form>
    </div>
</div>

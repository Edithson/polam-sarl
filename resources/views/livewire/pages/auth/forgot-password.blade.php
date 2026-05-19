<?php

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function () {
    $this->validate();

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink(
        $this->only('email')
    );

    if ($status != Password::RESET_LINK_SENT) {
        $this->addError('email', __($status));

        return;
    }

    $this->reset('email');

    Session::flash('status', __($status));
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
            <h2 class="text-2xl font-bold font-['Syne',sans-serif] text-gray-900">Mot de passe oublié ?</h2>
            <p class="mt-2 text-sm text-gray-500">Aucun problème. Indiquez-nous simplement votre adresse email et nous vous enverrons un lien de réinitialisation.</p>
        </div>

        <x-auth-session-status class="mb-4 text-xs font-bold text-green-600 bg-green-50 p-3 rounded-sm border border-green-200" :status="session('status')" />

        <form wire:submit="sendPasswordResetLink" class="space-y-5">
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

            <button type="submit" class="w-full flex justify-center items-center gap-2 mt-6 py-3 px-4 border border-transparent rounded-sm shadow-sm text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-white bg-orange-500 hover:bg-[#EA580C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all active:scale-[0.98]">
                Envoyer le lien
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs font-bold font-['Syne',sans-serif] text-gray-500 hover:text-orange-500 transition-colors uppercase tracking-wider">← Retour à la connexion</a>
        </div>
    </div>
</div>

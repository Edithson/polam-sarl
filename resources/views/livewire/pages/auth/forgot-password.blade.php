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

<div class="min-h-screen flex flex-col lg:flex-row bg-slate-50">

    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative items-center justify-center p-12 overflow-hidden">
        <div class="absolute top-0 right-0 w-full h-full opacity-20">
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-emerald-500 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-blue-600 rounded-full blur-[120px]"></div>
        </div>

        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 0.5px, transparent 0.5px); background-size: 30px 30px;"></div>

        <div class="relative z-10 max-w-lg text-center">
            <div class="mb-12 flex justify-center items-center w-full">
                <a href="{{route('home')}}" class="text-2xl font-black text-white flex items-center gap-2">
                    <img src="{{ asset('media/img/logo.png') }}" alt="logo cinv-corsa" class="w-8 h-8 object-contain">
                    CINV-COR<span class="text-emerald-600">SA</span>
                </a>
            </div>
            <h1 class="text-5xl font-black text-white mb-6 leading-tight">
                Gérez vos archives avec <span class="text-emerald-400">précision.</span>
            </h1>
            <p class="text-slate-400 text-xl leading-relaxed">
                Accédez à votre plateforme sécurisée de gestion documentaire et pilotez la transformation numérique de votre organisation.
            </p>

            <div class="mt-12 grid grid-cols-2 gap-6 text-left">
                <div class="bg-white/5 border border-white/10 p-4 rounded-2xl">
                    <span class="text-emerald-400 text-2xl font-bold">100%</span>
                    <p class="text-slate-500 text-sm">Données Chiffrées</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-4 rounded-2xl">
                    <span class="text-blue-400 text-2xl font-bold">24/7</span>
                    <p class="text-slate-500 text-sm">Accès Cloud</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16">
        <div class="w-full max-w-md">

            {{-- Masquer ce block pour les grand écrans --}}
            <div class="lg:hidden mb-12 mt-5 flex justify-center w-full items-center">
                <a href="{{route('home')}}" class="text-2xl font-black text-slate-900 flex items-center gap-2">
                    <img src="{{ asset('media/img/logo.png') }}" alt="logo cinv-corsa" class="w-8 h-8 object-contain">
                    CINV-COR<span class="text-emerald-600">SA</span>
                </a>
            </div>
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Vous avez oublié votre mot de passe ?</h2>
                <p class="text-slate-500">Aucun problème. Indiquez-nous simplement votre adresse email et nous vous enverrons un lien de réinitialisation.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink">
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input wire:model="email" type="email" name="email" id="email" required autofocus class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300" placeholder="nom@entreprise.cm" autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 active:scale-[0.98]">
                        Envoyer le lien de réinitialisation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

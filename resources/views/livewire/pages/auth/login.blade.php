<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('admin_dashboard', absolute: false), navigate: true);
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
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Bon retour parmi nous !</h2>
                <p class="text-slate-500">Veuillez entrer vos identifiants pour accéder au dashboard.</p>
            </div>

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input wire:model="form.email" type="email" required autofocus class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300" placeholder="nom@entreprise.cm">
                    </div>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <label class="text-sm font-semibold text-slate-700">Mot de passe</label>
                    </div>
                    <div class="relative group" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>

                        <input wire:model="form.password"
                            :type="show ? 'text' : 'password'"
                            required
                            class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300"
                            placeholder="••••••••">

                        <button type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors focus:outline-none">

                            <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    <div class="w-full justify-end">
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 float-right mt-2">Oublié ?</a>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                    <label for="remember" class="ml-2 text-sm text-slate-500">Rester connecté</label>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 active:scale-[0.98]">
                    Se connecter au Dashboard
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Pas encore de compte ? <a href="{{ route('register') }}" class="text-emerald-600 font-bold hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>
</div>

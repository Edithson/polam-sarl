<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\layout;

layout('layouts.guest');

$sendVerification = function () {
    if (Auth::user()->hasVerifiedEmail()) {
        $this->redirectIntended(default: route('admin_dashboard', absolute: false), navigate: true);

        return;
    }

    Auth::user()->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<div class="min-h-screen flex items-center justify-center bg-[#F5F6FA] py-12 px-4 sm:px-6 lg:px-8 font-['DM_Sans',sans-serif]">
    <div class="max-w-md w-full bg-white rounded-sm shadow-sm border border-[#E8EAF0] p-8">

        <div class="flex flex-col items-center justify-center text-center mb-6">
            <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold font-['Syne',sans-serif] text-gray-900">Vérifiez votre Email</h2>
            <p class="mt-2 text-sm text-gray-500">Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer ?</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 text-xs font-bold text-green-600 bg-green-50 p-3 rounded-sm border border-green-200 text-center">
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de l'inscription.
            </div>
        @endif

        <div class="flex flex-col gap-3 mt-6">
            <button wire:click="sendVerification" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-sm shadow-sm text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-white bg-orange-500 hover:bg-[#EA580C] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all active:scale-[0.98]">
                Renvoyer le lien
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <button wire:click="logout" type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-[#E8EAF0] rounded-sm text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-gray-600 bg-white hover:bg-[#F5F6FA] hover:text-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
                Se déconnecter
            </button>
        </div>
    </div>
</div>

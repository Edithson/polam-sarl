<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'password' => '',
    'confirmingUserDeletion' => false // On gère l'affichage nous-même
]);

rules(['password' => ['required', 'string', 'current_password']]);

$deleteUser = function (Logout $logout) {
    $this->validate();

    tap(Auth::user(), $logout(...))->delete();

    $this->redirect('/', navigate: true);
};

?>

<section class="space-y-6" x-data="{ open: @entangle('confirmingUserDeletion') }">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Supprimer le compte') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées.') }}
        </p>
    </header>

    <x-danger-button x-on:click="open = true" class="flex items-center gap-2 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
        {{ __('Supprimer le compte') }}
    </x-danger-button>

    {{-- Fenêtre modale reconstruite --}}
    <div
        x-show="open"
        class="fixed inset-0 w-screen h-screen flex items-center justify-center"
        style="z-index: 9999; display: none;"
        x-cloak
    >
        {{-- 1. L'arrière-plan (Backdrop) --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500/75 transition-opacity"
            x-on:click="open = false"
        ></div>

        {{-- 2. La boîte de dialogue --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full sm:p-6"
        >
            <form wire:submit="deleteUser">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
                </h2>

                <p class="mt-3 text-sm text-gray-600">
                    {{ __('Veuillez entrer votre mot de passe pour confirmer la suppression définitive.') }}
                </p>

                <div class="mt-6">
                    <input
                        wire:model="password"
                        type="password"
                        class="w-full pl-4 pr-12 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-300"
                        placeholder="{{ __('Mot de passe') }}"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="open = false" class="flex items-center gap-2 text-black px-8 py-3 rounded-xl font-bold transition-all shadow-lg active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                        {{ __('Annuler') }}
                    </x-secondary-button>

                    <x-danger-button class="flex items-center gap-2 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                        {{ __('Confirmer la suppression') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</section>

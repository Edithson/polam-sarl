<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'password' => '',
    'confirmingUserDeletion' => false
]);

rules(['password' => ['required', 'string', 'current_password']]);

$deleteUser = function (Logout $logout) {
    $this->validate();

    tap(Auth::user(), $logout(...))->delete();

    $this->redirect('/', navigate: true);
};

?>

<section class="font-['DM_Sans',sans-serif]" x-data="{ open: @entangle('confirmingUserDeletion') }">
    <header class="mb-6 border-b border-red-200 pb-3">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-3 h-3 bg-red-600 rounded-sm inline-block"></span>
            <h2 class="font-['Syne',sans-serif] text-sm font-bold text-red-800 uppercase tracking-wider">
                Zone de danger
            </h2>
        </div>
        <p class="text-[11px] text-red-600 ml-5">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
        </p>
    </header>

    <button x-on:click="open = true" type="button" class="bg-white border border-red-200 text-red-600 px-6 py-2.5 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all shadow-sm active:scale-[0.98]">
        Supprimer le compte
    </button>

    {{-- Fenêtre modale --}}
    <div
        x-show="open"
        class="fixed inset-0 w-screen h-screen flex items-center justify-center p-4"
        style="z-index: 9999; display: none;"
        x-cloak
    >
        {{-- L'arrière-plan --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
            x-on:click="open = false"
        ></div>

        {{-- La boîte de dialogue --}}
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative bg-white rounded-sm w-full max-w-md shadow-xl border-t-4 border-red-600 overflow-hidden"
        >
            <form wire:submit="deleteUser" class="p-6">
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">
                    Confirmer la suppression
                </h2>

                <p class="text-xs text-gray-600 font-['DM_Sans',sans-serif] mb-6">
                    Veuillez entrer votre mot de passe pour confirmer la suppression définitive de votre compte.
                </p>

                <div class="mb-6">
                    <input
                        wire:model="password"
                        type="password"
                        class="w-full px-4 py-2.5 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm text-xs focus:ring-1 focus:ring-red-500 focus:border-red-500 outline-none transition-all placeholder:text-gray-400"
                        placeholder="Mot de passe"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] text-red-600" />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="open = false" class="flex-1 px-4 py-2.5 rounded-sm bg-[#F5F6FA] border border-[#E8EAF0] text-gray-600 font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-gray-200 transition-all active:scale-[0.98]">
                        Annuler
                    </button>

                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-sm bg-red-600 text-white font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-red-700 transition-all active:scale-[0.98]">
                        Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

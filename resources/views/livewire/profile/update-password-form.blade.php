<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
};

?>

<section class="font-['DM_Sans',sans-serif]">
    <header class="mb-6 border-b border-[#E8EAF0] pb-3">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
            <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">
                Mot de passe
            </h2>
        </div>
        <p class="text-[11px] text-gray-500 ml-5">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form wire:submit="updatePassword" class="space-y-5">
        <div>
            <label for="update_password_current_password" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Mot de passe actuel</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                   class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all placeholder:text-gray-300" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2 text-[10px]" />
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nouveau mot de passe</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" autocomplete="new-password"
                   class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all placeholder:text-gray-300" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px]" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Confirmer le mot de passe</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all placeholder:text-gray-300" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px]" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-orange-500 transition-all active:scale-[0.98]">
                Enregistrer
            </button>

            <span x-data="{ show: false }"
                  x-show="show"
                  x-transition
                  x-init="@this.on('password-updated', () => { show = true; setTimeout(() => show = false, 3000) })"
                  class="font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider text-green-600"
                  style="display: none;">
                Mot de passe mis à jour.
            </span>
        </div>
    </form>
</section>

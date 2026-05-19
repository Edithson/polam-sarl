<?php

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'name' => fn () => auth()->user()->name,
    'email' => fn () => auth()->user()->email
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    $this->dispatch('profile-updated', name: $user->name);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $this->redirectIntended(default: route('dashboard', absolute: false));

        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

?>

<section class="font-['DM_Sans',sans-serif]">
    <header class="mb-6 border-b border-[#E8EAF0] pb-3">
        <div class="flex items-center gap-2 mb-1">
            <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
            <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">
                Information de profil
            </h2>
        </div>
        <p class="text-[11px] text-gray-500 ml-5">
            Mettre à jour les informations de votre profil et votre adresse email.
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="space-y-5">
        <div>
            <label for="name" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nom</label>
            <input wire:model="name" id="name" name="name" type="text" required autofocus autocomplete="name"
                   class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
            <x-input-error class="text-red-500 text-[10px] mt-1" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Email</label>
            <input wire:model="email" id="email" name="email" type="email" required autocomplete="username"
                   class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all" />
            <x-input-error class="text-red-500 text-[10px] mt-1" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-[#FFF7ED] border border-orange-200 rounded-sm">
                    <p class="text-[11px] text-gray-800">
                        Votre adresse email n'est pas vérifiée.
                        <button wire:click.prevent="sendVerification" class="font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider text-orange-500 hover:text-orange-600 underline ml-1">
                            Renvoyer l'email de vérification.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider text-green-600">
                            Un nouveau lien a été envoyé.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-orange-500 transition-all active:scale-[0.98]">
                Enregistrer
            </button>

            <span x-data="{ show: false }"
                  x-show="show"
                  x-transition
                  x-init="@this.on('profile-updated', () => { show = true; setTimeout(() => show = false, 3000) })"
                  class="font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider text-green-600"
                  style="display: none;">
                Enregistré.
            </span>
        </div>
    </form>
</section>

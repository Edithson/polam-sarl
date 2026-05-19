<?php

use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;

    public string $name;
    public string $email;
    public string $password = '';
    public string $password_confirmation = '';
    public array $permissions = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->permissions = $user->permissions ?? [
            'articles' => AccessLevel::NONE->value,
            'contacts' => AccessLevel::NONE->value,
            'settings' => AccessLevel::NONE->value,
            'profile'  => AccessLevel::NONE->value,
        ];
    }

    public function updateProfileInformation()
    {
        $this->authorize('update', $this->user);
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
        ]);

        $this->user->update($validated);
        session()->flash('status-profile', 'Informations mises à jour.');
    }

    public function updatePassword()
    {
        $this->authorize('update', $this->user);
        $validated = $this->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $this->user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset(['password', 'password_confirmation']);
        session()->flash('status-password', 'Mot de passe modifié.');
    }

    public function updatePermissions()
    {
        $this->authorize('update', $this->user);
        $this->user->update([
            'permissions' => $this->permissions
        ]);
        session()->flash('status-permissions', 'Permissions enregistrées.');
    }

    public function deleteUser()
    {
        $this->authorize('delete', $this->user);
        $this->user->delete();
        return $this->redirect(route('user.index'), navigate: true);
    }

    public function rendering($view)
    {
        return $view->layout('dashboard.index')->section('content');
    }
};
?>

<div class="max-w-4xl mx-auto p-6 space-y-6 font-['DM_Sans',sans-serif]">

    <div class="flex items-center justify-between mb-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-5 h-0.5 bg-orange-500 inline-block"></span>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-orange-500">Édition</span>
            </div>
            <h1 class="font-['Bebas_Neue',sans-serif] text-3xl tracking-wider text-gray-900 leading-none">{{ $user->name }}</h1>
        </div>
        <a href="{{ route('user.index') }}" class="font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider text-gray-500 hover:text-orange-500 transition-colors flex items-center gap-2">
            ← Retour
        </a>
    </div>

    <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
        <form wire:submit="updateProfileInformation">
            <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Informations générales</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nom complet</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px]" />
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px]" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-orange-500 transition-all">Enregistrer</button>
                @if (session('status-profile'))
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-xs font-bold text-orange-500">
                        {{ session('status-profile') }}
                    </span>
                @endif
            </div>
        </form>
    </section>

    <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
        <form wire:submit="updatePermissions">
            <div class="flex flex-col mb-4 border-b border-[#E8EAF0] pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                    <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Permissions par module</h2>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 ml-5">Définissez le niveau d'autorisation pour cet utilisateur.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                @php
                    $modules = [
                        'articles' => 'Gestion des Articles',
                        'contacts' => 'Gestion des Contacts',
                        'settings' => 'Paramètres Système',
                        'profile'  => 'Gestion Profil'
                    ];
                    $levels = [
                        AccessLevel::NONE->value   => 'Aucun accès',
                        AccessLevel::VIEW->value   => 'Lecture seule',
                        AccessLevel::AUTHOR->value => 'Auteur (ses contenus)',
                        AccessLevel::FULL->value   => 'Accès Total'
                    ];
                @endphp

                @foreach($modules as $key => $label)
                    <div class="p-4 border border-[#E8EAF0] rounded-sm bg-[#F5F6FA]">
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-700 mb-2">{{ $label }}</label>
                        <select wire:model="permissions.{{ $key }}"
                                class="w-full bg-white px-3 py-2 rounded-sm border border-[#E8EAF0] text-xs font-bold text-gray-600 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                            @foreach($levels as $value => $labelText)
                                <option value="{{ $value }}">{{ $labelText }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-orange-500 transition-all">
                    Enregistrer les droits
                </button>
                @if (session('status-permissions'))
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-xs font-bold text-orange-500">
                        {{ session('status-permissions') }}
                    </span>
                @endif
            </div>
        </form>
    </section>

    <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
        <form wire:submit="updatePassword">
            <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Sécurité</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nouveau mot de passe</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px]" />
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Confirmation</label>
                    <input wire:model="password_confirmation" type="password" class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-orange-500 transition-all">Changer le mot de passe</button>
                @if (session('status-password'))
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-xs font-bold text-orange-500">
                        {{ session('status-password') }}
                    </span>
                @endif
            </div>
        </form>
    </section>

    <section class="p-6 bg-[#FEF2F2] rounded-sm border border-red-200" x-data="{ confirmingDeletion: false }">
        <h2 class="font-['Syne',sans-serif] text-sm font-bold text-red-800 uppercase tracking-wider mb-2">Zone de danger</h2>
        <p class="text-[11px] text-red-600 mb-4">La suppression d'un utilisateur est irréversible. Toutes ses données seront effacées.</p>

        <button type="button" @click="confirmingDeletion = true" class="bg-white text-red-600 border border-red-200 px-6 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all shadow-sm">
            Supprimer cet utilisateur
        </button>

        {{-- Modal de confirmation --}}
        <template x-teleport="body">
            <div x-show="confirmingDeletion" class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-cloak>
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="confirmingDeletion = false"></div>
                <div class="relative bg-white rounded-sm p-6 max-w-sm w-full shadow-xl border-t-4 border-red-600">
                    <h3 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Confirmer la suppression</h3>
                    <p class="text-xs text-gray-600 mb-6 font-['DM_Sans',sans-serif]">Êtes-vous sûr de vouloir supprimer <strong>{{ $user->name }}</strong> ? Cette action est définitive.</p>
                    <div class="flex gap-2">
                        <button @click="confirmingDeletion = false" class="flex-1 px-4 py-2 rounded-sm bg-[#F5F6FA] border border-[#E8EAF0] text-gray-600 font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-gray-200 transition-all">Annuler</button>
                        <button wire:click="deleteUser" class="flex-1 px-4 py-2 rounded-sm bg-red-600 text-white font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-red-700 transition-all">Supprimer</button>
                    </div>
                </div>
            </div>
        </template>
    </section>
</div>

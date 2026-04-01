<?php

use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;

    // État pour les informations de profil
    public string $name;
    public string $email;

    // État pour le mot de passe
    public string $password = '';
    public string $password_confirmation = '';

    // État pour les permissions
    public array $permissions = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        // On récupère les permissions existantes ou on initialise par défaut
        $this->permissions = $user->permissions ?? [
            'articles' => AccessLevel::NONE->value,
            'contacts' => AccessLevel::NONE->value,
            'settings' => AccessLevel::NONE->value,
            'profile'  => AccessLevel::NONE->value,
        ];
    }

    /**
     * Met à jour uniquement le nom et l'email
     */
    public function updateProfileInformation()
    {
        $this->authorize('update', $this->user);
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
        ]);

        $this->user->update($validated);

        session()->flash('status', 'profile-updated');
    }

    /**
     * Met à jour uniquement le mot de passe
     */
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
        session()->flash('status', 'password-updated');
    }

    /**
     * Met à jour uniquement les permissions
     */
    public function updatePermissions()
    {
        $this->authorize('update', $this->user);
        // On s'assure que les valeurs correspondent aux Enums (exemple simplifié)
        $this->user->update([
            'permissions' => $this->permissions
        ]);

        session()->flash('status', 'permissions-updated');
    }

    /**
     * Supprime l'utilisateur
     */
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

<div class="max-w-4xl mx-auto p-6 space-y-8">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-slate-900">Modifier l'utilisateur : {{ $user->name }}</h1>
        <a href="{{ route('user.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
            Retour à la liste
        </a>
    </div>

    <section class="p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
        <form wire:submit="updateProfileInformation">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Informations générales</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nom complet</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-xl font-bold hover:bg-slate-800 transition-all">Enregistrer les infos</button>
                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-emerald-600 font-medium">Enregistré.</p>
                @endif
            </div>
        </form>
    </section>

    <section class="p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
        <form wire:submit="updatePermissions">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800">Permissions par module</h2>
            </div>
            <p class="text-sm text-slate-500 mb-8 ml-10">Définissez le niveau d'autorisation pour chaque fonctionnalité du système.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                @php
                    $modules = [
                        'articles' => 'Gestion des Articles',
                        'contacts' => 'Gestion des Contacts',
                        'settings' => 'Paramètres Système',
                        'profile'  => 'Gestion Profil'
                    ];
                    $levels = [
                        AccessLevel::NONE->value   => ['label' => 'Aucun accès', 'color' => 'text-slate-400'],
                        AccessLevel::VIEW->value   => ['label' => 'Lecture seule', 'color' => 'text-blue-600'],
                        AccessLevel::AUTHOR->value => ['label' => 'Auteur (ses contenus)', 'color' => 'text-emerald-600'],
                        AccessLevel::FULL->value   => ['label' => 'Accès Total', 'color' => 'text-purple-600']
                    ];
                @endphp

                @foreach($modules as $key => $label)
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                        <label class="block text-sm font-bold text-slate-700 mb-3">{{ $label }}</label>
                        <select wire:model="permissions.{{ $key }}"
                                class="w-full bg-white px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            @foreach($levels as $value => $info)
                                <option value="{{ $value }}">{{ $info['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-800 transition-all active:scale-95 shadow-lg shadow-slate-200">
                    Enregistrer les droits
                </button>
                @if (session('status') === 'permissions-updated')
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 font-bold">
                        Permissions enregistrées
                    </span>
                @endif
            </div>
        </form>
    </section>

    <section class="p-6 bg-white rounded-2xl shadow-sm border border-slate-200">
        <form wire:submit="updatePassword">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Sécurité</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nouveau mot de passe</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe</label>
                    <input wire:model="password_confirmation" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-xl font-bold hover:bg-slate-800 transition-all">Changer le mot de passe</button>
                @if (session('status') === 'password-updated')
                    <p class="text-sm text-emerald-600 font-medium">Mot de passe modifié.</p>
                @endif
            </div>
        </form>
    </section>

    <section class="p-6 bg-red-50 rounded-2xl border border-red-200" x-data="{ confirmingDeletion: false }">
        <h2 class="text-lg font-bold text-red-800 mb-2">Zone de danger</h2>
        <p class="text-sm text-red-600 mb-4">La suppression d'un utilisateur est irréversible. Toutes ses données seront effacées.</p>

        <button type="button" @click="confirmingDeletion = true" class="bg-red-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-200">
            Supprimer cet utilisateur
        </button>

        {{-- Modal de confirmation --}}
        <template x-teleport="body">
            <div x-show="confirmingDeletion" class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="confirmingDeletion = false"></div>
                <div class="relative bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">Confirmer la suppression ?</h3>
                    <p class="text-slate-600 mb-6">Êtes-vous sûr de vouloir supprimer <strong>{{ $user->name }}</strong> ? Cette action est définitive.</p>
                    <div class="flex gap-3">
                        <button @click="confirmingDeletion = false" class="flex-1 px-4 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Annuler</button>
                        <button wire:click="deleteUser" class="flex-1 px-4 py-3 rounded-xl bg-red-600 text-white font-bold hover:bg-red-700 transition-all">Oui, supprimer</button>
                    </div>
                </div>
            </div>
        </template>
    </section>
</div>

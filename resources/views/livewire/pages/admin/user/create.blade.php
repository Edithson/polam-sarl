<?php

use App\Models\User;
use App\Enums\AccessLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;

new class extends Component {
    // État du formulaire
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // État pour les permissions (valeurs par défaut à 'none')
    public array $permissions = [];

    public function mount()
    {
        // Initialisation par défaut pour un nouvel utilisateur
        $this->permissions = [
            'articles' => AccessLevel::NONE->value,
            'contacts' => AccessLevel::NONE->value,
            'settings' => AccessLevel::NONE->value,
            'profile'  => AccessLevel::NONE->value,
        ];
    }

    /**
     * Création de l'utilisateur
     */
    public function save()
    {
        $this->authorize('create', User::class);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['required', 'array'],
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'permissions' => $this->permissions,
        ]);

        return $this->redirect(route('user.index'), navigate: true);
    }

    public function rendering($view)
    {
        return $view->layout('dashboard.index')->section('content');
    }
};
?>

<div class="max-w-4xl mx-auto p-6">

    <form wire:submit="save" class="space-y-8">
        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Nouvel Utilisateur</h1>
                <p class="text-slate-500">Remplissez les informations pour enregistrer un nouveau collaborateur.</p>
            </div>
            <a href="{{ route('user.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                Annuler et quitter
            </a>
        </div>

        <section class="p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800">Identité</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nom complet</label>
                    <input wire:model="name" type="text" placeholder="Ex: Jean Dupont"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Adresse Email</label>
                    <input wire:model="email" type="email" placeholder="jean@corsa.com"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
        </section>

        <section class="p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="2"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800">Permissions par module</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                    <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/50">
                        <label class="block text-sm font-bold text-slate-700 mb-3">{{ $label }}</label>
                        <select wire:model="permissions.{{ $key }}"
                                class="w-full bg-white px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                            @foreach($levels as $value => $labelText)
                                <option value="{{ $value }}">{{ $labelText }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2"></path></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-800">Sécurité</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Mot de passe</label>
                    <input wire:model="password" type="password"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Confirmer le mot de passe</label>
                    <input wire:model="password_confirmation" type="password"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
                </div>
            </div>
        </section>

        {{-- Barre d'actions fixe en bas ou simple bouton --}}
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-emerald-600 text-white px-10 py-4 rounded-2xl font-extrabold hover:bg-emerald-700 transition-all active:scale-95 shadow-xl shadow-emerald-500/20 flex items-center gap-2">
                <span>Créer l'utilisateur</span>
                <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"></path></svg>
                {{-- Loader pendant la soumission --}}
                <svg wire:loading class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

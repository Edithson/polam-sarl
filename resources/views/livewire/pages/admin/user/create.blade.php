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

<div class="max-w-4xl mx-auto p-6 font-['DM_Sans',sans-serif]">

    <form wire:submit="save" class="space-y-6">
        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-5 h-0.5 bg-orange-500 inline-block"></span>
                    <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-orange-500">Gestion des accès</span>
                </div>
                <h1 class="font-['Bebas_Neue',sans-serif] text-3xl tracking-wider text-gray-900 leading-none">Nouvel Utilisateur</h1>
            </div>
            <a href="{{ route('user.index') }}" class="font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider text-gray-500 hover:text-orange-500 transition-colors flex items-center gap-2">
                ← Retour à la liste
            </a>
        </div>

        {{-- Identité --}}
        <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
            <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Identité</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Nom complet</label>
                    <input wire:model="name" type="text" placeholder="Ex: Jean Dupont"
                        class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all placeholder-gray-400">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px]" />
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Adresse Email</label>
                    <input wire:model="email" type="email" placeholder="jean@polam.cm"
                        class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all placeholder-gray-400">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px]" />
                </div>
            </div>
        </section>

        {{-- Permissions --}}
        <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
            <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Permissions par module</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
        </section>

        {{-- Sécurité --}}
        <section class="p-6 bg-white rounded-sm shadow-xs border border-[#E8EAF0]">
            <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                <h2 class="font-['Syne',sans-serif] text-sm font-bold text-gray-900 uppercase tracking-wider">Sécurité</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Mot de passe</label>
                    <input wire:model="password" type="password"
                        class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px]" />
                </div>
                <div>
                    <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-2">Confirmer le mot de passe</label>
                    <input wire:model="password_confirmation" type="password"
                        class="w-full px-4 py-2.5 bg-[#F5F6FA] rounded-sm border border-[#E8EAF0] text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>
            </div>
        </section>

        {{-- Actions --}}
        <div class="flex justify-end pt-4 border-t border-[#E8EAF0]">
            <button type="submit"
                class="bg-orange-500 text-white px-8 py-3 rounded-sm font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-[#EA580C] transition-all active:scale-[0.98] shadow-sm flex items-center gap-2">
                <span>Créer l'utilisateur</span>
                <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2"></path></svg>
                {{-- Loader --}}
                <svg wire:loading class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

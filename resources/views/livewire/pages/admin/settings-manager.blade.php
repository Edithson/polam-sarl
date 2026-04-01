<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $settings;
    public $name, $slogan, $email, $adresse, $bp, $horaire;
    public $logo;
    public $phones = [];
    public $socials = []; // format: [['platform' => '', 'url' => '']]

    public function mount()
    {
        $this->settings = Setting::first() ?? new Setting();

        $this->name = $this->settings->name ?? 'CINV-CORSA';
        $this->slogan = $this->settings->slogan;
        $this->email = $this->settings->email;
        $this->adresse = $this->settings->adresse;
        $this->bp = $this->settings->bp;
        $this->horaire = $this->settings->horaire;

        // Initialisation des tableaux JSON
        $this->phones = $this->settings->phones ?? [''];

        $savedSocials = $this->settings->socials ?? [];
        foreach($savedSocials as $platform => $url) {
            $this->socials[] = ['platform' => $platform, 'url' => $url];
        }
        if (empty($this->socials)) $this->socials[] = ['platform' => '', 'url' => ''];
    }

    // Gestion dynamique des téléphones
    public function addPhone() { $this->phones[] = ''; }
    public function removePhone($index) { unset($this->phones[$index]); $this->phones = array_values($this->phones); }

    // Gestion dynamique des réseaux sociaux
    public function addSocial() { $this->socials[] = ['platform' => '', 'url' => '']; }
    public function removeSocial($index) { unset($this->socials[$index]); $this->socials = array_values($this->socials); }

    public function save()
    {
        $this->authorize('create', Setting::class);

        $this->validate([
            'logo' => 'nullable|image|max:1024',
            'name' => 'required|string',
            'email' => 'nullable|email',
        ]);

        $data = [
            'name' => $this->name,
            'slogan' => $this->slogan,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'bp' => $this->bp,
            'horaire' => $this->horaire,
            'phones' => array_filter($this->phones), // Enlever les vides
        ];

        // Reconstruction du dictionnaire socials (Clé => Valeur)
        $formattedSocials = [];
        foreach($this->socials as $item) {
            if(!empty($item['platform']) && !empty($item['url'])) {
                $formattedSocials[$item['platform']] = $item['url'];
            }
        }
        $data['socials'] = $formattedSocials;

        if ($this->logo) {
            $data['logo'] = $this->logo->store('settings', 'public');
        }

        Setting::updateOrCreate(['id' => 1], $data);

        // Rafraîchir le cache immédiatement
        Setting::clearCache();

        session()->flash('status', 'Paramètres mis à jour avec succès !');
        $this->dispatch('settings-updated');
    }
}; ?>

<div class="max-w-5xl mx-auto space-y-6">
    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 italic border-b pb-2">Identité du site</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Nom du site</label>
                        <input wire:model="name" type="text" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Slogan</label>
                        <input wire:model="slogan" type="text" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 italic border-b pb-2">Contacts & Localisation</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input wire:model="email" type="email" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Boîte Postale (BP)</label>
                        <input wire:model="bp" type="text" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Adresse Physique</label>
                        <input wire:model="adresse" type="text" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Horaires d'ouverture</label>
                        <input wire:model="horaire" type="text" class="w-full mt-1 px-4 py-2 rounded-lg border border-slate-200 outline-none focus:border-emerald-500" placeholder="Ex: Lun - Ven : 08h00 - 18h00">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <label class="block text-sm font-bold text-slate-700 mb-2">Logo du site</label>
                <div class="flex flex-col items-center gap-4">
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" class="h-20 w-auto rounded-lg">
                    @elseif($settings->logo)
                        <img src="{{ asset('storage/'.$settings->logo) }}" class="h-20 w-auto rounded-lg">
                    @endif
                    <input type="file" wire:model="logo" class="text-xs text-slate-500">
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-bold text-slate-700">Numéros de téléphone</label>
                    <button type="button" wire:click="addPhone" class="text-emerald-600 text-xs font-bold">+ Ajouter</button>
                </div>
                @foreach($phones as $index => $phone)
                    <div class="flex gap-2 mb-2">
                        <input wire:model="phones.{{ $index }}" type="text" class="flex-1 px-3 py-1.5 rounded-lg border border-slate-200 text-sm outline-none" placeholder="+237...">
                        <button type="button" wire:click="removePhone({{ $index }})" class="text-red-400 hover:text-red-600">&times;</button>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-bold text-slate-700">Réseaux Sociaux</label>
                    <button type="button" wire:click="addSocial" class="text-emerald-600 text-xs font-bold">+ Ajouter</button>
                </div>
                @foreach($socials as $index => $social)
                    <div class="space-y-2 p-2 bg-slate-50 rounded-lg mb-2 relative">
                        <select wire:model="socials.{{ $index }}.platform" class="w-full text-xs border-none bg-transparent font-bold text-slate-600 outline-none">
                            <option value="">Choisir un réseau</option>
                            @foreach(App\Models\Setting::availableSocials() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <input wire:model="socials.{{ $index }}.url" type="text" class="w-full px-2 py-1 text-xs rounded border border-slate-200 outline-none" placeholder="Lien (URL)">
                        <button type="button" wire:click="removeSocial({{ $index }})" class="absolute top-1 right-1 text-red-400 text-lg">&times;</button>
                    </div>
                @endforeach
            </div>
        </div>

        @can('create', Setting::class)
        <div class="md:col-span-3 flex justify-end">
            <button type="submit" class="bg-slate-900 text-white px-10 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all shadow-lg active:scale-95">
                Sauvegarder les modifications
            </button>
        </div>
        @endcan
    </form>
</div>

<script>
    document.addEventListener('livewire:init', () => {
       Livewire.on('settings-updated', (event) => {
           const Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
               timer: 3000,
               timerProgressBar: true,
               didOpen: (toast) => {
                   toast.addEventListener('mouseenter', Swal.stopTimer)
                   toast.addEventListener('mouseleave', Swal.resumeTimer)
               }
           });

           Toast.fire({
               icon: 'success',
               title: 'Paramètres enregistrés !',
               background: '#f0fdf4', // emerald-50
               color: '#065f46',      // emerald-800
           });
       });
    });
</script>

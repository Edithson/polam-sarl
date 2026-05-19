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
    public $socials = [];

    public function mount()
    {
        $this->settings = Setting::first() ?? new Setting();

        $this->name = $this->settings->name ?? 'POLAM SARL';
        $this->slogan = $this->settings->slogan;
        $this->email = $this->settings->email;
        $this->adresse = $this->settings->adresse;
        $this->bp = $this->settings->bp;
        $this->horaire = $this->settings->horaire;

        $this->phones = $this->settings->phones ?? [''];

        $savedSocials = $this->settings->socials ?? [];
        foreach($savedSocials as $platform => $url) {
            $this->socials[] = ['platform' => $platform, 'url' => $url];
        }
        if (empty($this->socials)) $this->socials[] = ['platform' => '', 'url' => ''];
    }

    public function addPhone() { $this->phones[] = ''; }
    public function removePhone($index) { unset($this->phones[$index]); $this->phones = array_values($this->phones); }

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
            'phones' => array_filter($this->phones),
        ];

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
        Setting::clearCache();

        session()->flash('status', 'Paramètres mis à jour avec succès !');
        $this->dispatch('settings-updated');
    }
}; ?>

<div class="max-w-5xl mx-auto space-y-4 font-['DM_Sans',sans-serif]">

    <div class="flex items-center gap-2 mb-6">
        <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
        <h2 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Configuration Système</h2>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        <div class="xl:col-span-2 space-y-4">
            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <h3 class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-gray-400 border-b border-[#E8EAF0] pb-2 mb-4">Identité de l'entreprise</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Nom officiel</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Slogan / Sous-titre</label>
                        <input wire:model="slogan" type="text" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <h3 class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-gray-400 border-b border-[#E8EAF0] pb-2 mb-4">Informations de Contact</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Email principal</label>
                        <input wire:model="email" type="email" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Boîte Postale</label>
                        <input wire:model="bp" type="text" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Adresse Physique</label>
                        <input wire:model="adresse" type="text" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-wider uppercase text-gray-500 mb-1">Horaires d'ouverture</label>
                        <input wire:model="horaire" type="text" class="w-full px-4 py-2 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all" placeholder="Ex: Lun - Ven : 08h00 - 18h00">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <h3 class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-gray-400 border-b border-[#E8EAF0] pb-2 mb-4">Logo</h3>
                <div class="flex flex-col items-center gap-4">
                    <div class="p-2 border border-[#E8EAF0] bg-[#F5F6FA] rounded-sm w-full flex justify-center">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" class="h-16 w-auto object-contain">
                        @elseif($settings->logo)
                            <img src="{{ asset('storage/'.$settings->logo) }}" class="h-16 w-auto object-contain">
                        @else
                            <span class="text-xs text-gray-400 italic py-4">Aucun logo</span>
                        @endif
                    </div>
                    <input type="file" wire:model="logo" class="text-[10px] text-gray-500 file:mr-2 file:py-1 file:px-2 file:border-0 file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 file:font-['Syne',sans-serif] file:font-bold file:uppercase file:tracking-wider file:rounded-sm file:cursor-pointer w-full">
                </div>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <div class="flex justify-between items-center border-b border-[#E8EAF0] pb-2 mb-4">
                    <h3 class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-gray-400">Téléphones</h3>
                    <button type="button" wire:click="addPhone" class="text-orange-500 hover:text-orange-600 font-['Syne',sans-serif] text-[9px] font-bold uppercase tracking-wider">+ Ajouter</button>
                </div>
                @foreach($phones as $index => $phone)
                    <div class="flex gap-2 mb-2">
                        <input wire:model="phones.{{ $index }}" type="text" class="flex-1 px-3 py-1.5 bg-[#F5F6FA] text-xs rounded-sm border border-[#E8EAF0] focus:ring-1 focus:border-orange-500 focus:ring-orange-500 outline-none" placeholder="+237...">
                        <button type="button" wire:click="removePhone({{ $index }})" class="px-2 text-gray-400 hover:text-red-500 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm">&times;</button>
                    </div>
                @endforeach
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <div class="flex justify-between items-center border-b border-[#E8EAF0] pb-2 mb-4">
                    <h3 class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-gray-400">Réseaux Sociaux</h3>
                    <button type="button" wire:click="addSocial" class="text-orange-500 hover:text-orange-600 font-['Syne',sans-serif] text-[9px] font-bold uppercase tracking-wider">+ Ajouter</button>
                </div>
                @foreach($socials as $index => $social)
                    <div class="space-y-1.5 p-3 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm mb-2 relative group">
                        <select wire:model="socials.{{ $index }}.platform" class="w-full text-xs border-none bg-transparent font-['Syne',sans-serif] font-bold text-gray-700 outline-none p-0 focus:ring-0">
                            <option value="">Choisir un réseau</option>
                            @foreach(App\Models\Setting::availableSocials() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <input wire:model="socials.{{ $index }}.url" type="text" class="w-full px-2 py-1.5 text-xs rounded-sm border border-[#E8EAF0] outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500" placeholder="URL complète">
                        <button type="button" wire:click="removeSocial({{ $index }})" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 bg-white border border-[#E8EAF0] rounded-sm px-1.5 opacity-0 group-hover:opacity-100 transition-opacity">&times;</button>
                    </div>
                @endforeach
            </div>
        </div>

        @can('create', Setting::class)
        <div class="xl:col-span-3 flex justify-end mt-2 pt-4 border-t border-[#E8EAF0]">
            <button type="submit" class="bg-orange-500 text-white px-8 py-2.5 rounded-sm font-['Syne',sans-serif] text-xs font-bold uppercase tracking-wider hover:bg-[#EA580C] shadow-sm active:scale-[0.98] transition-all flex items-center gap-2">
                Sauvegarder
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
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
               title: 'Mise à jour réussie',
               background: '#FFF7ED',
               color: '#EA580C',
               customClass: {
                   title: 'font-["DM_Sans",sans-serif] text-sm font-bold',
                   popup: 'border border-orange-200 shadow-sm rounded-sm'
               }
           });
       });
    });
</script>

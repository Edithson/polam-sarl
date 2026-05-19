<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Contact;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $serviceFilter = '';
    public $selectedContact = null;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingServiceFilter() { $this->resetPage(); }

    public function showContact($id)
    {
        $this->selectedContact = Contact::findOrFail($id);

        if (!$this->selectedContact->is_read) {
            $this->selectedContact->update(['is_read' => 1]);
        }

        $this->dispatch('open-modal', 'contact-details');
    }

    public function deleteContact($id)
    {
        try {
            Contact::findOrFail($id)->delete();
            $this->dispatch('contact-sent', [
                'type' => 'success',
                'message' => 'La demande a été supprimée.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('contact-sent', [
                'type' => 'error',
                'message' => 'Impossible de supprimer.'
            ]);
        }
    }

    public function exportExcel(): StreamedResponse
    {
        $contacts = Contact::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->serviceFilter, fn($q) => $q->where('service', $this->serviceFilter))
            ->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=contacts_polam.csv',
        ];

        return response()->stream(function() use ($contacts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Nom', 'Entreprise', 'Email', 'Service', 'Message']);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->created_at->format('d/m/Y'),
                    $contact->name,
                    $contact->company,
                    $contact->email,
                    $contact->service,
                    $contact->message
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    public function with()
    {
        return [
            'contacts' => Contact::query()
                ->when($this->search, function($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%')
                          ->orWhere('company', 'like', '%' . $this->search . '%');
                })
                ->when($this->serviceFilter, function($query) {
                    $query->where('service', $this->serviceFilter);
                })
                ->latest()
                ->paginate(10),
            'unreadCount' => Contact::where('is_read', 0)->count(),
        ];
    }
}; ?>

<div x-data="{ openDetail: false }" @open-modal.window="if($event.detail == 'contact-details') openDetail = true" class="font-['DM_Sans',sans-serif]">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-5 h-0.5 bg-orange-500 inline-block"></span>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-orange-500">Messagerie</span>
                @if($unreadCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-[9px] font-bold font-['Syne',sans-serif] uppercase tracking-wider text-white bg-orange-500 rounded-sm">
                        {{ $unreadCount }} nouvelle{{ $unreadCount > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
            <h1 class="font-['Bebas_Neue',sans-serif] text-3xl tracking-wider text-gray-900 leading-none">Demandes Clients</h1>
        </div>

        <button wire:click="exportExcel" class="flex items-center gap-2 bg-white border border-[#E8EAF0] text-gray-600 font-['Syne',sans-serif] font-bold text-xs px-4 py-2 rounded-sm hover:border-orange-500 hover:text-orange-500 transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Exporter (CSV)
        </button>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-4">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher (nom, email...)"
                   class="w-full pl-9 pr-4 py-2 bg-white rounded-sm border border-[#E8EAF0] text-xs text-gray-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
        </div>

        <select wire:model.live="serviceFilter" class="px-4 py-2 bg-white rounded-sm border border-[#E8EAF0] text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-gray-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 cursor-pointer min-w-[200px]">
            <option value="">Tous les services</option>
            <option value="Énergie solaire">Énergie solaire</option>
            <option value="Vidéosurveillance">Vidéosurveillance</option>
            <option value="Installation électrique">Installation électrique</option>
            <option value="Maintenance biomédicale">Maintenance biomédicale</option>
            <option value="Réseaux & Télécoms">Réseaux & Télécoms</option>
            <option value="Maintenance IT">Maintenance IT</option>
            <option value="Autre">Autre</option>
        </select>
    </div>

    <div class="bg-white rounded-sm border border-[#E8EAF0] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-[#F5F6FA] border-b border-[#E8EAF0]">
                    <tr>
                        <th class="px-5 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Contact</th>
                        <th class="px-3 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Service</th>
                        <th class="px-3 py-3 font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Aperçu</th>
                        <th class="px-5 py-3 text-right font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8EAF0]/60">
                    @foreach($contacts as $contact)
                        <tr class="hover:bg-[#FFF7ED] transition-colors {{ $contact->is_read ? 'opacity-70' : '' }}">
                            <td class="px-5 py-3 relative">
                                @if(!$contact->is_read)
                                    <span class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></span>
                                @endif
                                <div class="flex flex-col pl-2">
                                    <span class="font-['Syne',sans-serif] font-bold text-[11px] uppercase tracking-wide text-gray-800">{{ $contact->name }}</span>
                                    <span class="text-[10px] text-gray-500 font-['DM_Sans',sans-serif]">{{ $contact->email }}</span>
                                    @if($contact->company)
                                        <span class="text-[9px] font-bold font-['Syne',sans-serif] text-orange-500 mt-0.5 tracking-wider uppercase">{{ $contact->company }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <span class="font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.08em] uppercase px-2 py-0.5 rounded-sm {{ $contact->is_read ? 'bg-[#F5F6FA] text-gray-500 border border-[#E8EAF0]' : 'bg-[#DBEAFE] text-[#1E40AF]' }}">
                                    {{ $contact->service }}
                                </span>
                            </td>
                            <td class="px-3 py-3">
                                <p class="text-gray-600 line-clamp-1 italic max-w-[250px]">"{{ $contact->message }}"</p>
                                <span class="text-[9px] text-gray-400 font-['Syne',sans-serif] uppercase tracking-wider mt-1 block">{{ $contact->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end gap-1.5">
                                    <button wire:click="showContact({{ $contact->id }})" class="p-1.5 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-sm transition-all" title="Voir le message">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.8"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="1.8"/></svg>
                                    </button>
                                    <button @click="confirmDeletion({{ $contact->id }})" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-sm transition-all" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 bg-[#F5F6FA] border-t border-[#E8EAF0]">
            {{ $contacts->links() }}
        </div>
    </div>

    <div x-show="openDetail"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>

        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="openDetail = false"></div>

        <div class="relative bg-white w-full max-w-lg rounded-sm shadow-xl overflow-hidden border-t-4 border-orange-500">
            @if($selectedContact)
                <div class="border-b border-[#E8EAF0] px-6 py-4 flex justify-between items-center bg-[#F5F6FA]">
                    <div>
                        <h3 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Détails Demande</h3>
                        <p class="text-gray-500 text-[10px] mt-0.5">{{ $selectedContact->created_at->format('d/m/Y \à H:i') }}</p>
                    </div>
                    <button @click="openDetail = false" class="text-gray-400 hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[9px] font-bold font-['Syne',sans-serif] tracking-[0.15em] uppercase text-gray-400 mb-1">Expéditeur</label>
                            <p class="text-xs font-bold text-gray-900">{{ $selectedContact->name }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $selectedContact->email }}</p>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold font-['Syne',sans-serif] tracking-[0.15em] uppercase text-gray-400 mb-1">Entité / Entreprise</label>
                            <p class="text-xs font-bold text-gray-900">{{ $selectedContact->company ?? 'Non renseigné' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold font-['Syne',sans-serif] tracking-[0.15em] uppercase text-gray-400 mb-1">Service Concerné</label>
                        <span class="inline-block px-2 py-1 bg-orange-50 text-orange-600 font-['Syne',sans-serif] text-[10px] font-bold tracking-wider uppercase rounded-sm border border-orange-100">
                            {{ $selectedContact->service }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-[9px] font-bold font-['Syne',sans-serif] tracking-[0.15em] uppercase text-gray-400 mb-1">Message</label>
                        <div class="p-4 bg-[#F5F6FA] rounded-sm text-xs text-gray-700 leading-relaxed border border-[#E8EAF0]">
                            {!! nl2br(e($selectedContact->message)) !!}
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <a href="mailto:{{ $selectedContact->email }}" class="flex items-center gap-2 bg-orange-500 text-white px-5 py-2 rounded-sm font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider hover:bg-[#EA580C] transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Répondre
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function confirmDeletion(id) {
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Cette demande sera effacée.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F97316',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui',
                cancelButtonText: 'Annuler',
                borderRadius: '0.25rem',
                customClass: {
                    popup: 'font-["DM_Sans",sans-serif]',
                    confirmButton: 'rounded-sm font-["Syne",sans-serif] font-bold text-xs uppercase tracking-wider px-4 py-2',
                    cancelButton: 'rounded-sm font-["Syne",sans-serif] font-bold text-xs uppercase tracking-wider px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteContact(id);
                }
            })
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('contact-sent', (event) => {
                const data = event[0];
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: data.type,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: data.type === 'success' ? '#FFF7ED' : '#FEF2F2',
                    color: data.type === 'success' ? '#EA580C' : '#991B1B'
                });
            });
        });
    </script>
</div>

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

        // Mise à jour de l'état de lecture
        if (!$this->selectedContact->is_read) {
            $this->selectedContact->update(['is_read' => 1]);
        }

        $this->dispatch('open-modal', 'contact-details');
    }

    public function deleteContact($id)
    {
        try {
            Contact::findOrFail($id)->delete();

            // Un seul dispatch suffit pour déclencher le Toast JS
            $this->dispatch('contact-sent', [
                'type' => 'success',
                'message' => 'La demande a été définitivement supprimée.'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('contact-sent', [
                'type' => 'error',
                'message' => 'Impossible de supprimer ce contact.'
            ]);
        }
    }

    // Fonction d'exportation CSV (Excel compatible)
    public function exportExcel(): StreamedResponse
    {
        $contacts = Contact::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->serviceFilter, fn($q) => $q->where('service', $this->serviceFilter))
            ->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=contacts_cinv_corsa.csv',
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

<div x-data="{ openDetail: false }" @open-modal.window="if($event.detail == 'contact-details') openDetail = true">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-bold text-slate-900">Demandes de contact</h2>
                @if($unreadCount > 0)
                    <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold leading-none text-white bg-emerald-500 rounded-full shadow-lg shadow-emerald-200">
                        {{ $unreadCount }} nouvelle{{ $unreadCount > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
            <p class="text-slate-500 mt-1">Gérez les opportunités commerciales de CINV-CORSA</p>
        </div>

        <button wire:click="exportExcel" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all shadow-sm hover:shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Exporter en Excel
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="relative md:col-span-2">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2"/></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher un nom, email ou entreprise..."
                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
        </div>

        <select wire:model.live="serviceFilter" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white focus:border-emerald-500 outline-none transition-all">
            <option value="">Tous les services</option>
            <option value="Archivage Manuel">Archivage Manuel</option>
            <option value="Archivage Électronique (SAE)">Archivage Électronique (SAE)</option>
            <option value="GEIDE / Dématérialisation">GEIDE / Dématérialisation</option>
            <option value="Audit & Conseil">Audit & Conseil</option>
        </select>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-xl shadow-slate-200/50 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-100">
                    <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500">Contact</th>
                    <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500">Service</th>
                    <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500">Message</th>
                    <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($contacts as $contact)
                    <tr class="hover:bg-slate-50/80 transition-colors {{ $contact->is_read ? 'opacity-60' : '' }}">
                        <td class="p-5 relative">
                            @if(!$contact->is_read)
                                <span class="absolute left-2 top-1/2 -translate-y-1/2 w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                            @endif

                            <div class="flex flex-col ml-2">
                                <span class="font-bold text-slate-900">{{ $contact->name }}</span>
                                <span class="text-sm text-slate-500">{{ $contact->email }}</span>
                                @if($contact->company)
                                    <span class="text-[10px] font-medium text-emerald-600 mt-0.5">{{ Str::upper($contact->company) }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $contact->is_read ? 'bg-slate-100 text-slate-500' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }}">
                                {{ $contact->service }}
                            </span>
                        </td>
                        <td class="p-5">
                            <p class="text-sm text-slate-600 line-clamp-1 italic">"{{ Str::limit($contact->message, 45) }}"</p>
                            <span class="text-[10px] text-slate-400">{{ $contact->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button wire:click="showContact({{ $contact->id }})" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                                </button>
                                <button @click="confirmDeletion({{ $contact->id }})" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-5 bg-slate-50/50 border-t border-gray-100">
            {{ $contacts->links() }}
        </div>
    </div>

    <div x-show="openDetail"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openDetail = false"></div>

        <div class="relative bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden">
            @if($selectedContact)
                <div class="bg-slate-900 p-6 flex justify-between items-center text-white">
                    <div>
                        <h3 class="text-xl font-bold">Détails de l'intérêt</h3>
                        <p class="text-slate-400 text-xs">{{ $selectedContact->created_at->format('d F Y \à H:i') }}</p>
                    </div>
                    <button @click="openDetail = false" class="p-2 hover:bg-white/10 rounded-full transition-all">&times;</button>
                </div>

                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] uppercase font-bold text-slate-400">Expéditeur</label>
                            <p class="font-bold text-slate-800">{{ $selectedContact->name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-slate-400">Entreprise</label>
                            <p class="font-bold text-slate-800">{{ $selectedContact->company ?? 'Particulier' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] uppercase font-bold text-slate-400">Service concerné</label>
                        <p class="text-emerald-600 font-semibold">{{ $selectedContact->service }}</p>
                    </div>

                    <div>
                        <label class="text-[10px] uppercase font-bold text-slate-400">Contenu du message</label>
                        <div class="mt-2 p-5 bg-slate-50 rounded-2xl text-slate-600 leading-relaxed border border-slate-100">
                            {{ $selectedContact->message }}
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <a href="mailto:{{ $selectedContact->email }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-emerald-600 transition-all flex items-center">
                            Répondre par email
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/></svg>
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
                text: "Voulez-vous vraiment supprimer ce message ? Cette action est définitive.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669', // Emerald 600
                cancelButtonColor: '#f43f5e', // Rose 500
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                borderRadius: '1rem'
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
                    timerProgressBar: true
                });
            });
        });
    </script>
</div>

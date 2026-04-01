<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Laws;

new class extends Component {
    use WithPagination;

    public string $search = '';

    // Réinitialise la pagination quand on recherche
    public function updatingSearch() { $this->resetPage(); }

    public function with(): array
    {
        $query = Laws::query()->latest();

        // Recherche par titre ou slug
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'laws' => $query->paginate(10),
        ];
    }
}; ?>

<div>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="Rechercher un texte de loi..."
                   class="w-auto pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all">
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Lois</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($laws as $law)
                    <tr class="hover:bg-slate-50 transition-colors" wire:key="{{ $law->id }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div>
                                    <div class="font-bold text-slate-700 line-clamp-1">{{ $law->title }}</div>
                                    {{-- Limiter l'affichage de la description à quelques caractères --}}
                                    <div class="text-xs text-slate-400">{{ Str::limit(strip_tags($law->description), 30) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $law->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                @can('update', $law)
                                <a href="{{ route('laws.edit', $law) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @endcan
                                @can('delete', $law)
                                <form id="delete-form-{{ $law->id }}" action="{{ route('laws.destroy', $law) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete('{{ $law->id }}', '{{ addslashes($law->title) }}')"
                                            class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            Aucune loi trouvée. <a href="{{ route('laws.create') }}" class="text-emerald-600 font-bold hover:underline">Ajoutez votre 1 ere loi !</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($laws->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $laws->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(id, title) {

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: `La loi "${title}" sera définitivement supprimé !`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981', // emerald-500
        cancelButtonColor: '#64748b',  // slate-500
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler',
        background: '#ffffff',
        borderRadius: '1.25rem',
        customClass: {
            popup: 'rounded-3xl',
            confirmButton: 'rounded-xl font-bold px-6 py-3',
            cancelButton: 'rounded-xl font-bold px-6 py-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Si l'utilisateur confirme, on soumet le formulaire
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>

<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Article;

new class extends Component {
    use WithPagination;

    public string $search = '';
    public string $filter = 'all';

    public function updatingSearch() { $this->resetPage(); }

    public function with(): array
    {
        $query = Article::query()->with('user')->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter !== 'all') {
            $query->where('public', $this->filter === 'public');
        }

        return [
            'articles' => $query->paginate(10),
        ];
    }
}; ?>

<div class="font-['DM_Sans',sans-serif]">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-5 h-0.5 bg-orange-500 inline-block"></span>
                <span class="font-['Syne',sans-serif] text-[10px] font-bold tracking-[0.18em] uppercase text-orange-500">Articles</span>
            </div>
            <h1 class="font-['Bebas_Neue',sans-serif] text-3xl tracking-wider text-gray-900 leading-none">Gérez le contenu éditorial de POLAM SARL</h1>
        </div>
        @can('create', App\Models\Article::class)
            <a href="{{ route('articles.create') }}"
            class="flex items-center justify-center gap-2 bg-orange-500 text-white px-5 py-2 rounded-sm font-['Syne',sans-serif] text-[10px] font-bold uppercase tracking-wider hover:bg-[#EA580C] transition-all shadow-sm">
                Ajouter un article
            </a>
        @else
            <button disabled
                    title="Vous n'avez pas les permissions nécessaires"
                    class="bg-slate-200 text-slate-400 px-6 py-3 rounded-xl font-bold cursor-not-allowed opacity-70">
                Ajouter un article (Verrouillé)
            </button>
        @endcan
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text"
                   placeholder="Rechercher un article..."
                   class="w-full pl-9 pr-4 py-2 bg-white rounded-sm border border-[#E8EAF0] text-xs text-gray-600 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all placeholder-gray-400">
        </div>

        <select wire:model.live="filter" class="px-4 py-2 bg-white rounded-sm border border-[#E8EAF0] text-xs font-bold font-['Syne',sans-serif] uppercase tracking-wider text-gray-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 cursor-pointer">
            <option value="all">Tous les états</option>
            <option value="public">Publics uniquement</option>
            <option value="draft">Brouillons</option>
        </select>
    </div>

    <div class="bg-white rounded-sm shadow-xs border border-[#E8EAF0] overflow-hidden">
        <div class="flex items-center gap-2 px-5 py-4 border-b border-[#E8EAF0]">
            <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
            <h2 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 tracking-wide">Liste des articles</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-[#F5F6FA] border-b border-[#E8EAF0]">
                    <tr>
                        <th class="px-5 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Article</th>
                        <th class="px-3 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Auteur</th>
                        <th class="px-3 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">État</th>
                        <th class="px-3 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Date</th>
                        <th class="px-5 py-3 text-right font-['Syne',sans-serif] font-bold text-[9px] tracking-[0.15em] uppercase text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8EAF0]/60">
                    @forelse ($articles as $article)
                        <tr class="hover:bg-[#FFF7ED] transition-colors" wire:key="{{ $article->id }}">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-sm bg-[#F5F6FA] overflow-hidden flex-shrink-0 border border-[#E8EAF0]">
                                        @if($article->picture)
                                            <img src="{{ asset('storage/' . $article->picture) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-['Syne',sans-serif] font-bold text-gray-800 line-clamp-1 text-[11px] uppercase tracking-wide">{{ $article->title }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <span class="text-gray-600 font-['DM_Sans',sans-serif]">{{ $article->user->name ?? 'Admin' }}</span>
                            </td>
                            <td class="px-3 py-3">
                                @if($article->public)
                                    <span class="inline-flex items-center font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.08em] uppercase px-2 py-0.5 rounded-sm bg-[#DCFCE7] text-[#166534]">
                                        Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.08em] uppercase px-2 py-0.5 rounded-sm bg-[#FEF3C7] text-[#92400E]">
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3 text-gray-400 font-['DM_Sans',sans-serif] text-[11px]">
                                {{ $article->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex justify-end gap-1.5">
                                    @can('update', $article)
                                    <a href="{{ route('articles.edit', $article) }}" class="p-1.5 text-gray-400 hover:text-orange-500 hover:bg-orange-50 rounded-sm transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </a>
                                    @endcan
                                    @can('delete', $article)
                                    <form id="delete-form-{{ $article->id }}" action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete('{{ $article->id }}', '{{ addslashes($article->title) }}')"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-sm transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-500 font-['DM_Sans',sans-serif] text-xs">
                                Aucun article trouvé. <a href="{{ route('articles.create') }}" class="text-orange-500 font-bold hover:underline">Créez votre premier article !</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($articles->hasPages())
            <div class="px-5 py-3 bg-[#F5F6FA] border-t border-[#E8EAF0]">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: `L'article "${title}" sera supprimé.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F97316',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        background: '#ffffff',
        borderRadius: '0.25rem', // rounded-sm
        customClass: {
            popup: 'font-["DM_Sans",sans-serif]',
            confirmButton: 'rounded-sm font-["Syne",sans-serif] font-bold text-xs uppercase tracking-wider px-4 py-2',
            cancelButton: 'rounded-sm font-["Syne",sans-serif] font-bold text-xs uppercase tracking-wider px-4 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>

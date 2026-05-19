@extends('dashboard.index')

@section('content')

    <div class="p-4 lg:p-6 font-['DM_Sans',sans-serif]">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0] relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-orange-500"></div>
                <div class="flex items-start justify-between mb-3">
                    <p class="font-['Syne',sans-serif] text-[10px] font-bold text-gray-400 uppercase tracking-wider">Articles publiés</p>
                    <div class="bg-[#FFF7ED] p-1.5 rounded-sm">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 2v6h6"></path></svg>
                    </div>
                </div>
                <h3 class="font-['Bebas_Neue',sans-serif] text-4xl tracking-wider text-gray-900 leading-none mb-1">{{ $stats_art['public'] }}</h3>
                <span class="text-[10px] text-green-600 font-bold uppercase tracking-wider font-['Syne',sans-serif]">+{{ $stats_art['this_month'] }} ce mois</span>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0] relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-blue-500"></div>
                <div class="flex items-start justify-between mb-3">
                    <p class="font-['Syne',sans-serif] text-[10px] font-bold text-gray-400 uppercase tracking-wider">Demandes de devis</p>
                    <div class="bg-blue-50 p-1.5 rounded-sm">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <h3 class="font-['Bebas_Neue',sans-serif] text-4xl tracking-wider text-gray-900 leading-none mb-1">{{ $stats_contact['total'] }}</h3>
                <span class="text-[10px] text-blue-600 font-bold uppercase tracking-wider font-['Syne',sans-serif]">+{{ $stats_contact['unread'] }} non lus</span>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0] relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-amber-400"></div>
                <div class="flex items-start justify-between mb-3">
                    <p class="font-['Syne',sans-serif] text-[10px] font-bold text-gray-400 uppercase tracking-wider">Articles en attente</p>
                    <div class="bg-amber-50 p-1.5 rounded-sm">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="1.8"/><path d="M12 6v6l4 2" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <h3 class="font-['Bebas_Neue',sans-serif] text-4xl tracking-wider text-gray-900 leading-none mb-1">{{ $stats_art['draft'] }}</h3>
                <span class="text-[10px] text-amber-600 font-bold uppercase tracking-wider font-['Syne',sans-serif]">Brouillons</span>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0] relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-green-500"></div>
                <div class="flex items-start justify-between mb-3">
                    <p class="font-['Syne',sans-serif] text-[10px] font-bold text-gray-400 uppercase tracking-wider">Santé du Site</p>
                    <div class="bg-green-50 p-1.5 rounded-sm">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <h3 class="font-['Bebas_Neue',sans-serif] text-4xl tracking-wider text-green-500 leading-none mb-1">98%</h3>
                <span class="text-[10px] text-gray-400 uppercase tracking-wider font-['Syne',sans-serif]">Théorique...</span>
            </div>
        </div>

        <div class="bg-white rounded-sm shadow-xs border border-[#E8EAF0] overflow-hidden mb-6">
            <div class="p-5 border-b border-[#E8EAF0] flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                    <h3 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Derniers Articles du Blog</h3>
                </div>
                <a href="{{ route('articles.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-sm font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider hover:bg-[#EA580C] transition-colors shadow-sm">
                    + Nouvel Article
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-[#F5F6FA] border-b border-[#E8EAF0]">
                        <tr>
                            <th class="px-5 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] uppercase tracking-[0.15em] text-gray-400">Titre de l'article</th>
                            <th class="px-5 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] uppercase tracking-[0.15em] text-gray-400">Date</th>
                            <th class="px-5 py-3 text-left font-['Syne',sans-serif] font-bold text-[9px] uppercase tracking-[0.15em] text-gray-400">Statut</th>
                            <th class="px-5 py-3 text-right font-['Syne',sans-serif] font-bold text-[9px] uppercase tracking-[0.15em] text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8EAF0]/60">
                        @forelse ( $stats_art['latest'] as $article)
                        <tr class="hover:bg-[#FFF7ED] transition-colors">
                            <td class="px-5 py-4 font-['Syne',sans-serif] font-bold text-[11px] uppercase tracking-wide text-gray-800">{{ $article->title }}</td>
                            <td class="px-5 py-4 text-gray-500 font-['DM_Sans',sans-serif]">{{ $article->created_at->format('d M Y') }}</td>
                            <td class="px-5 py-4">
                                @if($article->public)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-sm font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.08em] uppercase bg-[#DCFCE7] text-[#166534]">
                                        Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-sm font-['Syne',sans-serif] text-[9px] font-bold tracking-[0.08em] uppercase bg-[#FEF3C7] text-[#92400E]">
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
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
                                <td colspan="4" class="px-5 py-12 text-center text-gray-500 font-['DM_Sans',sans-serif] text-xs">
                                    Aucun article trouvé. <a href="{{ route('articles.create') }}" class="text-orange-500 font-bold hover:underline">Créez votre premier article !</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <div class="flex items-center gap-2 mb-4 border-b border-[#E8EAF0] pb-3">
                    <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                    <h3 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Paramètres Rapides</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-1">Nom du site</label>
                        <input type="text" value="POLAM SARL" class="w-full px-4 py-2.5 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold font-['Syne',sans-serif] tracking-[0.18em] uppercase text-gray-500 mb-1">Email de contact</label>
                        <input type="email" value="contact@polam.cm" class="w-full px-4 py-2.5 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm text-xs text-gray-900 focus:ring-1 focus:ring-orange-500 outline-none transition-all">
                    </div>
                    <button class="w-full bg-gray-900 text-white font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider py-3 rounded-sm hover:bg-orange-500 transition-all active:scale-[0.98]">
                        Sauvegarder
                    </button>
                </div>
            </div>

            <div class="bg-white p-5 rounded-sm shadow-xs border border-[#E8EAF0]">
                <div class="flex items-center justify-between mb-4 border-b border-[#E8EAF0] pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-orange-500 rounded-sm inline-block"></span>
                        <h3 class="font-['Syne',sans-serif] font-bold text-sm text-gray-900 uppercase tracking-wider">Derniers Contacts</h3>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($stats_contact['latest'] as $contact)
                        <div class="flex items-center justify-between p-3 bg-[#F5F6FA] border border-[#E8EAF0] rounded-sm">
                            <span class="text-xs font-bold text-gray-800 font-['DM_Sans',sans-serif] truncate max-w-[200px]">{{ $contact->email }}</span>
                            <span class="text-[10px] text-gray-400 font-['Syne',sans-serif] uppercase tracking-wider whitespace-nowrap">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-[11px] text-gray-500 p-3 bg-[#F5F6FA] rounded-sm text-center">Aucune demande récente.</p>
                    @endforelse
                    <a href="{{ route('admin.contact.index') }}" class="block text-center w-full bg-white border border-[#E8EAF0] text-gray-600 font-['Syne',sans-serif] font-bold text-[10px] uppercase tracking-wider py-3 rounded-sm hover:border-orange-500 hover:text-orange-500 transition-all mt-2">
                        Voir la liste complète
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `L'article "${title}" sera définitivement supprimé !`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F97316',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                background: '#ffffff',
                borderRadius: '0.25rem',
                customClass: {
                    popup: 'font-["DM_Sans",sans-serif] rounded-sm border border-[#E8EAF0] shadow-sm',
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

@endsection

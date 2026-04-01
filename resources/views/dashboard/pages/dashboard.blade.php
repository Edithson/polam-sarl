@extends('dashboard.index')

@section('content')

    <div class="p-4 lg:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Articles publiés</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats_art['public'] }}</h3>
                <span class="text-xs text-emerald-600 font-bold">+{{ $stats_art['this_month'] }} ce mois</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Demande de contact</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats_contact['total'] }}</h3>
                <span class="text-xs text-blue-600 font-bold">+{{ $stats_contact['unread'] }} non lus</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Articles au brouillon</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats_art['draft'] }}</h3>
                <span class="text-xs text-orange-600 font-bold">En attentes de validation</span>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Santé du Site</p>
                <h3 class="text-3xl font-black text-emerald-500 mt-1">98%</h3>
                <span class="text-xs text-gray-400">Théorique...</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div
                class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-xl font-bold text-slate-800">Derniers Articles du Blog</h3>
                <a href="{{ route('articles.create') }}"
                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-emerald-700 transition-colors">
                    + Nouvel Article
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-slate-500 text-xs uppercase font-bold">
                        <tr>
                            <th class="px-6 py-4">Titre de l'article</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ( $stats_art['latest'] as $article)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700">{{ $article->title }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $article->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($article->public)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        Brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    @can('update', $article)
                                    <a href="{{ route('articles.edit', $article) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @endcan
                                    @can('delete', $article)
                                    <form id="delete-form-{{ $article->id }}" action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete('{{ $article->id }}', '{{ addslashes($article->title) }}')"
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
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    Aucun article trouvé. <a href="{{ route('articles.create') }}" class="text-emerald-600 font-bold hover:underline">Créez votre premier article !</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 grid lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Paramètres Généraux</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Nom du site</label>
                        <input type="text" value="CINV-COR S.A"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Email de contact</label>
                        <input type="email" value="contact@cinvcorsa.com"
                            class="w-full mt-1 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <button class="w-full bg-slate-900 text-white py-2 rounded-lg font-bold text-sm">Sauvegarder
                        les modifications</button>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Dernières demandes de contact</h3>
                <div class="space-y-4">
                    @forelse($stats_contact['latest'] as $contact)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium">{{ $contact->email }}</span>
                            <span class="text-xs text-gray-400">Il y a {{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Aucune demande de contact récente.</p>
                    @endforelse
                    <a href="{{ route('admin.contact.index') }}"
                        class="w-full border-2 border-gray-100 text-slate-600 py-2 rounded-lg font-bold text-sm hover:bg-gray-50">Voir
                        toute la liste</a>
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

@endsection

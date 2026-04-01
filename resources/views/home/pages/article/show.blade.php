@extends('home.index')

@section('content')
<article class="bg-white min-h-screen">
    {{-- 1. En-tête de l'article avec image de fond --}}
    <div class="relative w-full h-[50vh] min-h-[400px] overflow-hidden">
        @if($article->picture)
            <img src="{{ asset('storage/' . $article->picture) }}"
                 class="w-full h-full object-cover"
                 alt="{{ $article->title }}">
        @else
            <div class="w-full h-full bg-emerald-900"></div>
        @endif

        {{-- Overlay pour la lisibilité --}}
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12">
            <div class="container mx-auto">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                        Article
                    </span>
                    <span class="text-slate-300 text-sm">
                        Publié le {{ $article->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight max-w-4xl">
                    {{ $article->title }}
                </h1>
            </div>
        </div>
    </div>

    {{-- 2. Corps de l'article --}}
    <div class="container mx-auto px-12 py-12 p-12">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- Contenu principal --}}
            <div class="lg:w-2/3">
                {{-- Informations auteur --}}
                <div class="flex items-center gap-4 mb-8 pb-8 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-emerald-600">
                        {{ substr($article->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-slate-900 font-bold leading-none">{{ $article->user->name ?? 'Rédaction CINV-CORSA' }}</p>
                        <p class="text-slate-500 text-sm mt-1">Expert Solutions Documentaires</p>
                    </div>
                </div>

                {{-- Zone de texte riche (Rendu TinyMCE) --}}
                <div class="prose prose-lg max-w-none prose-slate prose-img:rounded-2xl prose-headings:text-slate-900 prose-a:text-emerald-600">
                    {!! $article->content !!}
                </div>

                {{-- Boutons de partage --}}
                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-6">
                    <span class="text-slate-500 font-bold text-sm uppercase tracking-wider">Partager l'article :</span>

                    <div class="flex items-center gap-3">
                        {{-- Bouton Copier le lien (optionnel mais très utile) --}}
                        <button onclick="copyToClipboard()"
                                class="w-11 h-11 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center transition-transform hover:scale-110 shadow-lg shadow-black/5"
                                title="Copier le lien">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>
                </div>

                <script>
                    function copyToClipboard() {
                        navigator.clipboard.writeText(window.location.href);
                        // On pourrait ajouter un petit Toast ici aussi si tu veux
                        Swal.fire({
                            toast: true, position: 'bottom-end', icon: 'success', title: 'Lien copié !',
                            showConfirmButton: false, timer: 2000
                        });
                    }
                </script>
            </div>

            {{-- Sidebar (Articles suggérés) --}}
            <aside class="lg:w-1/3 space-y-8">
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 italic">À lire aussi</h3>
                    <div class="space-y-6">
                        @foreach($recentArticles as $recent)
                            <a href="{{ route('home.article.show', $recent->slug) }}" class="group flex gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $recent->picture) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-emerald-600">
                                        {{ $recent->title }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400 mt-1 uppercase">{{ $recent->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>
@endsection

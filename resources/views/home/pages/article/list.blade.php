@extends('home.index')

@section('content')
<section class="py-20 bg-white mt-20">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-16 animate-fadeInUp">
            <h2 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
                Actualités & Blog
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Restez informés des dernières tendances en gestion documentaire, réglementations et innovations
                technologiques
            </p>
        </div>

        <!-- Blog Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" id="blogContainer">
            @forelse ($articles as $article)
                <article class="blog-card bg-white rounded-3xl shadow-lg overflow-hidden" data-category="tech">
                    <div class="blog-image-container">
                        <div class="blog-image h-56 flex items-center justify-center">
                            @if($article->picture)
                            {{-- Vérifier que l'image existe dans le stockage du serveur --}}
                                <img src="{{ asset('storage/' . $article->picture) }}"
                                        alt="{{ $article->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="blog-category category-tech">Technologie</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-4 mb-3">
                            {{ Str::limit(strip_tags($article->title), 30) }}
                        </h3>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>📅 {{ $article->created_at->translatedFormat('d M Y') }}</span>
                            <span>{{ $article->user->name ?? 'Rédaction' }}</span>
                        </div>
                        <a href="{{ route('home.article.show', $article->slug) }}"
                            class="inline-block mt-4 text-green-600 font-semibold hover:text-green-700 transition-colors">
                            Lire l'article →
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 3v4h4"></path></svg>
                    </div>
                    <p class="text-slate-500 text-lg">Aucun article n'a été publié pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-16 flex justify-center">
        {{ $articles->links() }}
    </div>
</section>
@endsection

@extends('home.index')

@section('content')

<style>
    /* ══════════════════════════════════════
       GLOBAL
    ══════════════════════════════════════ */
    .blog-page {
        background: var(--dark);
        color: var(--white);
        min-height: 100vh;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .blog-hero {
        background: var(--dark-2);
        position: relative;
        overflow: hidden;
        padding: 10rem 0 5rem;
        border-bottom: 1px solid color-mix(in srgb, var(--orange) 15%, transparent);
    }

    .blog-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px);
        background-size: 52px 52px;
    }

    .blog-hero-glow {
        position: absolute;
        top: -180px; right: -180px;
        width: 560px; height: 560px;
        border-radius: 50%;
        background: radial-gradient(circle, color-mix(in srgb, var(--orange) 12%, transparent) 0%, transparent 65%);
        pointer-events: none;
    }

    /* ══════════════════════════════════════
       BADGE TAG
    ══════════════════════════════════════ */
    .badge-tag {
        display: inline-flex; align-items: center; gap: 0.45rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.7rem; font-weight: 700; letter-spacing: 0.13em;
        text-transform: uppercase; color: var(--orange);
        border: 1.5px solid color-mix(in srgb, var(--orange) 35%, transparent);
        background: color-mix(in srgb, var(--orange) 5%, transparent);
        border-radius: 50px; padding: 0.3rem 0.85rem;
        margin-bottom: 1rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.42rem; }

    /* ══════════════════════════════════════
       BLOG CARDS
    ══════════════════════════════════════ */
    .blog-card {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px; /* Plus tech */
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color 0.35s ease, transform 0.35s ease, box-shadow 0.35s ease;
    }

    .blog-card:hover {
        border-color: color-mix(in srgb, var(--orange) 40%, transparent);
        transform: translateY(-6px);
        box-shadow: 0 20px 50px color-mix(in srgb, var(--orange) 10%, transparent);
    }

    /* Image container */
    .blog-img-wrap {
        position: relative;
        height: 210px;
        overflow: hidden;
        background: var(--dark-4);
        flex-shrink: 0;
    }

    .blog-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .blog-img-wrap img { transform: scale(1.06); }

    /* Placeholder quand pas d'image */
    .blog-img-placeholder {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, var(--dark-3), var(--dark-4));
    }

    .blog-img-placeholder svg { color: color-mix(in srgb, var(--orange) 30%, transparent); }

    /* Overlay gradient sur l'image */
    .blog-img-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, color-mix(in srgb, var(--dark-3) 80%, transparent) 0%, transparent 60%);
        pointer-events: none;
    }

    /* Catégorie chip */
    .blog-cat {
        position: absolute; top: 0.85rem; left: 0.85rem;
        background: var(--orange);
        color: #000;
        font-family: 'Syne', sans-serif;
        font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        padding: 0.25rem 0.7rem; border-radius: 2px;
    }

    /* Corps de la carte */
    .blog-body {
        padding: 1.5rem;
        display: flex; flex-direction: column;
        flex: 1;
    }

    .blog-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem; font-weight: 700;
        color: var(--white); line-height: 1.35;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        transition: color 0.25s;
    }

    .blog-card:hover .blog-card-title { color: var(--orange); }

    .blog-card-excerpt {
        font-size: 0.85rem;
        color: var(--gray-light);
        line-height: 1.65;
        margin-bottom: 1.25rem;
        flex: 1;
        font-weight: 300;
    }

    .blog-card-meta {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.75rem; color: var(--gray);
        padding-top: 1rem;
        border-top: 1px solid color-mix(in srgb, var(--white) 6%, transparent);
        margin-bottom: 1rem;
    }

    .blog-card-meta .author {
        display: flex; align-items: center; gap: 0.5rem;
    }

    .author-dot {
        width: 24px; height: 24px; border-radius: 50%;
        background: color-mix(in srgb, var(--orange) 20%, transparent);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 0.65rem; font-weight: 700; color: var(--orange);
        text-transform: uppercase;
    }

    .blog-read-link {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.8rem; font-weight: 700; color: var(--orange);
        letter-spacing: 0.08em; text-transform: uppercase;
        text-decoration: none;
        transition: gap 0.25s;
    }

    .blog-read-link:hover { gap: 0.6rem; }

    /* ══════════════════════════════════════
       CARTE VIDE
    ══════════════════════════════════════ */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        width: 80px; height: 80px; border-radius: 4px;
        background: var(--dark-3); border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }

    /* ══════════════════════════════════════
       PAGINATION override (Thème dynamique)
    ══════════════════════════════════════ */
    nav[role="navigation"] span,
    nav[role="navigation"] a {
        background: var(--dark-3) !important;
        border-color: color-mix(in srgb, var(--white) 8%, transparent) !important;
        color: var(--gray-light) !important;
        border-radius: 4px !important;
    }

    nav[role="navigation"] a:hover {
        background: color-mix(in srgb, var(--orange) 15%, transparent) !important;
        border-color: color-mix(in srgb, var(--orange) 35%, transparent) !important;
        color: var(--orange) !important;
    }

    nav[role="navigation"] [aria-current="page"] span {
        background: var(--orange) !important;
        border-color: var(--orange) !important;
        color: #000 !important;
        font-weight: bold;
    }

    /* ══════════════════════════════════════
       ANIMATE
    ══════════════════════════════════════ */
    .fade-up {
        opacity: 0; transform: translateY(24px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-up.in { opacity: 1; transform: none; }
</style>

<div class="blog-page">

    {{-- ════════════════════════════════════════
         HERO
    ════════════════════════════════════════ --}}
    <section class="blog-hero">
        <div class="blog-hero-glow"></div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 text-center">
            <div class="flex justify-center"><div class="badge-tag mb-4">Actualités & Blog</div></div>
            <h1 class="text-5xl md:text-6xl font-display tracking-wide text-[var(--white)] mt-1 mb-5">
                Nos <span class="text-[var(--orange)]">actualités</span>
            </h1>
            <p class="text-lg md:text-xl font-light max-w-2xl mx-auto leading-relaxed text-[var(--gray-light)]">
                Conseils techniques, projets réalisés et dernières tendances en installation électrique,
                énergie solaire et technologies de sécurité.
            </p>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         GRILLE D'ARTICLES
    ════════════════════════════════════════ --}}
    <section class="py-16 bg-[var(--dark)]">
        <div class="container mx-auto px-6 max-w-7xl">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" id="blogContainer">

                @forelse ($articles as $index => $article)
                    <article class="blog-card fade-up" style="transition-delay: {{ $index % 6 * 80 }}ms">

                        {{-- Image --}}
                        <div class="blog-img-wrap">
                            @if($article->picture)
                                <img src="{{ asset('storage/' . $article->picture) }}"
                                     alt="{{ $article->title }}">
                            @else
                                <div class="blog-img-placeholder">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span style="font-size:0.72rem;color:var(--gray);text-transform:uppercase;letter-spacing:0.08em;font-family:'Syne',sans-serif;font-weight:bold;">
                                        POLAM SARL
                                    </span>
                                </div>
                            @endif
                            <div class="blog-img-overlay"></div>
                            <span class="blog-cat">Actualité</span>
                        </div>

                        {{-- Corps --}}
                        <div class="blog-body">
                            <h3 class="blog-card-title">
                                {{ Str::limit(strip_tags($article->title), 60) }}
                            </h3>
                            <p class="blog-card-excerpt">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <div class="blog-card-meta">
                                <div class="author">
                                    <div class="author-dot">
                                        {{ substr($article->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <span>{{ $article->user->name ?? 'Rédaction POLAM' }}</span>
                                </div>
                                <span>📅 {{ $article->created_at->translatedFormat('d M Y') }}</span>
                            </div>

                            <a href="{{ route('home.article.show', $article->slug) }}"
                               class="blog-read-link">
                                Lire l'article <span>→</span>
                            </a>
                        </div>

                    </article>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-9 h-9" style="color:var(--orange)"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 3v4h4"/>
                            </svg>
                        </div>
                        <p class="text-xl font-heading font-bold text-[var(--white)] mb-2 uppercase">Aucun article publié pour le moment</p>
                        <p class="font-light text-[var(--gray-light)] text-sm">
                            Revenez bientôt pour découvrir nos actualités et conseils techniques.
                        </p>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-10 flex justify-center">
                {{ $articles->links() }}
            </div>

        </div>
    </section>

</div>

<script>
    // Fade-up au scroll
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.fade-up').forEach(el => io.observe(el));
</script>

@endsection

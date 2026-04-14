@extends('home.index')

@section('content')

<style>
    /* ══════════════════════════════════════
       GLOBAL
    ══════════════════════════════════════ */
    .blog-page {
        background: #111111;
        color: #ffffff;
        min-height: 100vh;
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .blog-hero {
        background: #111111;
        position: relative;
        overflow: hidden;
        padding: 9rem 0 5rem;
    }

    .blog-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(244,123,32,0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(244,123,32,0.055) 1px, transparent 1px);
        background-size: 52px 52px;
    }

    .blog-hero-glow {
        position: absolute;
        top: -180px; right: -180px;
        width: 560px; height: 560px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(244,123,32,0.1) 0%, transparent 65%);
        pointer-events: none;
    }

    /* ══════════════════════════════════════
       BADGE TAG
    ══════════════════════════════════════ */
    .badge-tag {
        display: inline-flex; align-items: center; gap: 0.45rem;
        font-size: 0.7rem; font-weight: 700; letter-spacing: 0.13em;
        text-transform: uppercase; color: #F47B20;
        border: 1.5px solid rgba(244,123,32,0.35);
        border-radius: 50px; padding: 0.3rem 0.85rem;
        margin-bottom: 1rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.42rem; }

    /* ══════════════════════════════════════
       BLOG CARDS
    ══════════════════════════════════════ */
    .blog-card {
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color 0.35s ease, transform 0.35s ease, box-shadow 0.35s ease;
    }

    .blog-card:hover {
        border-color: rgba(244,123,32,0.35);
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(244,123,32,0.1);
    }

    /* Image container */
    .blog-img-wrap {
        position: relative;
        height: 210px;
        overflow: hidden;
        background: #242424;
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
        background: linear-gradient(135deg, #1A1A1A, #242424);
    }

    .blog-img-placeholder svg { color: rgba(244,123,32,0.3); }

    /* Overlay gradient sur l'image */
    .blog-img-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(26,26,26,0.7) 0%, transparent 60%);
        pointer-events: none;
    }

    /* Catégorie chip */
    .blog-cat {
        position: absolute; top: 0.85rem; left: 0.85rem;
        background: #F47B20;
        color: #fff;
        font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        padding: 0.25rem 0.7rem; border-radius: 50px;
    }

    /* Corps de la carte */
    .blog-body {
        padding: 1.5rem;
        display: flex; flex-direction: column;
        flex: 1;
    }

    .blog-card-title {
        font-size: 1.05rem; font-weight: 700;
        color: #ffffff; line-height: 1.35;
        letter-spacing: -0.01em;
        margin-bottom: 0.75rem;
        transition: color 0.25s;
    }

    .blog-card:hover .blog-card-title { color: #F47B20; }

    .blog-card-excerpt {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.5);
        line-height: 1.65;
        margin-bottom: 1.25rem;
        flex: 1;
    }

    .blog-card-meta {
        display: flex; align-items: center; justify-content: space-between;
        font-size: 0.75rem; color: rgba(255,255,255,0.3);
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin-bottom: 1rem;
    }

    .blog-card-meta .author {
        display: flex; align-items: center; gap: 0.5rem;
    }

    .author-dot {
        width: 24px; height: 24px; border-radius: 50%;
        background: rgba(244,123,32,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem; font-weight: 700; color: #F47B20;
        text-transform: uppercase;
    }

    .blog-read-link {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.8rem; font-weight: 700; color: #F47B20;
        letter-spacing: 0.03em;
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
        width: 80px; height: 80px; border-radius: 50%;
        background: #1A1A1A; border: 1px solid rgba(255,255,255,0.07);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }

    /* ══════════════════════════════════════
       PAGINATION override (dark)
    ══════════════════════════════════════ */
    nav[role="navigation"] span,
    nav[role="navigation"] a {
        background: #1A1A1A !important;
        border-color: rgba(255,255,255,0.08) !important;
        color: rgba(255,255,255,0.6) !important;
        border-radius: 8px !important;
    }

    nav[role="navigation"] a:hover {
        background: rgba(244,123,32,0.15) !important;
        border-color: rgba(244,123,32,0.35) !important;
        color: #F47B20 !important;
    }

    nav[role="navigation"] [aria-current="page"] span {
        background: #F47B20 !important;
        border-color: #F47B20 !important;
        color: #fff !important;
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
        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="badge-tag mx-auto">Actualités & Blog</div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mt-1 mb-5"
                style="letter-spacing:-0.03em; line-height:1.05">
                Nos <span style="color:#F47B20">actualités</span>
            </h1>
            <p class="text-lg max-w-2xl mx-auto leading-relaxed" style="color:rgba(255,255,255,0.5)">
                Conseils techniques, projets réalisés et dernières tendances en installation électrique,
                énergie solaire et technologies de sécurité.
            </p>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         GRILLE D'ARTICLES
    ════════════════════════════════════════ --}}
    <section class="py-16 bg-[#111111]">
        <div class="container mx-auto px-6">

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7 mb-12" id="blogContainer">

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
                                    <span style="font-size:0.72rem;color:rgba(255,255,255,0.2);text-transform:uppercase;letter-spacing:0.08em">
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
                            <svg class="w-9 h-9" style="color:rgba(244,123,32,0.4)"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 3v4h4"/>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold text-white mb-2">Aucun article publié pour le moment</p>
                        <p style="color:rgba(255,255,255,0.4);font-size:0.9rem">
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

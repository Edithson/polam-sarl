@extends('home.index')

@section('content')

<style>
    /* ══════════════════════════════════════
       GLOBAL
    ══════════════════════════════════════ */
    .article-page {
        background: var(--dark);
        color: var(--white);
        min-height: 100vh;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* ══════════════════════════════════════
       HERO IMAGE
    ══════════════════════════════════════ */
    .article-hero {
        position: relative;
        width: 100%;
        height: 52vh;
        min-height: 400px;
        overflow: hidden;
    }

    .article-hero img {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    /* Placeholder si pas d'image */
    .article-hero-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, var(--dark-2) 0%, var(--dark-3) 100%);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 1rem;
        position: relative;
    }

    /* Grille circuit sur placeholder */
    .article-hero-placeholder::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    /* Overlay dégradé en bas du hero */
    .article-hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top,
            var(--dark) 0%,
            color-mix(in srgb, var(--dark) 50%, transparent) 40%,
            transparent 100%);
    }

    /* Zone titre dans le hero */
    .article-hero-caption {
        position: absolute; bottom: 0; left: 0; width: 100%;
        padding: 2rem 3rem 2.5rem;
    }

    /* ══════════════════════════════════════
       BADGE / PILLS
    ══════════════════════════════════════ */
    .badge-orange {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: var(--orange); color: #000;
        font-family: 'Syne', sans-serif;
        font-size: 0.68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        padding: 0.28rem 0.75rem; border-radius: 2px;
    }

    .badge-date {
        font-size: 0.82rem;
        color: var(--gray-light);
    }

    /* ══════════════════════════════════════
       LAYOUT PRINCIPAL
    ══════════════════════════════════════ */
    .article-layout {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
    }

    .article-inner {
        display: flex;
        gap: 4rem;
        align-items: flex-start;
    }

    /* ══════════════════════════════════════
       CONTENU PRINCIPAL
    ══════════════════════════════════════ */
    .article-content-wrap { flex: 1; min-width: 0; }

    /* Auteur */
    .author-bar {
        display: flex; align-items: center; gap: 1rem;
        padding-bottom: 1.75rem;
        border-bottom: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        margin-bottom: 2.5rem;
    }

    .author-avatar {
        width: 46px; height: 46px;
        border-radius: 50%;
        background: color-mix(in srgb, var(--orange) 15%, transparent);
        border: 2px solid color-mix(in srgb, var(--orange) 30%, transparent);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-weight: 800; font-size: 1.1rem;
        color: var(--orange); text-transform: uppercase;
        flex-shrink: 0;
    }

    .author-name {
        font-family: 'Syne', sans-serif; font-weight: 700; color: var(--white); font-size: 0.95rem; line-height: 1;
    }

    .author-role {
        font-size: 0.78rem; color: var(--gray); margin-top: 0.3rem; text-transform: uppercase; letter-spacing: 0.05em;
    }

    /* Prose — Style du contenu de l'article */
    .article-prose {
        color: var(--gray-light);
        font-size: 1.05rem;
        line-height: 1.85;
        font-weight: 300;
    }

    .article-prose h1,
    .article-prose h2,
    .article-prose h3,
    .article-prose h4 {
        color: var(--white);
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        margin-top: 2.5rem; margin-bottom: 1rem;
    }

    .article-prose h2 { font-size: 1.6rem; }
    .article-prose h3 { font-size: 1.3rem; }

    .article-prose p { margin-bottom: 1.4rem; }

    .article-prose a {
        color: var(--orange); text-decoration: underline;
        text-decoration-color: color-mix(in srgb, var(--orange) 40%, transparent);
        transition: text-decoration-color 0.2s;
    }
    .article-prose a:hover { text-decoration-color: var(--orange); }

    .article-prose strong { color: var(--white); font-weight: 700; }
    .article-prose em { color: var(--white); opacity: 0.85; }

    .article-prose img {
        border-radius: 4px;
        width: 100%;
        margin: 2rem 0;
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
    }

    .article-prose ul,
    .article-prose ol {
        padding-left: 1.5rem;
        margin-bottom: 1.4rem;
    }

    .article-prose ul li { list-style: none; padding-left: 0.5rem; position: relative; }
    .article-prose ul li::before {
        content: '→';
        color: var(--orange);
        position: absolute; left: -1.2rem;
        font-weight: 700;
    }

    .article-prose ol li { list-style: decimal; margin-bottom: 0.5rem; }

    .article-prose blockquote {
        border-left: 4px solid var(--orange);
        padding: 1.2rem 1.5rem;
        background: color-mix(in srgb, var(--orange) 6%, transparent);
        color: var(--white);
        font-style: italic;
        margin: 2rem 0;
    }

    .article-prose code {
        background: var(--dark-3);
        color: var(--orange);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.88em;
    }

    .article-prose pre {
        background: var(--dark-4);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px;
        padding: 1.5rem;
        overflow-x: auto;
        margin: 1.5rem 0;
    }

    .article-prose hr {
        border: none;
        border-top: 1px solid color-mix(in srgb, var(--white) 8%, transparent);
        margin: 2.5rem 0;
    }

    /* Partage */
    .share-bar {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;
    }

    .share-label {
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--gray);
    }

    .share-btn {
        width: 40px; height: 40px;
        border-radius: 4px;
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 8%, transparent);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: background 0.25s, border-color 0.25s, transform 0.25s;
        color: var(--gray-light);
    }

    .share-btn:hover {
        background: color-mix(in srgb, var(--orange) 12%, transparent);
        border-color: color-mix(in srgb, var(--orange) 40%, transparent);
        color: var(--orange);
        transform: scale(1.1);
    }

    .share-btn svg { width: 16px; height: 16px; stroke: currentColor; }

    /* ══════════════════════════════════════
       SIDEBAR
    ══════════════════════════════════════ */
    .article-sidebar {
        width: 320px;
        flex-shrink: 0;
    }

    .sidebar-card {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .sidebar-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--orange), var(--orange-glow), transparent);
    }

    .sidebar-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.85rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.12em;
        color: var(--white);
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 0.5rem;
    }

    .sidebar-card-title::before {
        content: '';
        display: block; width: 16px; height: 2px;
        background: var(--orange);
    }

    /* Articles récents */
    .recent-item {
        display: flex; gap: 0.9rem;
        padding: 0.9rem 0;
        border-bottom: 1px solid color-mix(in srgb, var(--white) 5%, transparent);
        text-decoration: none;
        transition: all 0.25s;
    }

    .recent-item:last-child { border-bottom: none; }

    .recent-item:hover .recent-title { color: var(--orange); }
    .recent-item:hover .recent-thumb { transform: scale(1.05); }

    .recent-thumb-wrap {
        width: 64px; height: 64px;
        border-radius: 4px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--dark-4);
    }

    .recent-thumb {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .recent-thumb-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: var(--orange);
    }

    .recent-title {
        font-family: 'Syne', sans-serif;
        font-size: 0.85rem; font-weight: 600;
        color: var(--white);
        line-height: 1.4; text-transform: uppercase;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.25s;
    }

    .recent-date {
        font-size: 0.68rem;
        color: var(--gray);
        margin-top: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* Contact CTA sidebar */
    .sidebar-cta {
        margin-top: 1.5rem;
        background: var(--orange);
        border-radius: 4px;
        padding: 1.75rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .sidebar-cta::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(color-mix(in srgb, var(--white) 15%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--white) 15%, transparent) 1px, transparent 1px);
        background-size: 30px 30px;
    }

    .sidebar-cta h4 {
        font-family: 'Syne', sans-serif; text-transform: uppercase;
        font-weight: 800; font-size: 1rem;
        color: #000; margin-bottom: 0.5rem;
        position: relative; z-index: 1;
        letter-spacing: 0.05em;
    }

    .sidebar-cta p {
        font-size: 0.78rem; color: rgba(0,0,0,0.8);
        margin-bottom: 1.25rem; line-height: 1.55;
        position: relative; z-index: 1; font-weight: 600;
    }

    .sidebar-cta a {
        display: inline-block;
        background: #000; color: var(--white);
        padding: 0.75rem 1.4rem;
        font-family: 'Syne', sans-serif;
        font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;
        text-decoration: none;
        transition: background 0.25s, color 0.25s;
        position: relative; z-index: 1;
        clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
    }

    .sidebar-cta a:hover { background: var(--dark-3); color: var(--orange); }

    /* ══════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .article-inner { flex-direction: column; gap: 3rem; }
        .article-sidebar { width: 100%; }
        .article-hero-caption { padding: 1.5rem; }
    }

    @media (max-width: 640px) {
        .article-layout { padding: 2rem 1rem; }
        .article-hero { min-height: 320px; }
    }
</style>

<div class="article-page">

    {{-- ════════════════════════════════════════
         HERO IMAGE + TITRE
    ════════════════════════════════════════ --}}
    <div class="article-hero">

        @if($article->picture)
            <img src="{{ asset('storage/' . $article->picture) }}"
                 alt="{{ $article->title }}">
        @else
            <div class="article-hero-placeholder">
                <svg width="64" height="64" fill="none" stroke="currentColor" style="color:var(--orange)"
                     viewBox="0 0 24 24" style="position:relative;z-index:1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.72rem;color:var(--gray);text-transform:uppercase;letter-spacing:0.1em;position:relative;z-index:1">
                    POLAM SARL
                </span>
            </div>
        @endif

        <div class="article-hero-overlay"></div>

        <div class="article-hero-caption">
            <div class="container mx-auto max-w-7xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="badge-orange">Article</span>
                    <span class="badge-date font-heading uppercase tracking-widest text-xs">
                        Publié le {{ $article->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-display text-[var(--white)] tracking-wide leading-tight max-w-4xl">
                    {{ $article->title }}
                </h1>
            </div>
        </div>

    </div>

    {{-- ════════════════════════════════════════
         CORPS — contenu + sidebar
    ════════════════════════════════════════ --}}
    <div class="article-layout">
        <div class="article-inner">

            {{-- ── CONTENU PRINCIPAL ── --}}
            <div class="article-content-wrap">

                {{-- Auteur --}}
                <div class="author-bar">
                    <div class="author-avatar">
                        {{ substr($article->user->name ?? 'P', 0, 1) }}
                    </div>
                    <div>
                        <div class="author-name">
                            {{ $article->user->name ?? 'Rédaction POLAM SARL' }}
                        </div>
                        <div class="author-role">Équipe POLAM SARL</div>
                    </div>
                    <div style="margin-left:auto;font-size:0.75rem;color:var(--gray)">
                        {{ $article->created_at->diffForHumans() }}
                    </div>
                </div>

                {{-- Rendu riche TinyMCE --}}
                <div class="article-prose">
                    {!! $article->content !!}
                </div>

                {{-- Partage --}}
                <div class="share-bar">
                    <span class="share-label">Partager :</span>

                    {{-- Copier le lien --}}
                    <button onclick="copyLink()" class="share-btn" title="Copier le lien">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>
                    </button>

                    {{-- WhatsApp --}}
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' - ' . request()->url()) }}"
                       target="_blank" rel="noopener" class="share-btn" title="Partager sur WhatsApp">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:none;">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener" class="share-btn" title="Partager sur Facebook">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:none;">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener" class="share-btn" title="Partager sur LinkedIn">
                        <svg fill="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:none;">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                </div>

            </div>

            {{-- ── SIDEBAR ── --}}
            <aside class="article-sidebar">

                {{-- À lire aussi --}}
                <div class="sidebar-card">
                    <div class="sidebar-card-title">À lire aussi</div>
                    <div>
                        @foreach($recentArticles as $recent)
                            <a href="{{ route('home.article.show', $recent->slug) }}"
                               class="recent-item">
                                <div class="recent-thumb-wrap">
                                    @if($recent->picture)
                                        <img src="{{ asset('storage/' . $recent->picture) }}"
                                             alt="{{ $recent->title }}"
                                             class="recent-thumb">
                                    @else
                                        <div class="recent-thumb-placeholder">⚡</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="recent-title">{{ $recent->title }}</div>
                                    <div class="recent-date">{{ $recent->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- CTA contact --}}
                <div class="sidebar-cta">
                    <h4>Un projet en tête ?</h4>
                    <p>Contactez-nous pour une étude gratuite et un devis personnalisé.</p>
                    <a href="{{ route('contact') }}">Demander un devis →</a>
                </div>

                {{-- Coordonnées rapides --}}
                <div class="sidebar-card" style="margin-top:1.5rem">
                    <div class="sidebar-card-title">Nous joindre</div>
                    <div style="display:flex;flex-direction:column;gap:0.85rem">
                        <a href="tel:+237698359954"
                           style="display:flex;align-items:center;gap:0.7rem;font-family:'Syne',sans-serif;font-size:0.85rem;font-weight:600;
                                  color:var(--gray-light);text-decoration:none;
                                  transition:color 0.2s"
                           onmouseover="this.style.color='var(--orange)'"
                           onmouseout="this.style.color='var(--gray-light)'">
                            <span style="color:var(--orange);font-size:1rem">📞</span>
                            +237 698 359 954
                        </a>
                        <a href="tel:+237674180413"
                           style="display:flex;align-items:center;gap:0.7rem;font-family:'Syne',sans-serif;font-size:0.85rem;font-weight:600;
                                  color:var(--gray-light);text-decoration:none;
                                  transition:color 0.2s"
                           onmouseover="this.style.color='var(--orange)'"
                           onmouseout="this.style.color='var(--gray-light)'">
                            <span style="color:var(--orange);font-size:1rem">📞</span>
                            +237 674 180 413
                        </a>
                        <a href="mailto:polamsarl@gmail.com"
                           style="display:flex;align-items:center;gap:0.7rem;font-family:'Syne',sans-serif;font-size:0.82rem;font-weight:600;
                                  color:var(--gray-light);text-decoration:none;
                                  transition:color 0.2s"
                           onmouseover="this.style.color='var(--orange)'"
                           onmouseout="this.style.color='var(--gray-light)'">
                            <span style="color:var(--orange);font-size:1rem">✉️</span>
                            polamsarl@gmail.com
                        </a>
                    </div>
                </div>

            </aside>
        </div>
    </div>

</div>

<script>
    function copyLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true, position: 'bottom-end', icon: 'success',
                    title: 'Lien copié !',
                    showConfirmButton: false, timer: 2000,
                    background: 'var(--dark-3)', color: 'var(--white)',
                    iconColor: 'var(--orange)'
                });
            } else {
                // Fallback simple si SweetAlert2 non disponible
                const btn = event.currentTarget;
                btn.style.background = 'color-mix(in srgb, var(--orange) 20%, transparent)';
                btn.style.borderColor = 'var(--orange)';
                btn.style.color = 'var(--orange)';
                setTimeout(() => {
                    btn.style.background = '';
                    btn.style.borderColor = '';
                    btn.style.color = '';
                }, 1500);
            }
        });
    }
</script>

@endsection

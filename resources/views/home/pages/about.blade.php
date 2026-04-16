@extends('home.index')

@section('content')

<style>
    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .about-hero {
        background: linear-gradient(135deg, var(--dark-2) 0%, var(--dark-3) 60%, var(--dark) 100%);
        position: relative;
        overflow: hidden;
        transition: background 0.3s ease;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--orange) 6%, transparent) 1px, transparent 1px);
        background-size: 52px 52px;
    }

    .about-hero::after {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 600px; height: 600px;
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
        font-size: 0.72rem; font-weight: 700; letter-spacing: 0.13em;
        text-transform: uppercase; color: var(--orange);
        border: 1.5px solid color-mix(in srgb, var(--orange) 35%, transparent);
        border-radius: 50px; padding: 0.32rem 0.85rem;
        margin-bottom: 0.9rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.45rem; }

    /* ══════════════════════════════════════
       STAT COUNTER
    ══════════════════════════════════════ */
    .stat-number {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 4rem;
        background: linear-gradient(135deg, var(--orange-deep), var(--orange-glow));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    @media (max-width: 768px) {
        .stat-number { font-size: 3rem; }
    }

    /* ══════════════════════════════════════
       VALUE CARDS
    ══════════════════════════════════════ */
    .value-card {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px; /* Raccord avec le style Tech */
        padding: 2rem;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .value-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--orange), var(--orange-glow));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .value-card:hover {
        transform: translateY(-8px);
        border-color: color-mix(in srgb, var(--orange) 30%, transparent);
        box-shadow: 0 20px 48px color-mix(in srgb, var(--orange) 12%, transparent);
    }

    .value-card:hover::before { transform: scaleX(1); }

    .value-icon {
        width: 60px; height: 60px;
        background: color-mix(in srgb, var(--orange) 12%, transparent);
        border: 1px solid color-mix(in srgb, var(--orange) 20%, transparent);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.9rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .value-card:hover .value-icon {
        transform: scale(1.1) rotate(-5deg);
        background: color-mix(in srgb, var(--orange) 20%, transparent);
        border-color: var(--orange);
    }

    /* ══════════════════════════════════════
       TIMELINE
    ══════════════════════════════════════ */
    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 50%; transform: translateX(-50%);
        width: 2px; height: 100%;
        background: linear-gradient(180deg, var(--orange) 0%, color-mix(in srgb, var(--orange) 10%, transparent) 100%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
    }

    .timeline-item:nth-child(odd) { flex-direction: row-reverse; }

    .timeline-content {
        width: calc(50% - 2.5rem);
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        padding: 1.8rem 2rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-content {
        transform: translateY(-6px);
        border-color: color-mix(in srgb, var(--orange) 30%, transparent);
        box-shadow: 0 16px 40px color-mix(in srgb, var(--orange) 10%, transparent);
    }

    .timeline-dot {
        width: 16px; height: 16px;
        background: var(--dark-2);
        border: 3px solid var(--orange);
        border-radius: 50%;
        position: absolute;
        left: 50%; transform: translateX(-50%);
        z-index: 10;
        transition: all 0.3s ease;
    }

    .timeline-item:nth-child(even) .timeline-dot {
        border-color: var(--orange-glow);
        background: var(--orange);
    }

    .timeline-item:hover .timeline-dot {
        transform: translateX(-50%) scale(1.5);
        box-shadow: 0 0 20px color-mix(in srgb, var(--orange) 60%, transparent);
    }

    /* ══════════════════════════════════════
       EXPERTISE BARS
    ══════════════════════════════════════ */
    .expertise-bar {
        background: color-mix(in srgb, var(--white) 7%, transparent);
        height: 6px; /* Plus fin, plus tech */
        overflow: hidden;
    }

    .expertise-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--orange-deep), var(--orange-glow));
        transition: width 1.5s ease-in-out;
    }

    /* ══════════════════════════════════════
       MISSION VISUAL CARD
    ══════════════════════════════════════ */
    .mission-visual {
        background: linear-gradient(135deg, var(--dark-3), var(--dark-4));
        border: 1px solid color-mix(in srgb, var(--orange) 18%, transparent);
        border-radius: 4px;
        overflow: hidden;
    }

    /* ══════════════════════════════════════
       CTA
    ══════════════════════════════════════ */
    .cta-section {
        background: var(--orange);
        position: relative; overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(color-mix(in srgb, var(--white) 15%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--white) 15%, transparent) 1px, transparent 1px);
        background-size: 44px 44px;
        opacity: 0.5;
    }

    /* ══════════════════════════════════════
       BTN PRIMARY (Adapté au thème)
    ══════════════════════════════════════ */
    .btn-primary {
        background: var(--orange);
        color: #000;
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.9rem 2.2rem;
        border: none;
        cursor: pointer;
        clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
        transition: all 0.25s;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }

    .btn-primary:hover {
        background: var(--orange-glow);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px color-mix(in srgb, var(--orange) 40%, transparent);
    }

    /* ══════════════════════════════════════
       STAT CARD
    ══════════════════════════════════════ */
    .stat-card {
        text-align: center;
        padding: 1.75rem 1rem;
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 6%, transparent);
        transition: border-color 0.3s, transform 0.3s;
    }
    .stat-card:hover {
        border-color: color-mix(in srgb, var(--orange) 30%, transparent);
        transform: translateY(-4px);
    }

    /* ══════════════════════════════════════
       TEAM CARD
    ══════════════════════════════════════ */
    .team-card {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px;
        overflow: hidden;
        transition: all 0.35s ease;
    }

    .team-card:hover {
        border-color: color-mix(in srgb, var(--orange) 35%, transparent);
        transform: translateY(-6px);
        box-shadow: 0 20px 48px color-mix(in srgb, var(--orange) 10%, transparent);
    }

    .team-avatar {
        height: 180px;
        background: linear-gradient(135deg, var(--dark-4), var(--dark-3));
        display: flex; align-items: center; justify-content: center;
        font-size: 4rem;
        border-bottom: 1px solid color-mix(in srgb, var(--orange) 12%, transparent);
    }

    /* ══════════════════════════════════════
       RESPONSIVE TIMELINE
    ══════════════════════════════════════ */
    @media (max-width: 1024px) {
        .timeline::before { left: 20px; }
        .timeline-item,
        .timeline-item:nth-child(odd) {
            flex-direction: column !important;
            align-items: flex-start;
            padding-left: 4rem;
        }
        .timeline-content { width: 100%; }
        .timeline-dot { left: 10px; transform: translateX(0); }
        .timeline-item:hover .timeline-dot { transform: scale(1.4); }
    }
</style>

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section class="about-hero pt-36 pb-24 text-[var(--white)]">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <div class="badge-tag">À propos de nous</div>
            <h1 class="text-5xl md:text-6xl font-display mb-6 leading-tight tracking-wide">
                La technologie et<br>
                <span class="text-[var(--orange)]">l'innovation à votre portée</span>
            </h1>
            <p class="text-[var(--gray-light)] text-lg md:text-xl font-light leading-relaxed max-w-2xl mb-10">
                Depuis 2019, POLAM SARL accompagne particuliers, entreprises et institutions avec des solutions
                électriques, énergétiques et technologiques de qualité — conçues, installées et maintenues
                par une équipe jeune, qualifiée et engagée.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#mission" class="btn-primary">Notre mission →</a>
                <a href="{{ route('contact') }}"
                   class="btn-ghost" style="padding: 0.9rem 2.2rem;">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>

    {{-- Deco SVG circuit (Adapté au thème) --}}
    <div class="absolute bottom-0 right-0 opacity-10 pointer-events-none hidden lg:block text-[var(--orange)]" style="width:420px">
        <div class="text-center">
            <img src="{{ asset('media/img/autres/about.png') }}" alt="">
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     QUI SOMMES-NOUS + STATS
════════════════════════════════════════ --}}
<section class="py-20 bg-[var(--dark)] text-[var(--white)] transition-colors duration-300">
    <div class="container mx-auto px-6">

        {{-- Intro --}}
        <div class="max-w-4xl mx-auto mb-16">
            <div class="flex justify-center mb-6">
                <div class="badge-tag">Qui sommes-nous ?</div>
            </div>
            <h2 class="text-3xl md:text-4xl font-display tracking-wide mb-8 text-center">
                Une entreprise camerounaise au cœur de la <span class="text-[var(--orange)]">technologie</span>
            </h2>
            <div class="space-y-5 text-[var(--gray-light)] text-lg leading-relaxed font-light">
                <p>
                    <strong class="text-[var(--white)] font-semibold">POLAM SARL</strong> est une entreprise spécialisée dans l'étude,
                    la conception, la mise en œuvre et la maintenance des installations électriques domestiques,
                    de la domotique, des systèmes tertiaires ainsi que des énergies renouvelables.
                </p>
                <p>
                    Notre expertise couvre l'ensemble du cycle de vie de vos projets technologiques : de la
                    première étude technique jusqu'à la maintenance opérationnelle, en passant par la fourniture
                    de matériel importé et le commerce général.
                </p>
                <p>
                    Nous intervenons sur six pôles complémentaires :
                    <strong class="text-[var(--orange)] font-semibold">installation électrique</strong>,
                    <strong class="text-[var(--orange)] font-semibold">énergie solaire</strong>,
                    <strong class="text-[var(--orange)] font-semibold">vidéosurveillance & alarme</strong>,
                    <strong class="text-[var(--orange)] font-semibold">réseaux & télécommunications</strong>,
                    <strong class="text-[var(--orange)] font-semibold">maintenance IT & biomédicale</strong>.
                </p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div class="stat-card">
                <div class="stat-number" data-target="6">0</div>
                <p class="font-heading font-bold mt-2 text-xs uppercase tracking-widest text-[var(--gray)]">Années d'Expérience</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="6">0</div>
                <p class="font-heading font-bold mt-2 text-xs uppercase tracking-widest text-[var(--gray)]">Pôles de Services</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="100">0</div>
                <p class="font-heading font-bold mt-2 text-xs uppercase tracking-widest text-[var(--gray)]">% Engagement Client</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="360">0</div>
                <p class="font-heading font-bold mt-2 text-xs uppercase tracking-widest text-[var(--gray)]">° Accompagnement</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     MISSION & VISION
════════════════════════════════════════ --}}
<section id="mission" class="py-20 bg-[var(--dark-2)] text-[var(--white)] transition-colors duration-300">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div class="order-2 lg:order-1">
                <div class="badge-tag">Notre mission</div>
                <h2 class="text-3xl md:text-4xl font-display tracking-wide mb-6">
                    Rendre la technologie <br><span class="text-[var(--orange)]">accessible à tous</span>
                </h2>
                <p class="text-[var(--gray-light)] font-light text-lg leading-relaxed mb-5">
                    <strong class="text-[var(--white)] font-semibold">POLAM SARL</strong> s'engage à transformer vos projets
                    technologiques en réalités fiables et durables — en combinant expertise technique,
                    réactivité terrain et solutions sur mesure adaptées au contexte camerounais.
                </p>

                {{-- Vision --}}
                <div class="p-6 mt-8 border-l-2 border-[var(--orange)] bg-[color-mix(in_srgb,var(--orange)_5%,transparent)]">
                    <div class="flex items-start gap-4">
                        <span class="text-3xl">🔭</span>
                        <div>
                            <h4 class="font-heading font-bold text-[var(--white)] mb-2 uppercase tracking-wide text-sm">Notre Vision</h4>
                            <p class="text-sm font-light text-[var(--gray-light)] leading-relaxed">
                                Devenir la référence incontournable en solutions électriques et technologiques
                                au Cameroun, reconnue pour la qualité, l'innovation et la proximité client.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('contact') }}" class="btn-primary">Démarrer un projet →</a>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <div class="mission-visual w-full h-96 flex items-center justify-center p-4 shadow-[0_20px_50px_rgba(0,0,0,0.3)]">
                    <div class="text-center">
                        <img src="{{ asset('media/img/autres/about.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     NOS VALEURS
════════════════════════════════════════ --}}
<section class="py-20 bg-[var(--dark)] text-[var(--white)] transition-colors duration-300">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="text-center mb-16">
            <div class="flex justify-center mb-4"><div class="badge-tag">Nos valeurs</div></div>
            <h2 class="text-4xl md:text-5xl font-display tracking-wide">
                Ce qui nous <span class="text-[var(--orange)]">anime</span>
            </h2>
            <p class="text-[var(--gray-light)] text-lg mt-4 max-w-2xl mx-auto font-light">
                Les principes qui guident chacune de nos interventions au quotidien.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Excellence</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Chaque installation, chaque intervention reflète notre exigence de qualité supérieure.
                    Nous ne livrons pas un projet tant que les standards ne sont pas atteints.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Engagement Client</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Votre satisfaction est notre mesure de succès. Nous construisons des relations durables
                    basées sur la confiance, l'écoute et l'accompagnement personnalisé.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Fiabilité</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Nos installations sont conçues pour durer. Nous travaillons avec des équipements
                    certifiés et respectons scrupuleusement les normes techniques en vigueur.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Innovation</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Nous intégrons les technologies les plus récentes — domotique, énergie solaire,
                    réseaux intelligents — pour proposer des solutions toujours en avance.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🇨🇲</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Ancrage Local</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Enracinés au Cameroun, nous comprenons les réalités du terrain local et adaptons
                    chaque solution aux contraintes et opportunités spécifiques du marché africain.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">⚖️</div>
                <h3 class="text-lg font-heading font-bold text-[var(--white)] mb-3 uppercase tracking-wide">Intégrité</h3>
                <p class="font-light text-sm text-[var(--gray-light)] leading-relaxed">
                    Honnêteté, transparence et éthique professionnelle sont au cœur de toutes nos
                    actions. Nous disons ce que nous faisons, et faisons ce que nous disons.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     NOTRE HISTOIRE — TIMELINE
════════════════════════════════════════ --}}
<section class="py-20 bg-[var(--dark-2)] text-[var(--white)] transition-colors duration-300">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="text-center mb-16">
            <div class="flex justify-center mb-4"><div class="badge-tag">Notre histoire</div></div>
            <h2 class="text-4xl md:text-5xl font-display tracking-wide">
                Un parcours <span class="text-[var(--orange)]">marqué</span> par la croissance
            </h2>
        </div>

        <div class="timeline max-w-4xl mx-auto">
            {{-- 2019 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="font-display text-3xl text-[var(--orange)] mb-2 tracking-widest">2019</h3>
                    <h4 class="font-heading font-bold text-sm uppercase tracking-wide text-[var(--white)] mb-3">Création de POLAM SARL</h4>
                    <p class="text-[var(--gray-light)] font-light text-sm leading-relaxed">
                        Lancement des activités à Yaoundé avec une vision claire : rendre la technologie
                        accessible à tous. Premiers contrats en installation électrique résidentielle.
                    </p>
                </div>
            </div>

            {{-- 2020 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="font-display text-3xl text-[var(--orange)] mb-2 tracking-widest">2020</h3>
                    <h4 class="font-heading font-bold text-sm uppercase tracking-wide text-[var(--white)] mb-3">Élargissement du portefeuille</h4>
                    <p class="text-[var(--gray-light)] font-light text-sm leading-relaxed">
                        Extension aux installations d'énergie solaire et aux systèmes de vidéosurveillance.
                        Premiers contrats tertiaires avec des PME locales.
                    </p>
                </div>
            </div>

            {{-- 2022 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="font-display text-3xl text-[var(--orange)] mb-2 tracking-widest">2022</h3>
                    <h4 class="font-heading font-bold text-sm uppercase tracking-wide text-[var(--white)] mb-3">Pôle Biomédical & Informatique</h4>
                    <p class="text-[var(--gray-light)] font-light text-sm leading-relaxed">
                        Lancement du service de maintenance des équipements biomédicaux et informatiques.
                        Consolidation de la présence sur Yaoundé et Douala.
                    </p>
                </div>
            </div>

            {{-- 2025 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="font-display text-3xl text-[var(--orange)] mb-2 tracking-widest">2025</h3>
                    <h4 class="font-heading font-bold text-sm uppercase tracking-wide text-[var(--white)] mb-3">Innovation & Expansion</h4>
                    <p class="text-[var(--gray-light)] font-light text-sm leading-relaxed">
                        Intégration de solutions de monitoring intelligent et d'automatisation avancée.
                        Vision d'expansion vers les marchés d'Afrique centrale.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     EXPERTISE (BARRES)
════════════════════════════════════════ --}}
<section class="py-20 bg-[var(--dark)] text-[var(--white)] transition-colors duration-300">
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="text-center mb-16">
            <div class="flex justify-center mb-4"><div class="badge-tag">Notre expertise</div></div>
            <h2 class="text-4xl md:text-5xl font-display tracking-wide">
                Des compétences <span class="text-[var(--orange)]">reconnues</span>
            </h2>
        </div>

        <div class="max-w-3xl mx-auto space-y-8">
            @foreach([
                ['name' => 'Installation Électrique', 'val' => 95],
                ['name' => 'Énergie Solaire', 'val' => 92],
                ['name' => 'Vidéosurveillance & Sécurité', 'val' => 90],
                ['name' => 'Réseaux & Télécommunications', 'val' => 88],
                ['name' => 'Maintenance IT & Biomédicale', 'val' => 85]
            ] as $skill)
            <div>
                <div class="flex justify-between items-end mb-2">
                    <h3 class="font-heading font-bold text-sm uppercase tracking-wide text-[var(--white)]">{{ $skill['name'] }}</h3>
                    <span class="font-display text-2xl text-[var(--orange)] leading-none">{{ $skill['val'] }}%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="{{ $skill['val'] }}" style="width:0%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     CTA FINAL
════════════════════════════════════════ --}}
<section class="cta-section py-24">
    <div class="container mx-auto px-6 relative z-10 text-center max-w-4xl">
        <h2 class="text-4xl md:text-5xl font-display text-[#000] mb-6 tracking-wide">
            Prêt à concrétiser votre projet ?
        </h2>
        <p class="text-lg md:text-xl font-light mb-10 text-[#000]/80">
            Contactez-nous dès aujourd'hui pour une consultation gratuite et découvrez comment
            POLAM SARL peut transformer vos ambitions technologiques en réalité.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}"
               class="bg-[#000] text-[var(--white)] px-10 py-5 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[var(--dark-2)] transition-all duration-300" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                Demander un devis
            </a>
            <a href="{{ route('service') }}"
               class="bg-transparent border border-[#000]/30 text-[#000] px-10 py-5 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[#000]/10 transition-all duration-300" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                Nos services
            </a>
        </div>
        <p class="mt-10 font-heading font-bold text-sm uppercase tracking-widest text-[#000]/60">
            Ligne directe : <a href="tel:+237698359954" class="text-[#000] hover:underline">+237 698 359 954</a>
        </p>
    </div>
</section>

<script>
    // ── Les scripts JS d'origine restent identiques, l'animation des stats et du scroll fonctionne parfaitement ──
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
            }
        });
    });

    function animateCounter(element) {
        const target  = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        const suffix = target === 360 ? '°' : (target === 100 ? '%' : '+');
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target + suffix;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current) + suffix;
            }
        }, 16);
    }

    const observerOptions = { threshold: 0.2, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('stat-number')) {
                    animateCounter(entry.target);
                }
                if (entry.target.classList.contains('expertise-fill')) {
                    const width = entry.target.getAttribute('data-width');
                    setTimeout(() => { entry.target.style.width = width + '%'; }, 200);
                }
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-number').forEach(el => observer.observe(el));
    document.querySelectorAll('.expertise-fill').forEach(el => observer.observe(el));

    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = entry.target.style.transform.includes('row')
                    ? 'translateY(0)' : 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.timeline-item').forEach((item, i) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(28px)';
        item.style.transition = `all 0.6s ease ${i * 0.12}s`;
        timelineObserver.observe(item);
    });

    const valueObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.value-card').forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(28px)';
        card.style.transition = `all 0.5s ease ${i * 0.1}s`;
        valueObserver.observe(card);
    });
</script>

@endsection

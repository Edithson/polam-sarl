@extends('home.index')

@section('content')

<style>
    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .about-hero {
        background: linear-gradient(135deg, #111111 0%, #1A1208 60%, #2A1A00 100%);
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(244,123,32,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(244,123,32,0.06) 1px, transparent 1px);
        background-size: 52px 52px;
    }

    .about-hero::after {
        content: '';
        position: absolute;
        top: -200px; right: -200px;
        width: 600px; height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(244,123,32,0.12) 0%, transparent 65%);
        pointer-events: none;
    }

    /* ══════════════════════════════════════
       BADGE TAG
    ══════════════════════════════════════ */
    .badge-tag {
        display: inline-flex; align-items: center; gap: 0.45rem;
        font-size: 0.72rem; font-weight: 700; letter-spacing: 0.13em;
        text-transform: uppercase; color: #F47B20;
        border: 1.5px solid rgba(244,123,32,0.35);
        border-radius: 50px; padding: 0.32rem 0.85rem;
        margin-bottom: 0.9rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.45rem; }

    /* ══════════════════════════════════════
       STAT COUNTER
    ══════════════════════════════════════ */
    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #F47B20, #FF9A45);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    @media (max-width: 768px) {
        .stat-number { font-size: 2.2rem; }
    }

    /* ══════════════════════════════════════
       VALUE CARDS
    ══════════════════════════════════════ */
    .value-card {
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .value-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 4px;
        background: linear-gradient(90deg, #F47B20, #FF9A45);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .value-card:hover {
        transform: translateY(-8px);
        border-color: rgba(244,123,32,0.3);
        box-shadow: 0 20px 48px rgba(244,123,32,0.12);
    }

    .value-card:hover::before { transform: scaleX(1); }

    .value-icon {
        width: 68px; height: 68px;
        background: rgba(244,123,32,0.12);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.9rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .value-card:hover .value-icon {
        transform: scale(1.1) rotate(-5deg);
        background: #F47B20;
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
        width: 3px; height: 100%;
        background: linear-gradient(180deg, #F47B20 0%, rgba(244,123,32,0.1) 100%);
        border-radius: 2px;
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
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        padding: 1.8rem 2rem;
        border-radius: 18px;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-content {
        transform: translateY(-6px);
        border-color: rgba(244,123,32,0.3);
        box-shadow: 0 16px 40px rgba(244,123,32,0.1);
    }

    .timeline-dot {
        width: 20px; height: 20px;
        background: #111111;
        border: 4px solid #F47B20;
        border-radius: 50%;
        position: absolute;
        left: 50%; transform: translateX(-50%);
        z-index: 10;
        transition: all 0.3s ease;
    }

    .timeline-item:nth-child(even) .timeline-dot {
        border-color: #FF9A45;
        background: #F47B20;
    }

    .timeline-item:hover .timeline-dot {
        transform: translateX(-50%) scale(1.5);
        box-shadow: 0 0 20px rgba(244,123,32,0.6);
    }

    .timeline-year-odd  { color: #F47B20; }
    .timeline-year-even { color: #FF9A45; }

    /* ══════════════════════════════════════
       EXPERTISE BARS
    ══════════════════════════════════════ */
    .expertise-bar {
        background: rgba(255,255,255,0.07);
        border-radius: 10px;
        height: 12px;
        overflow: hidden;
    }

    .expertise-fill {
        height: 100%;
        background: linear-gradient(90deg, #F47B20, #FF9A45);
        border-radius: 10px;
        transition: width 1.5s ease-in-out;
    }

    /* ══════════════════════════════════════
       MISSION VISUAL CARD
    ══════════════════════════════════════ */
    .mission-visual {
        background: linear-gradient(135deg, #1A1A1A, #242424);
        border: 1px solid rgba(244,123,32,0.18);
        border-radius: 24px;
        overflow: hidden;
    }

    /* ══════════════════════════════════════
       CTA
    ══════════════════════════════════════ */
    .cta-section {
        background: linear-gradient(135deg, #E8640A 0%, #C55E00 100%);
        position: relative; overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.055) 1px, transparent 1px);
        background-size: 44px 44px;
    }

    /* ══════════════════════════════════════
       BTN PRIMARY
    ══════════════════════════════════════ */
    .btn-primary {
        background: #F47B20;
        color: white;
        padding: 0.9rem 2.2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.92rem;
        transition: all 0.3s ease;
        display: inline-flex; align-items: center; gap: 0.4rem;
        text-decoration: none;
        box-shadow: 0 4px 18px rgba(244,123,32,0.35);
        letter-spacing: 0.02em;
    }

    .btn-primary:hover {
        background: #111111;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(244,123,32,0.3);
    }

    /* ══════════════════════════════════════
       STAT CARD
    ══════════════════════════════════════ */
    .stat-card {
        text-align: center;
        padding: 1.75rem 1rem;
        border-radius: 18px;
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.06);
        transition: border-color 0.3s, transform 0.3s;
    }
    .stat-card:hover {
        border-color: rgba(244,123,32,0.3);
        transform: translateY(-4px);
    }

    /* ══════════════════════════════════════
       TEAM CARD
    ══════════════════════════════════════ */
    .team-card {
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.35s ease;
    }

    .team-card:hover {
        border-color: rgba(244,123,32,0.35);
        transform: translateY(-6px);
        box-shadow: 0 20px 48px rgba(244,123,32,0.1);
    }

    .team-avatar {
        height: 180px;
        background: linear-gradient(135deg, #242424, #1A1A1A);
        display: flex; align-items: center; justify-content: center;
        font-size: 4rem;
        border-bottom: 1px solid rgba(244,123,32,0.12);
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
     HERO  — via include (remplace par le include d'origine si existant)
     Sinon : hero inline ci-dessous
════════════════════════════════════════ --}}
<section class="about-hero pt-36 pb-24 text-white">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <div class="badge-tag">À propos de nous</div>
            <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight" style="letter-spacing:-0.03em">
                La technologie et<br>
                <span style="color:#F47B20">l'innovation à votre portée</span>
            </h1>
            <p class="text-xl leading-relaxed max-w-2xl" style="color:rgba(255,255,255,0.62)">
                Depuis 2019, POLAM SARL accompagne particuliers, entreprises et institutions avec des solutions
                électriques, énergétiques et technologiques de qualité — conçues, installées et maintenues
                par une équipe jeune, qualifiée et engagée.
            </p>
            <div class="flex flex-wrap gap-4 mt-10">
                <a href="#mission" class="btn-primary">Notre mission →</a>
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-white/20
                          text-white/80 font-600 text-sm hover:border-[#F47B20] hover:text-[#F47B20]
                          transition-all duration-300">
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
    {{-- Deco SVG circuit --}}
    <div class="absolute bottom-0 right-0 opacity-5 pointer-events-none hidden lg:block" style="width:420px">
        <svg viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="200" cy="200" r="190" stroke="#F47B20" stroke-width="1.5"/>
            <circle cx="200" cy="200" r="120" stroke="#F47B20" stroke-width="1" stroke-dasharray="6 6"/>
            <line x1="200" y1="10" x2="200" y2="390" stroke="#F47B20" stroke-width="1"/>
            <line x1="10" y1="200" x2="390" y2="200" stroke="#F47B20" stroke-width="1"/>
            <circle cx="200" cy="10" r="5" fill="#F47B20"/>
            <circle cx="390" cy="200" r="5" fill="#F47B20"/>
            <path d="M200 80 L300 140 L300 200 L360 200" stroke="#F47B20" stroke-width="1.5"/>
            <circle cx="360" cy="200" r="7" fill="none" stroke="#F47B20" stroke-width="2"/>
            <circle cx="200" cy="200" r="18" fill="#F47B20" fill-opacity="0.2" stroke="#F47B20" stroke-width="2"/>
            <circle cx="200" cy="200" r="6" fill="#F47B20"/>
        </svg>
    </div>
</section>

{{-- ════════════════════════════════════════
     QUI SOMMES-NOUS + STATS
════════════════════════════════════════ --}}
<section class="py-20 bg-[#111111] text-white">
    <div class="container mx-auto px-6">

        {{-- Intro --}}
        <div class="max-w-4xl mx-auto mb-16">
            <div class="badge-tag mx-auto" style="margin-bottom:1.2rem">Qui sommes-nous ?</div>
            <h2 class="text-3xl md:text-4xl font-bold mb-8 text-center" style="letter-spacing:-0.025em">
                Une entreprise camerounaise au cœur de la <span style="color:#F47B20">technologie</span>
            </h2>
            <div class="space-y-5 text-lg leading-relaxed" style="color:rgba(255,255,255,0.6)">
                <p>
                    <strong style="color:#F47B20">POLAM SARL</strong> est une entreprise spécialisée dans l'étude,
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
                    <strong style="color:#F47B20">installation électrique</strong>,
                    <strong style="color:#F47B20">énergie solaire</strong>,
                    <strong style="color:#F47B20">vidéosurveillance & alarme</strong>,
                    <strong style="color:#F47B20">réseaux & télécommunications</strong>,
                    <strong style="color:#F47B20">maintenance & biomédical</strong>,
                    et <strong style="color:#F47B20">commerce général / import-export</strong> —
                    garantissant une approche intégrée et cohérente pour chaque client.
                </p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div class="stat-card">
                <div class="stat-number" data-target="5">0</div>
                <p class="font-semibold mt-2 text-sm uppercase tracking-wider" style="color:rgba(255,255,255,0.5)">Années d'Expérience</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="6">0</div>
                <p class="font-semibold mt-2 text-sm uppercase tracking-wider" style="color:rgba(255,255,255,0.5)">Pôles de Services</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="100">0</div>
                <p class="font-semibold mt-2 text-sm uppercase tracking-wider" style="color:rgba(255,255,255,0.5)">% Engagement Client</p>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-target="360">0</div>
                <p class="font-semibold mt-2 text-sm uppercase tracking-wider" style="color:rgba(255,255,255,0.5)">° Accompagnement</p>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     MISSION & VISION
════════════════════════════════════════ --}}
<section id="mission" class="py-20 bg-[#0D0D0D] text-white">
    <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">
            <div class="order-2 lg:order-1">
                <div class="badge-tag">Notre mission</div>
                <h2 class="text-3xl md:text-4xl font-bold mb-6" style="letter-spacing:-0.025em">
                    Rendre la technologie <span style="color:#F47B20">accessible à tous</span>
                </h2>
                <p class="text-lg leading-relaxed mb-5" style="color:rgba(255,255,255,0.6)">
                    <strong style="color:#F47B20">POLAM SARL</strong> s'engage à transformer vos projets
                    technologiques en réalités fiables et durables — en combinant expertise technique,
                    réactivité terrain et solutions sur mesure adaptées au contexte camerounais.
                </p>
                <p class="text-lg leading-relaxed mb-8" style="color:rgba(255,255,255,0.6)">
                    Nous accompagnons chaque client — particulier, PME ou grande institution — avec la même
                    rigueur et le même engagement, de la conception à la livraison clé en main.
                </p>

                {{-- Vision --}}
                <div class="p-5 rounded-2xl mb-6"
                     style="background:rgba(244,123,32,0.08);border:1px solid rgba(244,123,32,0.2)">
                    <div class="flex items-start gap-3">
                        <span style="font-size:1.5rem;flex-shrink:0">🔭</span>
                        <div>
                            <h4 class="font-bold text-white mb-1">Notre Vision</h4>
                            <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.55)">
                                Devenir la référence incontournable en solutions électriques et technologiques
                                au Cameroun, reconnue pour la qualité, l'innovation et la proximité client.
                            </p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="btn-primary">Démarrer un projet →</a>
            </div>

            <div class="order-1 lg:order-2">
                <div class="mission-visual w-full h-96 flex items-center justify-center p-4 shadow-2xl">
                    {{-- Remplacer par : <img class="w-full h-full rounded-2xl object-cover" src="{{ asset('media/img/about/mission.jpg') }}" alt="Mission POLAM SARL"> --}}
                    <div class="text-center">
                        <div class="text-8xl mb-4">⚡</div>
                        <p class="font-bold text-lg" style="color:#F47B20;letter-spacing:0.08em;text-transform:uppercase">POLAM SARL</p>
                        <p class="text-sm mt-1" style="color:rgba(255,255,255,0.35)">La technologie et l'innovation à votre portée</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     NOS VALEURS
════════════════════════════════════════ --}}
<section class="py-20 bg-[#111111] text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <div class="badge-tag mx-auto">Nos valeurs</div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2" style="letter-spacing:-0.03em">
                Ce qui nous <span style="color:#F47B20">anime</span>
            </h2>
            <p class="text-lg mt-4 max-w-2xl mx-auto" style="color:rgba(255,255,255,0.5)">
                Les principes qui guident chacune de nos interventions au quotidien
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3 class="text-xl font-bold text-white mb-3">Excellence</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
                    Chaque installation, chaque intervention reflète notre exigence de qualité supérieure.
                    Nous ne livrons pas un projet tant que les standards ne sont pas atteints.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3 class="text-xl font-bold text-white mb-3">Engagement Client</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
                    Votre satisfaction est notre mesure de succès. Nous construisons des relations durables
                    basées sur la confiance, l'écoute et l'accompagnement personnalisé.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3 class="text-xl font-bold text-white mb-3">Fiabilité</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
                    Nos installations sont conçues pour durer. Nous travaillons avec des équipements
                    certifiés et respectons scrupuleusement les normes techniques en vigueur.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3 class="text-xl font-bold text-white mb-3">Innovation</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
                    Nous intégrons les technologies les plus récentes — domotique, énergie solaire,
                    réseaux intelligents — pour proposer des solutions toujours en avance.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">🇨🇲</div>
                <h3 class="text-xl font-bold text-white mb-3">Ancrage Local</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
                    Enracinés au Cameroun, nous comprenons les réalités du terrain local et adaptons
                    chaque solution aux contraintes et opportunités spécifiques du marché africain.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">⚖️</div>
                <h3 class="text-xl font-bold text-white mb-3">Intégrité</h3>
                <p class="leading-relaxed text-sm" style="color:rgba(255,255,255,0.55)">
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
<section class="py-20 bg-[#0D0D0D] text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <div class="badge-tag mx-auto">Notre histoire</div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2" style="letter-spacing:-0.03em">
                Un parcours <span style="color:#F47B20">marqué</span> par la croissance
            </h2>
            <p class="text-lg mt-4 max-w-2xl mx-auto" style="color:rgba(255,255,255,0.5)">
                De la création à aujourd'hui, une trajectoire portée par l'ambition et l'innovation
            </p>
        </div>

        <div class="timeline max-w-5xl mx-auto">

            {{-- 2019 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-odd">2019</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Création de POLAM SARL</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        Lancement des activités à Yaoundé avec une vision claire : rendre la technologie
                        accessible à tous. Premiers contrats en installation électrique résidentielle
                        et fourniture de matériel électronique.
                    </p>
                </div>
            </div>

            {{-- 2020 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-even">2020</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Élargissement du portefeuille</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        Extension aux installations d'énergie solaire et aux systèmes de vidéosurveillance.
                        Premiers contrats tertiaires avec des PME locales. Démarrage de l'activité
                        import-export de matériel technologique.
                    </p>
                </div>
            </div>

            {{-- 2021 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-odd">2021</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Réseaux & Domotique</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        Intégration des solutions réseaux et télécommunications ainsi que de la domotique
                        résidentielle. L'équipe s'agrandit avec des techniciens spécialisés en
                        infrastructure réseau et systèmes intelligents.
                    </p>
                </div>
            </div>

            {{-- 2022 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-even">2022</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Pôle Biomédical & Informatique</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        Lancement du service de maintenance des équipements biomédicaux et informatiques.
                        Partenariats avec des établissements de santé et des institutions publiques.
                        Consolidation de la présence sur Yaoundé et Douala.
                    </p>
                </div>
            </div>

            {{-- 2023 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-odd">2023</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Consolidation & Croissance</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        POLAM SARL s'affirme comme un acteur incontournable du secteur technologique
                        au Cameroun. Portfolio complet de 6 pôles de services, clients dans le
                        résidentiel, le tertiaire, la santé et les institutions.
                    </p>
                </div>
            </div>

            {{-- 2025 --}}
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3 class="text-2xl font-bold mb-2 timeline-year-even">2025 & au-delà</h3>
                    <h4 class="text-lg font-semibold text-white mb-3">Innovation & Expansion</h4>
                    <p style="color:rgba(255,255,255,0.55);font-size:0.92rem;line-height:1.65">
                        Intégration de solutions de monitoring intelligent et d'automatisation avancée.
                        Vision d'expansion vers d'autres villes du Cameroun et ouverture vers les
                        marchés d'Afrique centrale.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     EXPERTISE (BARRES)
════════════════════════════════════════ --}}
<section class="py-20 bg-[#111111] text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <div class="badge-tag mx-auto">Notre expertise</div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2" style="letter-spacing:-0.03em">
                Des compétences <span style="color:#F47B20">reconnues</span>
            </h2>
            <p class="text-lg mt-4 max-w-2xl mx-auto" style="color:rgba(255,255,255,0.5)">
                Un niveau de maîtrise technique élevé dans chacun de nos domaines d'intervention
            </p>
        </div>

        <div class="max-w-4xl mx-auto space-y-8">
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Installation Électrique</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">95%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="95" style="width:0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Énergie Solaire & Renouvelable</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">92%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="92" style="width:0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Vidéosurveillance & Sécurité</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">90%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="90" style="width:0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Réseaux & Télécommunications</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">88%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="88" style="width:0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Maintenance & Biomédical</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">85%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="85" style="width:0%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-white">Domotique & Automatisation</h3>
                    <span class="font-bold text-lg" style="color:#F47B20">82%</span>
                </div>
                <div class="expertise-bar">
                    <div class="expertise-fill" data-width="82" style="width:0%"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     ÉQUIPE
════════════════════════════════════════ --}}
<section class="py-20 bg-[#0D0D0D] text-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <div class="badge-tag mx-auto">L'équipe</div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2" style="letter-spacing:-0.03em">
                Des talents <span style="color:#F47B20">engagés</span>
            </h2>
            <p class="text-lg mt-4 max-w-xl mx-auto" style="color:rgba(255,255,255,0.5)">
                Une équipe jeune, formée et passionnée par la technologie et l'innovation
            </p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="team-card">
                <div class="team-avatar">👨‍💼</div>
                <div class="p-5">
                    <h4 class="font-bold text-white text-lg mb-1">Direction Générale</h4>
                    <p class="text-xs uppercase tracking-widest mb-3" style="color:#F47B20;letter-spacing:0.1em">Management</p>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5)">Pilotage stratégique et développement commercial de l'entreprise.</p>
                </div>
            </div>
            <div class="team-card">
                <div class="team-avatar">👨‍🔧</div>
                <div class="p-5">
                    <h4 class="font-bold text-white text-lg mb-1">Techniciens Électriciens</h4>
                    <p class="text-xs uppercase tracking-widest mb-3" style="color:#F47B20;letter-spacing:0.1em">Installation & Maintenance</p>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5)">Spécialistes certifiés en installation et mise en conformité électrique.</p>
                </div>
            </div>
            <div class="team-card">
                <div class="team-avatar">☀️</div>
                <div class="p-5">
                    <h4 class="font-bold text-white text-lg mb-1">Équipe Énergie Solaire</h4>
                    <p class="text-xs uppercase tracking-widest mb-3" style="color:#F47B20;letter-spacing:0.1em">Énergie Renouvelable</p>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5)">Experts en dimensionnement et déploiement de systèmes photovoltaïques.</p>
                </div>
            </div>
            <div class="team-card">
                <div class="team-avatar">🌐</div>
                <div class="p-5">
                    <h4 class="font-bold text-white text-lg mb-1">Techniciens Réseaux</h4>
                    <p class="text-xs uppercase tracking-widest mb-3" style="color:#F47B20;letter-spacing:0.1em">Télécoms & Sécurité</p>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5)">Spécialistes des infrastructures réseau, vidéosurveillance et contrôle d'accès.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════
     CTA FINAL
════════════════════════════════════════ --}}
<section class="cta-section py-24">
    <div class="container mx-auto px-6 relative z-10 text-center">
        <h2 class="text-4xl md:text-5xl font-black mb-5 text-white" style="letter-spacing:-0.03em">
            Prêt à concrétiser votre projet ?
        </h2>
        <p class="text-xl mb-10 max-w-2xl mx-auto" style="color:rgba(255,255,255,0.82)">
            Contactez-nous dès aujourd'hui pour une consultation gratuite et découvrez comment
            POLAM SARL peut transformer vos ambitions technologiques en réalité.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}"
               class="bg-white text-[#E8640A] px-10 py-4 rounded-full font-bold text-lg
                      hover:bg-[#111] hover:text-white transition-all duration-300 inline-block shadow-xl">
                Demander un devis gratuit
            </a>
            <a href="{{ route('service') }}"
               class="bg-transparent border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg
                      hover:bg-white hover:text-[#E8640A] transition-all duration-300 inline-block">
                Voir nos services
            </a>
        </div>
        <p class="mt-8 text-sm" style="color:rgba(255,255,255,0.6)">
            Ou appelez-nous directement :
            <a href="tel:+237699070353" class="underline hover:text-white transition-colors font-semibold">
                +237 699 070 353
            </a>
            /
            <a href="tel:+237674180413" class="underline hover:text-white transition-colors font-semibold">
                +237 674 180 413
            </a>
        </p>
    </div>
</section>

<script>
    // ── Smooth scroll
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

    // ── Animated counter
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

    // ── Intersection Observer global
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

    // ── Timeline reveal
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

    // ── Value cards reveal
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

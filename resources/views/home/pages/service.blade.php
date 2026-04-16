@extends('home.index')

@section('content')

    <style>
        /* ── Animations reveal ── */
        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease-out;
        }
        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease-out;
        }
        .reveal.active .reveal-left,
        .reveal.active .reveal-right {
            opacity: 1;
            transform: translateX(0);
        }

        /* ── Hero deco ── */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        /* ── Circuit grid bg ── */
        .circuit-bg {
            background-image:
                linear-gradient(color-mix(in srgb, var(--orange) 7%, transparent) 1px, transparent 1px),
                linear-gradient(90deg, color-mix(in srgb, var(--orange) 7%, transparent) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* ── Check icon orange ── */
        .check-icon {
            flex-shrink: 0;
            width: 28px; height: 28px;
            background: color-mix(in srgb, var(--orange) 15%, transparent);
            border: 1px solid color-mix(in srgb, var(--orange) 30%, transparent);
            display: flex; align-items: center; justify-content: center;
        }
        .check-icon svg { width: 14px; height: 14px; color: var(--orange); }

        /* ── Service detail item ── */
        .svc-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid color-mix(in srgb, var(--white) 6%, transparent);
        }
        .svc-item:last-child { border-bottom: none; }
        .svc-item span { font-size: 0.92rem; color: var(--gray-light); line-height: 1.5; font-weight: 300; }

        /* ── Feature card ── */
        .feature-card {
            background: var(--dark-3);
            border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
            border-radius: 4px;
            padding: 2rem;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            border-color: color-mix(in srgb, var(--orange) 50%, transparent);
            transform: translateY(-4px);
            box-shadow: 0 16px 48px color-mix(in srgb, var(--orange) 12%, transparent);
        }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 4px;
            background: color-mix(in srgb, var(--orange) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--orange) 20%, transparent);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            color: var(--orange);
        }

        /* ── Conseil item ── */
        .conseil-item {
            display: flex;
            padding: 1.1rem 1.25rem;
            background: var(--dark-3);
            border-radius: 4px;
            border-left: 4px solid var(--orange);
            gap: 1rem;
            align-items: flex-start;
        }
        .conseil-item-icon {
            font-size: 1.5rem; flex-shrink: 0; margin-top: 0.1rem;
        }

        /* ── Stat card ── */
        .stat-card-orange {
            background: var(--orange);
            border-radius: 4px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 2rem;
            min-height: 200px;
            color: #000;
        }
        .stat-card-dark {
            background: var(--dark-3);
            border: 1px solid color-mix(in srgb, var(--white) 8%, transparent);
            border-radius: 4px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 2rem;
            min-height: 200px;
            margin-top: 2rem;
        }

        /* ── Fournitures icons ── */
        .supply-card {
            display: flex; flex-direction: column; align-items: center;
            gap: 0.75rem; cursor: default;
        }
        .supply-icon {
            width: 80px; height: 80px; border-radius: 4px;
            background: var(--dark-3); border: 1px solid color-mix(in srgb, var(--white) 8%, transparent);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            transition: background 0.3s, border-color 0.3s, transform 0.3s;
        }
        .supply-card:hover .supply-icon {
            background: color-mix(in srgb, var(--orange) 10%, transparent);
            border-color: var(--orange);
            transform: scale(1.08);
        }
        .supply-card h4 { font-family: 'Syne', sans-serif; font-size: 0.85rem; font-weight: 700; color: var(--white); text-align: center; text-transform: uppercase; }

        /* ── CTA section ── */
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
            background-size: 40px 40px;
        }

        /* ── Orange badge tag ── */
        .badge-tag {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-family: 'Syne', sans-serif;
            font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--orange);
            border: 1px solid color-mix(in srgb, var(--orange) 35%, transparent);
            background: color-mix(in srgb, var(--orange) 5%, transparent);
            padding: 0.3rem 0.85rem;
            margin-bottom: 0.75rem; width: fit-content;
        }
        .badge-tag::before { content: '●'; font-size: 0.45rem; }

        /* ── Visual deco circle ── */
        .deco-circle-orange {
            position: absolute; width: 96px; height: 96px; border-radius: 50%;
            background: color-mix(in srgb, var(--orange) 15%, transparent); z-index: 0;
        }
        .deco-circle-dark {
            position: absolute; width: 96px; height: 96px; border-radius: 50%;
            background: color-mix(in srgb, var(--white) 5%, transparent); z-index: 0;
        }

        /* ── Tech Button ── */
        .btn-tech {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.8rem 1.8rem;
            border: 1px solid color-mix(in srgb, var(--white) 15%, transparent);
            color: var(--white);
            transition: all 0.3s;
            clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
            display: inline-block;
        }
        .btn-tech:hover {
            border-color: var(--orange);
            color: var(--orange);
            background: color-mix(in srgb, var(--orange) 5%, transparent);
        }
    </style>

    <div class="bg-[var(--dark)] text-[var(--white)] transition-colors duration-300">

        {{-- ════════════════════════════════════════
             HERO BANNER
        ════════════════════════════════════════ --}}
        <section class="relative pt-32 pb-20 overflow-hidden circuit-bg border-b border-[color-mix(in_srgb,var(--orange)_15%,transparent)]">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-[var(--orange)]/5 skew-x-12 translate-x-32 hidden md:block"></div>
            <div class="absolute top-0 left-0 w-full h-full"
                 style="background: radial-gradient(ellipse 70% 70% at 20% 50%, color-mix(in srgb, var(--orange) 7%, transparent) 0%, transparent 70%)">
            </div>
            <div class="container mx-auto px-6 max-w-7xl relative z-10">
                <div class="max-w-3xl">
                    <div class="badge-tag mb-4">Nos domaines d'intervention</div>
                    <h1 class="text-5xl md:text-6xl font-display mb-6 leading-tight tracking-wide">
                        Expertise Complète en<br>
                        <span class="text-[var(--orange)]">Technologies & Énergie</span>
                    </h1>
                    <p class="text-lg md:text-xl font-light leading-relaxed text-[var(--gray-light)]">
                        De l'étude initiale à la maintenance, POLAM SARL vous accompagne dans chaque projet
                        électrique, technologique et énergétique avec rigueur et professionnalisme.
                    </p>
                    <div class="flex flex-wrap gap-3 mt-8">
                        <a href="#electrique" class="btn-tech">Installation Électrique</a>
                        <a href="#solaire" class="btn-tech">Énergie Solaire</a>
                        <a href="#securite" class="btn-tech">Sécurité & Alarme</a>
                        <a href="#maintenance" class="btn-tech">Maintenance</a>
                    </div>
                </div>
            </div>
            {{-- Hero visual deco --}}
            <div class="w-1/3 h-80 absolute top-28 right-6 overflow-hidden shadow-2xl hidden lg:block animate-float"
                 style="border:1px solid color-mix(in srgb, var(--orange) 20%, transparent); clip-path: polygon(20px 0%, 100% 0%, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0% 100%, 0% 20px);">
                <div class="w-full h-full flex items-center justify-center bg-[var(--dark-3)]">
                    <div class="text-center p-6">
                        <div class="text-6xl text-[var(--orange)]">⚡</div>
                        <p class="text-sm mt-4 font-heading font-bold uppercase tracking-widest text-[var(--white)]">POLAM SARL</p>
                        <p class="text-xs mt-1 text-[var(--gray)]">La technologie à votre portée</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             SERVICE 1 — Installation Électrique
        ════════════════════════════════════════ --}}
        <div class="space-y-0">
            <section id="electrique" class="reveal py-16 lg:py-24 overflow-hidden bg-[var(--dark)]">
                <div class="container mx-auto px-6 max-w-7xl">
                    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="relative">
                                <div class="deco-circle-orange -top-4 -left-4"></div>
                                <div class="relative z-10 h-[420px] w-full flex items-center justify-center bg-[var(--dark-2)]"
                                     style="border:1px solid color-mix(in srgb, var(--orange) 18%, transparent); clip-path: polygon(20px 0%, 100% 0%, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0% 100%, 0% 20px);">
                                    <div class="text-center">
                                        <div class="text-6xl text-[var(--orange)]">⚡</div>
                                        <p class="mt-4 font-heading font-bold text-sm text-[var(--white)] tracking-widest uppercase">Installation Électrique</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="badge-tag">Service Principal</div>
                            <h2 class="text-3xl md:text-4xl font-display tracking-wide mt-2 mb-5">
                                Installation Électrique Domestique & Tertiaire
                            </h2>
                            <p class="mb-8 text-lg font-light leading-relaxed text-[var(--gray-light)]">
                                POLAM SARL assure l'étude, la conception et la mise en œuvre de tous vos projets
                                d'installation électrique — du logement individuel aux bâtiments tertiaires et industriels,
                                dans le strict respect des normes en vigueur.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Étude et conception de plans électriques aux normes</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Câblage, pose de tableaux électriques et appareillage</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Mise en conformité des installations existantes</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Installation domotique et gestion intelligente de l'énergie</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 2 — Énergie Solaire
            ════════════════════════════════════════ --}}
            <section id="solaire" class="reveal py-16 lg:py-24 overflow-hidden bg-[var(--dark-2)]">
                <div class="container mx-auto px-6 max-w-7xl">
                    <div class="flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="relative">
                                <div class="deco-circle-dark -bottom-4 -right-4"></div>
                                <div class="relative z-10 h-[420px] w-full flex items-center justify-center bg-[var(--dark-3)]"
                                     style="border:1px solid color-mix(in srgb, var(--orange) 18%, transparent); clip-path: polygon(0% 0%, calc(100% - 20px) 0%, 100% 20px, 100% 100%, 20px 100%, 0% calc(100% - 20px));">
                                    <div class="text-center">
                                        <div class="text-6xl text-[var(--orange)]">☀️</div>
                                        <p class="mt-4 font-heading font-bold text-sm text-[var(--white)] tracking-widest uppercase">Énergie Solaire</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="badge-tag">Énergie Renouvelable</div>
                            <h2 class="text-3xl md:text-4xl font-display tracking-wide mt-2 mb-5">
                                Énergie Solaire & Systèmes Photovoltaïques
                            </h2>
                            <p class="mb-8 text-lg font-light leading-relaxed text-[var(--gray-light)]">
                                Réduisez votre facture énergétique et gagnez en autonomie grâce à nos solutions solaires
                                sur mesure — dimensionnées, installées et maintenues par nos techniciens certifiés.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Étude de faisabilité et dimensionnement des installations solaires</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Pose de panneaux photovoltaïques et onduleurs</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Installation de systèmes de stockage et de batteries</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Systèmes hybrides solaire + réseau pour continuité électrique</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 3 — Vidéosurveillance & Alarme
            ════════════════════════════════════════ --}}
            <section id="securite" class="reveal py-16 lg:py-24 overflow-hidden bg-[var(--dark)]">
                <div class="container mx-auto px-6 max-w-7xl">
                    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="relative">
                                <div class="deco-circle-orange -top-4 -left-4"></div>
                                <div class="relative z-10 h-[420px] w-full flex items-center justify-center bg-[var(--dark-2)]"
                                     style="border:1px solid color-mix(in srgb, var(--orange) 18%, transparent); clip-path: polygon(20px 0%, 100% 0%, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0% 100%, 0% 20px);">
                                    <div class="text-center">
                                        <div class="text-6xl text-[var(--orange)]">📷</div>
                                        <p class="mt-4 font-heading font-bold text-sm text-[var(--white)] tracking-widest uppercase">Sécurité & Accès</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="badge-tag">Sécurité</div>
                            <h2 class="text-3xl md:text-4xl font-display tracking-wide mt-2 mb-5">
                                Vidéosurveillance, Alarme & Contrôle d'Accès
                            </h2>
                            <p class="mb-8 text-lg font-light leading-relaxed text-[var(--gray-light)]">
                                Protégez vos biens, vos locaux et vos collaborateurs grâce à nos systèmes de sécurité
                                intégrés — vidéosurveillance HD, alarmes techniques et contrôle d'accès biométrique.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Installation de caméras IP et systèmes CCTV HD / 4K</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Systèmes d'alarme intrusion et détection incendie</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Contrôle d'accès par badge, biométrie ou code</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 4 — Réseaux & Télécoms
            ════════════════════════════════════════ --}}
            <section id="reseaux" class="reveal py-16 lg:py-24 overflow-hidden bg-[var(--dark-2)]">
                <div class="container mx-auto px-6 max-w-7xl">
                    <div class="flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="relative">
                                <div class="deco-circle-dark -bottom-4 -right-4"></div>
                                <div class="relative z-10 h-[420px] w-full flex items-center justify-center bg-[var(--dark-3)]"
                                     style="border:1px solid color-mix(in srgb, var(--orange) 18%, transparent); clip-path: polygon(0% 0%, calc(100% - 20px) 0%, 100% 20px, 100% 100%, 20px 100%, 0% calc(100% - 20px));">
                                    <div class="text-center">
                                        <div class="text-6xl text-[var(--orange)]">🌐</div>
                                        <p class="mt-4 font-heading font-bold text-sm text-[var(--white)] tracking-widest uppercase">Réseaux & Télécoms</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="badge-tag">Télécommunications</div>
                            <h2 class="text-3xl md:text-4xl font-display tracking-wide mt-2 mb-5">
                                Réseaux & Télécommunications
                            </h2>
                            <p class="mb-8 text-lg font-light leading-relaxed text-[var(--gray-light)]">
                                Connectez votre organisation avec des infrastructures réseau robustes et évolutives.
                                De la fibre optique au Wi-Fi professionnel, nous concevons des solutions sur mesure.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Câblage structuré RJ45, fibre optique et baie de brassage</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Déploiement de réseaux Wi-Fi professionnel (indoor/outdoor)</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>
                                    <span>Configuration de routeurs, switches et VPN sécurisés</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- ════════════════════════════════════════
             SECTION — Maintenance & Biomédical
        ════════════════════════════════════════ --}}
        <section id="maintenance" class="py-24 bg-[var(--dark)]">
            <div class="container mx-auto px-6 max-w-7xl">
                <div class="text-center mb-16">
                    <div class="flex justify-center"><div class="badge-tag mb-4">Support Technique</div></div>
                    <h2 class="text-4xl md:text-5xl font-display tracking-wide">
                        Maintenance, Dépannage &
                        <span class="text-[var(--orange)]">Biomédical</span>
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg font-light text-[var(--gray-light)]">
                        Disponibles et réactifs pour assurer la continuité de vos équipements électroniques,
                        informatiques et biomédicaux.
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-[var(--white)] text-lg mb-3 uppercase tracking-wide">Dépannage Électronique</h3>
                        <p class="font-light text-[var(--gray-light)] text-sm leading-relaxed">
                            Diagnostic et réparation rapide d'équipements électroniques défaillants — onduleurs,
                            tableaux électriques, appareils connectés et automates.
                        </p>
                    </div>
                    <div class="feature-card" style="border-color:color-mix(in srgb, var(--orange) 40%, transparent)">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-[var(--white)] text-lg mb-3 uppercase tracking-wide">Équipements Biomédicaux</h3>
                        <p class="font-light text-[var(--gray-light)] text-sm leading-relaxed">
                            Maintenance préventive et corrective des équipements médicaux électroniques —
                            moniteurs, générateurs, appareils de diagnostic et matériel hospitalier.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-[var(--white)] text-lg mb-3 uppercase tracking-wide">Maintenance Informatique</h3>
                        <p class="font-light text-[var(--gray-light)] text-sm leading-relaxed">
                            Installation, configuration et maintenance de parcs informatiques, serveurs,
                            postes de travail et périphériques pour particuliers et entreprises.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             SECTION — Commerce & Import-Export
        ════════════════════════════════════════ --}}
        <section id="commerce" class="py-24 bg-[var(--dark-2)]">
            <div class="container mx-auto px-6 max-w-7xl">
                <div class="flex flex-col lg:flex-row gap-12 items-center">
                    <div class="lg:w-1/2">
                        <div class="badge-tag">Commerce & Import-Export</div>
                        <h2 class="text-4xl md:text-5xl font-display tracking-wide mb-5 mt-2">
                            Commerce Général &
                            <span class="text-[var(--orange)]">Import-Export</span>
                        </h2>
                        <p class="mb-8 text-lg font-light leading-relaxed text-[var(--gray-light)]">
                            En tant qu'acteur du commerce général, POLAM SARL vous donne accès à du matériel
                            électrique, électronique et technologique de qualité internationale à des tarifs compétitifs.
                        </p>
                        <div class="space-y-4">
                            <div class="conseil-item">
                                <div class="conseil-item-icon">📦</div>
                                <div>
                                    <h4 class="font-heading font-bold text-[var(--white)] uppercase tracking-wide text-sm">Fourniture de matériel électrique</h4>
                                    <p class="text-sm mt-1 font-light text-[var(--gray-light)]">Câbles, tableaux, disjoncteurs, prises, luminaires et équipements de marques reconnues.</p>
                                </div>
                            </div>
                            <div class="conseil-item">
                                <div class="conseil-item-icon">🌍</div>
                                <div>
                                    <h4 class="font-heading font-bold text-[var(--white)] uppercase tracking-wide text-sm">Import de matériel technologique</h4>
                                    <p class="text-sm mt-1 font-light text-[var(--gray-light)]">Panneaux solaires, caméras, équipements réseau et biomédicaux importés directement à moindre coût.</p>
                                </div>
                            </div>
                            <div class="conseil-item">
                                <div class="conseil-item-icon">🤝</div>
                                <div>
                                    <h4 class="font-heading font-bold text-[var(--white)] uppercase tracking-wide text-sm">Prestation de services clé en main</h4>
                                    <p class="text-sm mt-1 font-light text-[var(--gray-light)]">Accompagnement de bout en bout : achat, livraison, installation et mise en service.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                        <div class="stat-card-orange">
                            <span class="font-display text-6xl mb-2">5+</span>
                            <span class="font-heading font-bold text-xs uppercase tracking-widest text-[#000]/80">Ans d'Expertise</span>
                        </div>
                        <div class="stat-card-dark">
                            <span class="font-display text-6xl mb-2 text-[var(--orange)]">6</span>
                            <span class="font-heading font-bold text-xs uppercase tracking-widest text-[var(--gray)]">Pôles de Services</span>
                        </div>
                        <div class="stat-card-dark" style="margin-top:0">
                            <span class="font-display text-6xl mb-2 text-[var(--orange)]">360°</span>
                            <span class="font-heading font-bold text-xs uppercase tracking-widest text-[var(--gray)]">Accompagnement</span>
                        </div>
                        <div class="stat-card-orange" style="margin-top:0">
                            <span class="font-display text-6xl mb-2">100%</span>
                            <span class="font-heading font-bold text-xs uppercase tracking-widest text-[#000]/80">Engagement Client</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             MATÉRIEL & FOURNITURES
        ════════════════════════════════════════ --}}
        <section class="py-24 bg-[var(--dark)]">
            <div class="container mx-auto px-6 max-w-7xl text-center">
                <div class="flex justify-center"><div class="badge-tag mb-4">Matériel</div></div>
                <h2 class="text-4xl md:text-5xl font-display tracking-wide mb-4">Matériel & Équipements Fournis</h2>
                <p class="text-lg font-light mb-14 max-w-2xl mx-auto text-[var(--gray-light)]">Nous fournissons et installons des équipements de qualité issus des meilleures marques du marché.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="supply-card">
                        <div class="supply-icon">⚡</div>
                        <h4>Tableaux Électriques</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">☀️</div>
                        <h4>Panneaux Solaires</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">📷</div>
                        <h4>Caméras & DVR</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">🌐</div>
                        <h4>Équipements Réseau</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">🔋</div>
                        <h4>Batteries & Onduleurs</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">🏠</div>
                        <h4>Domotique</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">🔒</div>
                        <h4>Contrôle d'Accès</h4>
                    </div>
                    <div class="supply-card">
                        <div class="supply-icon">💻</div>
                        <h4>Matériel Informatique</h4>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             CTA FINAL
        ════════════════════════════════════════ --}}
        <section class="cta-section py-24">
            <div class="container mx-auto px-6 max-w-4xl relative z-10 text-center">
                <h2 class="text-4xl md:text-5xl font-display text-[#000] tracking-wide mb-6">
                    Prêt à lancer votre projet ?
                </h2>
                <p class="text-lg font-light mb-10 text-[#000]/80">
                    Contactez-nous pour une étude gratuite et un devis personnalisé adapté à vos besoins.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="bg-[#000] text-[var(--white)] px-10 py-5 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[var(--dark-2)] transition-all duration-300" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                        Demander un devis
                    </a>
                    <a href="tel:+237699070353"
                       class="bg-transparent border border-[#000]/30 text-[#000] px-10 py-5 font-heading font-bold text-sm uppercase tracking-widest hover:bg-[#000]/10 transition-all duration-300" style="clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);">
                        📞 699 070 353
                    </a>
                </div>
                <p class="mt-10 font-heading font-bold text-sm uppercase tracking-widest text-[#000]/60">
                    Ou écrivez-nous à
                    <a href="mailto:polamsarl@gmail.com" class="text-[#000] hover:underline">polamsarl@gmail.com</a>
                </p>
            </div>
        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = { threshold: 0.12 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);
            document.querySelectorAll('.reveal').forEach(section => observer.observe(section));
        });
    </script>

@endsection

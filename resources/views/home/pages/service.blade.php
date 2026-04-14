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
                linear-gradient(rgba(244,123,32,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(244,123,32,0.07) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        /* ── Check icon orange ── */
        .check-icon {
            flex-shrink: 0;
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(244,123,32,0.15);
            display: flex; align-items: center; justify-content: center;
        }
        .check-icon svg { width: 14px; height: 14px; color: #F47B20; }

        /* ── Service detail item ── */
        .svc-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .svc-item:last-child { border-bottom: none; }
        .svc-item span { font-size: 0.92rem; color: rgba(255,255,255,0.75); line-height: 1.5; }

        /* ── Alternating section bg ── */
        .section-alt { background: rgba(255,255,255,0.02); }

        /* ── Feature card ── */
        .feature-card {
            background: #1A1A1A;
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            border-color: rgba(244,123,32,0.5);
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(244,123,32,0.12);
        }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 14px;
            background: rgba(244,123,32,0.12);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
        }

        /* ── Conseil item ── */
        .conseil-item {
            display: flex;
            padding: 1.1rem 1.25rem;
            background: #1A1A1A;
            border-radius: 1rem;
            border-left: 4px solid #F47B20;
            gap: 1rem;
            align-items: flex-start;
        }
        .conseil-item-icon {
            font-size: 1.5rem; flex-shrink: 0; margin-top: 0.1rem;
        }

        /* ── Stat card ── */
        .stat-card-orange {
            background: #F47B20;
            border-radius: 1.5rem;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center; padding: 2rem;
            min-height: 200px;
        }
        .stat-card-dark {
            background: #1A1A1A;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1.5rem;
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
            width: 80px; height: 80px; border-radius: 50%;
            background: #1A1A1A; border: 1px solid rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            transition: background 0.3s, border-color 0.3s, transform 0.3s;
        }
        .supply-card:hover .supply-icon {
            background: #F47B20;
            border-color: #F47B20;
            transform: scale(1.08);
        }
        .supply-card h4 { font-size: 0.9rem; font-weight: 600; color: rgba(255,255,255,0.8); text-align: center; }

        /* ── CTA section ── */
        .cta-section {
            background: linear-gradient(135deg, #F47B20 0%, #C55E00 100%);
            position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* ── Orange badge tag ── */
        .badge-tag {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: #F47B20;
            border: 1.5px solid rgba(244,123,32,0.35);
            border-radius: 50px; padding: 0.3rem 0.85rem;
            margin-bottom: 0.75rem; width: fit-content;
        }
        .badge-tag::before { content: '●'; font-size: 0.45rem; }

        /* ── Visual deco circle ── */
        .deco-circle-orange {
            position: absolute; width: 96px; height: 96px; border-radius: 50%;
            background: rgba(244,123,32,0.15); z-index: 0;
        }
        .deco-circle-dark {
            position: absolute; width: 96px; height: 96px; border-radius: 50%;
            background: rgba(244,123,32,0.08); z-index: 0;
        }
    </style>

    <section class="bg-[#111111] text-white">

        {{-- ════════════════════════════════════════
             HERO BANNER
        ════════════════════════════════════════ --}}
        <section class="relative pt-32 pb-20 bg-[#111111] text-white overflow-hidden circuit-bg">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-[#F47B20]/8 skew-x-12 translate-x-32"></div>
            <div class="absolute top-0 left-0 w-full h-full"
                 style="background: radial-gradient(ellipse 70% 70% at 20% 50%, rgba(244,123,32,0.07) 0%, transparent 70%)">
            </div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-3xl">
                    <div class="badge-tag mb-4">Nos domaines d'intervention</div>
                    <h1 class="text-5xl md:text-6xl font-black mb-6 leading-tight" style="letter-spacing:-0.03em">
                        Expertise Complète en<br>
                        <span style="color:#F47B20">Technologies & Énergie</span>
                    </h1>
                    <p class="text-xl leading-relaxed" style="color:rgba(255,255,255,0.6)">
                        De l'étude initiale à la maintenance, POLAM SARL vous accompagne dans chaque projet
                        électrique, technologique et énergétique avec rigueur et professionnalisme.
                    </p>
                    <div class="flex flex-wrap gap-3 mt-8">
                        <a href="#electrique" class="px-5 py-2.5 rounded-full text-sm font-600 border border-white/15 hover:border-[#F47B20] hover:text-[#F47B20] transition-all">Installation Électrique</a>
                        <a href="#solaire" class="px-5 py-2.5 rounded-full text-sm font-600 border border-white/15 hover:border-[#F47B20] hover:text-[#F47B20] transition-all">Énergie Solaire</a>
                        <a href="#securite" class="px-5 py-2.5 rounded-full text-sm font-600 border border-white/15 hover:border-[#F47B20] hover:text-[#F47B20] transition-all">Sécurité & Alarme</a>
                        <a href="#maintenance" class="px-5 py-2.5 rounded-full text-sm font-600 border border-white/15 hover:border-[#F47B20] hover:text-[#F47B20] transition-all">Maintenance</a>
                    </div>
                </div>
            </div>
            {{-- Hero visual deco --}}
            <div class="w-1/3 h-80 absolute top-28 right-6 rounded-2xl overflow-hidden shadow-2xl hidden lg:block animate-float"
                 style="border:1px solid rgba(244,123,32,0.2)">
                <div class="w-full h-full flex items-center justify-center"
                     style="background: linear-gradient(135deg, #1A1A1A 0%, #242424 100%)">
                    {{-- Remplacer par une vraie image : <img src="{{ asset('media/img/services/hero.jpg') }}" class="w-full h-full object-cover"> --}}
                    <div class="text-center p-6">
                        <div style="font-size:4rem">⚡</div>
                        <p class="text-sm mt-3 font-semibold" style="color:#F47B20;letter-spacing:0.1em;text-transform:uppercase">POLAM SARL</p>
                        <p class="text-xs mt-1" style="color:rgba(255,255,255,0.4)">La technologie à votre portée</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             SERVICE 1 — Installation Électrique
        ════════════════════════════════════════ --}}
        <div class="space-y-12 lg:space-y-0">
            <section id="electrique" class="reveal py-16 lg:py-24 overflow-hidden bg-[#111111]">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="relative">
                                <div class="deco-circle-orange -top-4 -left-4"></div>
                                {{-- <img src="{{ asset('media/img/services/installation-electrique.jpg') }}" alt="Installation Électrique" class="rounded-3xl shadow-2xl relative z-10 object-cover h-[500px] w-full"> --}}
                                <div class="rounded-3xl relative z-10 h-[420px] w-full flex items-center justify-center"
                                     style="background:linear-gradient(135deg,#1A1A1A,#242424);border:1px solid rgba(244,123,32,0.18)">
                                    <div class="text-center">
                                        <div style="font-size:5rem">⚡</div>
                                        <p class="mt-3 text-sm font-semibold" style="color:#F47B20;letter-spacing:0.08em;text-transform:uppercase">Installation Électrique</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="badge-tag">Service Principal</div>
                            <h2 class="text-4xl font-extrabold mt-2 mb-5" style="letter-spacing:-0.02em">
                                Installation Électrique Domestique & Tertiaire
                            </h2>
                            <p class="mb-8 text-lg leading-relaxed" style="color:rgba(255,255,255,0.6)">
                                POLAM SARL assure l'étude, la conception et la mise en œuvre de tous vos projets
                                d'installation électrique — du logement individuel aux bâtiments tertiaires et industriels,
                                dans le strict respect des normes en vigueur.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Étude et conception de plans électriques aux normes</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Câblage, pose de tableaux électriques et appareillage</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Mise en conformité des installations existantes</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Installation domotique et gestion intelligente de l'énergie</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Réception, test et vérification des installations livrées</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 2 — Énergie Solaire
            ════════════════════════════════════════ --}}
            <section id="solaire" class="reveal py-16 lg:py-24 overflow-hidden section-alt">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="relative">
                                <div class="deco-circle-dark -bottom-4 -right-4"></div>
                                {{-- <img src="{{ asset('media/img/services/energie-solaire.jpg') }}" alt="Énergie Solaire" class="rounded-3xl shadow-2xl relative z-10 object-cover h-[500px] w-full"> --}}
                                <div class="rounded-3xl relative z-10 h-[420px] w-full flex items-center justify-center"
                                     style="background:linear-gradient(135deg,#1A1A1A,#242424);border:1px solid rgba(244,123,32,0.18)">
                                    <div class="text-center">
                                        <div style="font-size:5rem">☀️</div>
                                        <p class="mt-3 text-sm font-semibold" style="color:#F47B20;letter-spacing:0.08em;text-transform:uppercase">Énergie Solaire</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="badge-tag">Énergie Renouvelable</div>
                            <h2 class="text-4xl font-extrabold mt-2 mb-5" style="letter-spacing:-0.02em">
                                Énergie Solaire & Systèmes Photovoltaïques
                            </h2>
                            <p class="mb-8 text-lg leading-relaxed" style="color:rgba(255,255,255,0.6)">
                                Réduisez votre facture énergétique et gagnez en autonomie grâce à nos solutions solaires
                                sur mesure — dimensionnées, installées et maintenues par nos techniciens certifiés.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Étude de faisabilité et dimensionnement des installations solaires</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Pose de panneaux photovoltaïques et onduleurs</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Installation de systèmes de stockage et de batteries</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Systèmes hybrides solaire + réseau pour continuité électrique</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Maintenance préventive et monitoring des performances</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 3 — Vidéosurveillance & Alarme
            ════════════════════════════════════════ --}}
            <section id="securite" class="reveal py-16 lg:py-24 overflow-hidden bg-[#111111]">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="relative">
                                <div class="deco-circle-orange -top-4 -left-4"></div>
                                <div class="rounded-3xl relative z-10 h-[420px] w-full flex items-center justify-center"
                                     style="background:linear-gradient(135deg,#1A1A1A,#242424);border:1px solid rgba(244,123,32,0.18)">
                                    <div class="text-center">
                                        <div style="font-size:5rem">📷</div>
                                        <p class="mt-3 text-sm font-semibold" style="color:#F47B20;letter-spacing:0.08em;text-transform:uppercase">Vidéosurveillance & Alarme</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="badge-tag">Sécurité</div>
                            <h2 class="text-4xl font-extrabold mt-2 mb-5" style="letter-spacing:-0.02em">
                                Vidéosurveillance, Alarme & Contrôle d'Accès
                            </h2>
                            <p class="mb-8 text-lg leading-relaxed" style="color:rgba(255,255,255,0.6)">
                                Protégez vos biens, vos locaux et vos collaborateurs grâce à nos systèmes de sécurité
                                intégrés — vidéosurveillance HD, alarmes techniques et contrôle d'accès biométrique.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Installation de caméras IP et systèmes CCTV HD / 4K</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Systèmes d'alarme intrusion et détection incendie</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Contrôle d'accès par badge, biométrie ou code</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Enregistrement numérique et accès à distance via application mobile</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ════════════════════════════════════════
                 SERVICE 4 — Réseaux & Télécoms
            ════════════════════════════════════════ --}}
            <section id="reseaux" class="reveal py-16 lg:py-24 overflow-hidden section-alt">
                <div class="container mx-auto px-6">
                    <div class="flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">
                        {{-- Visual --}}
                        <div class="w-full lg:w-1/2 reveal-right">
                            <div class="relative">
                                <div class="deco-circle-dark -bottom-4 -right-4"></div>
                                <div class="rounded-3xl relative z-10 h-[420px] w-full flex items-center justify-center"
                                     style="background:linear-gradient(135deg,#1A1A1A,#242424);border:1px solid rgba(244,123,32,0.18)">
                                    <div class="text-center">
                                        <div style="font-size:5rem">🌐</div>
                                        <p class="mt-3 text-sm font-semibold" style="color:#F47B20;letter-spacing:0.08em;text-transform:uppercase">Réseaux & Télécoms</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="w-full lg:w-1/2 reveal-left">
                            <div class="badge-tag">Télécommunications</div>
                            <h2 class="text-4xl font-extrabold mt-2 mb-5" style="letter-spacing:-0.02em">
                                Réseaux & Télécommunications
                            </h2>
                            <p class="mb-8 text-lg leading-relaxed" style="color:rgba(255,255,255,0.6)">
                                Connectez votre organisation avec des infrastructures réseau robustes et évolutives.
                                De la fibre optique au Wi-Fi professionnel, nous concevons des solutions sur mesure.
                            </p>
                            <ul>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Câblage structuré RJ45, fibre optique et baie de brassage</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Déploiement de réseaux Wi-Fi professionnel (indoor/outdoor)</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Configuration de routeurs, switches et VPN sécurisés</span>
                                </li>
                                <li class="svc-item">
                                    <div class="check-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span>Téléphonie IP (VoIP) et PABX pour entreprises</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- ════════════════════════════════════════
             SECTION SOMBRE — Maintenance & Biomédical
        ════════════════════════════════════════ --}}
        <section id="maintenance" class="py-24 bg-[#0D0D0D] text-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <div class="badge-tag mx-auto">Support Technique</div>
                    <h2 class="text-4xl font-bold mt-3" style="letter-spacing:-0.02em">
                        Maintenance, Dépannage &
                        <span style="color:#F47B20">Biomédical</span>
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg" style="color:rgba(255,255,255,0.5)">
                        Disponibles et réactifs pour assurer la continuité de vos équipements électroniques,
                        informatiques et biomédicaux.
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" style="color:#F47B20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Dépannage Électronique</h3>
                        <p style="color:rgba(255,255,255,0.5);line-height:1.65;font-size:0.9rem">
                            Diagnostic et réparation rapide d'équipements électroniques défaillants — onduleurs,
                            tableaux électriques, appareils connectés et automates.
                        </p>
                    </div>
                    <div class="feature-card" style="border-color:rgba(244,123,32,0.25)">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" style="color:#F47B20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Équipements Biomédicaux</h3>
                        <p style="color:rgba(255,255,255,0.5);line-height:1.65;font-size:0.9rem">
                            Maintenance préventive et corrective des équipements médicaux électroniques —
                            moniteurs, générateurs, appareils de diagnostic et matériel hospitalier.
                        </p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg class="w-7 h-7" style="color:#F47B20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Maintenance Informatique</h3>
                        <p style="color:rgba(255,255,255,0.5);line-height:1.65;font-size:0.9rem">
                            Installation, configuration et maintenance de parcs informatiques, serveurs,
                            postes de travail et périphériques pour particuliers et entreprises.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             SECTION — Commerce & Import-Export (=Conseil)
        ════════════════════════════════════════ --}}
        <section id="commerce" class="py-24 bg-[#111111]">
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-12 items-center">
                    <div class="lg:w-1/2">
                        <div class="badge-tag">Commerce & Import-Export</div>
                        <h2 class="text-4xl font-extrabold mb-5 mt-2" style="letter-spacing:-0.02em;color:#fff">
                            Commerce Général &
                            <span style="color:#F47B20">Import-Export</span>
                        </h2>
                        <p class="mb-8 text-lg leading-relaxed" style="color:rgba(255,255,255,0.55)">
                            En tant qu'acteur du commerce général, POLAM SARL vous donne accès à du matériel
                            électrique, électronique et technologique de qualité internationale à des tarifs compétitifs.
                        </p>
                        <div class="space-y-4">
                            <div class="conseil-item">
                                <div class="conseil-item-icon">📦</div>
                                <div>
                                    <h4 class="font-bold text-white">Fourniture de matériel électrique</h4>
                                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.5)">Câbles, tableaux, disjoncteurs, prises, luminaires et équipements de marques reconnues.</p>
                                </div>
                            </div>
                            <div class="conseil-item" style="border-left-color:#F47B20">
                                <div class="conseil-item-icon">🌍</div>
                                <div>
                                    <h4 class="font-bold text-white">Import de matériel technologique</h4>
                                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.5)">Panneaux solaires, caméras, équipements réseau et biomédicaux importés directement à moindre coût.</p>
                                </div>
                            </div>
                            <div class="conseil-item" style="border-left-color:#F47B20">
                                <div class="conseil-item-icon">🤝</div>
                                <div>
                                    <h4 class="font-bold text-white">Prestation de services clé en main</h4>
                                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.5)">Accompagnement de bout en bout : achat, livraison, installation et mise en service.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                        <div class="stat-card-orange">
                            <span class="text-5xl font-black mb-2">5+</span>
                            <span class="text-sm font-semibold uppercase tracking-widest" style="color:rgba(255,255,255,0.85)">Ans d'Expertise</span>
                        </div>
                        <div class="stat-card-dark">
                            <span class="text-5xl font-black mb-2" style="color:#F47B20">6</span>
                            <span class="text-sm font-semibold uppercase tracking-widest" style="color:rgba(255,255,255,0.5)">Pôles de Services</span>
                        </div>
                        <div class="stat-card-dark" style="margin-top:0">
                            <span class="text-5xl font-black mb-2" style="color:#F47B20">360°</span>
                            <span class="text-sm font-semibold uppercase tracking-widest" style="color:rgba(255,255,255,0.5)">Accompagnement</span>
                        </div>
                        <div class="stat-card-orange" style="margin-top:0">
                            <span class="text-5xl font-black mb-2">100%</span>
                            <span class="text-sm font-semibold uppercase tracking-widest" style="color:rgba(255,255,255,0.85)">Engagement Client</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ════════════════════════════════════════
             MATÉRIEL & FOURNITURES (= Nos Fournitures)
        ════════════════════════════════════════ --}}
        <section class="py-24 bg-[#0D0D0D]">
            <div class="container mx-auto px-6 text-center">
                <div class="badge-tag mx-auto mb-3">Matériel</div>
                <h2 class="text-3xl font-bold mb-4" style="color:#fff;letter-spacing:-0.02em">Matériel & Équipements Fournis</h2>
                <p class="text-base mb-14 max-w-xl mx-auto" style="color:rgba(255,255,255,0.45)">Nous fournissons et installons des équipements de qualité issus des meilleures marques du marché.</p>
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
            <div class="container mx-auto px-6 relative z-10 text-center">
                <h2 class="text-4xl md:text-5xl font-black mb-5 text-white" style="letter-spacing:-0.03em">
                    Prêt à lancer votre projet ?
                </h2>
                <p class="text-xl mb-10 max-w-xl mx-auto" style="color:rgba(255,255,255,0.8)">
                    Contactez-nous pour une étude gratuite et un devis personnalisé adapté à vos besoins.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('contact') }}"
                       class="bg-white text-[#E8640A] px-8 py-3.5 rounded-full font-bold text-base hover:bg-[#111] hover:text-white transition-all duration-300 shadow-xl">
                        Demander un devis gratuit
                    </a>
                    <a href="tel:+237699070353"
                       class="border-2 border-white text-white px-8 py-3.5 rounded-full font-bold text-base hover:bg-white hover:text-[#E8640A] transition-all duration-300">
                        📞 699 070 353
                    </a>
                </div>
                <p class="mt-8 text-sm" style="color:rgba(255,255,255,0.6)">
                    Ou écrivez-nous à
                    <a href="mailto:polamsarl@gmail.com" class="underline hover:text-white transition-colors">polamsarl@gmail.com</a>
                </p>
            </div>
        </section>

    </section>

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

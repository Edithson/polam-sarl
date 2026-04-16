@extends('home.index')

@section('content')

<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_PUBLIC_KEY') }}"></script>

<style>
    /* ══════════════════════════════════════
       GLOBAL & UTILITAIRES
    ══════════════════════════════════════ */
    .contact-page {
        background: var(--dark);
        color: var(--white);
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* Grille type "circuit" pour le Hero */
    .circuit-bg {
        background-image:
            linear-gradient(color-mix(in srgb, var(--orange) 7%, transparent) 1px, transparent 1px),
            linear-gradient(90deg, color-mix(in srgb, var(--orange) 7%, transparent) 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .badge-tag {
        display: inline-flex; align-items: center; gap: 0.45rem;
        font-family: 'Syne', sans-serif;
        font-size: 0.72rem; font-weight: 700; letter-spacing: 0.13em;
        text-transform: uppercase; color: var(--orange);
        border: 1px solid color-mix(in srgb, var(--orange) 35%, transparent);
        background: color-mix(in srgb, var(--orange) 5%, transparent);
        border-radius: 2px; padding: 0.3rem 0.85rem;
        margin-bottom: 0.75rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.45rem; }

    /* ══════════════════════════════════════
       CONTACT INFO CARDS
    ══════════════════════════════════════ */
    .info-card {
        display: flex; align-items: flex-start; gap: 1.25rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid color-mix(in srgb, var(--white) 6%, transparent);
    }
    .info-card:last-child { border-bottom: none; }

    .info-icon {
        flex-shrink: 0;
        width: 54px; height: 54px;
        background: color-mix(in srgb, var(--orange) 10%, transparent);
        border: 1px solid color-mix(in srgb, var(--orange) 25%, transparent);
        border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        color: var(--orange);
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .info-card:hover .info-icon {
        transform: scale(1.05) rotate(-5deg);
        background: color-mix(in srgb, var(--orange) 20%, transparent);
    }

    .info-title {
        font-family: 'Syne', sans-serif; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.05em; font-size: 0.9rem; color: var(--white);
        margin-bottom: 0.25rem;
    }

    .info-desc { font-size: 0.85rem; color: var(--gray-light); line-height: 1.6; font-weight: 300;}

    /* ══════════════════════════════════════
       FORMULAIRE LIVEWIRE (Overrides)
    ══════════════════════════════════════ */
    .form-wrapper {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 7%, transparent);
        border-radius: 4px;
        padding: 2.5rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
    }

    /* Styles pour forcer le formulaire Livewire à s'adapter au thème Polam */
    .form-wrapper input,
    .form-wrapper select,
    .form-wrapper textarea {
        background: var(--dark-4) !important;
        border: 1px solid color-mix(in srgb, var(--white) 10%, transparent) !important;
        color: var(--white) !important;
        border-radius: 2px !important;
    }
    .form-wrapper input:focus,
    .form-wrapper select:focus,
    .form-wrapper textarea:focus {
        border-color: var(--orange) !important;
        box-shadow: 0 0 0 2px color-mix(in srgb, var(--orange) 20%, transparent) !important;
        outline: none !important;
    }
    .form-wrapper button[type="submit"] {
        background: var(--orange) !important;
        color: #000 !important;
        font-family: 'Syne', sans-serif !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.08em !important;
        border-radius: 0 !important;
        clip-path: polygon(10px 0%, 100% 0%, calc(100% - 10px) 100%, 0% 100%);
        transition: background 0.3s !important;
    }
    .form-wrapper button[type="submit"]:hover {
        background: var(--orange-glow) !important;
    }
    .form-wrapper label { color: var(--gray-light) !important; font-family: 'Syne', sans-serif; font-size: 0.8rem; text-transform: uppercase; }

    /* ══════════════════════════════════════
       FAQ ACCORDION
    ══════════════════════════════════════ */
    details.faq-item {
        background: var(--dark-3);
        border: 1px solid color-mix(in srgb, var(--white) 6%, transparent);
        border-radius: 4px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: border-color 0.3s;
    }
    details.faq-item:hover { border-color: color-mix(in srgb, var(--orange) 30%, transparent); }

    summary.faq-summary {
        padding: 1.5rem;
        cursor: pointer;
        list-style: none; /* Cache la flèche native */
        display: flex; justify-content: space-between; align-items: center;
        font-family: 'Syne', sans-serif; font-weight: 700; color: var(--white);
        text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;
        outline: none;
    }
    summary.faq-summary::-webkit-details-marker { display: none; }

    .faq-icon {
        color: var(--orange); font-size: 1.2rem;
        transition: transform 0.3s ease;
    }
    details[open] .faq-icon { transform: rotate(180deg); }

    .faq-content {
        padding: 0 1.5rem 1.5rem;
        color: var(--gray-light); font-size: 0.9rem; line-height: 1.7; font-weight: 300;
        border-top: 1px solid color-mix(in srgb, var(--white) 3%, transparent);
        margin-top: 0.5rem; padding-top: 1.5rem;
    }

    /* ══════════════════════════════════════
       MAP
    ══════════════════════════════════════ */
    .grayscale-map { filter: grayscale(100%) invert(90%) contrast(85%); transition: filter 0.7s ease; }
    .dark .grayscale-map { filter: grayscale(100%) invert(100%) contrast(90%); } /* S'adapte mieux au mode sombre */
    .grayscale-map:hover { filter: grayscale(20%); }

</style>

<div class="contact-page mt-10">

    {{-- ════════════════════════════════════════
         HERO SECTION
    ════════════════════════════════════════ --}}
    <section class="relative pt-36 pb-20 overflow-hidden circuit-bg border-b border-[color-mix(in_srgb,var(--orange)_15%,transparent)] bg-[var(--dark)]">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/4 w-72 h-72 bg-[var(--orange)] rounded-full blur-[150px] opacity-20 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[var(--orange)] rounded-full blur-[150px] opacity-10 translate-x-1/3 translate-y-1/3"></div>
        </div>
        <div class="container mx-auto px-6 max-w-7xl relative z-10 text-center">
            <div class="flex justify-center"><div class="badge-tag mx-auto">Nous Joindre</div></div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-display text-[var(--white)] tracking-wide mt-2 mb-4">
                Contactez nos <span class="text-[var(--orange)]">experts</span>
            </h1>
            <p class="text-[var(--gray-light)] font-light max-w-2xl mx-auto text-lg leading-relaxed">
                Vous avez un projet d'installation électrique, d'énergie solaire ou de sécurité technologique ?
                Notre équipe est à votre disposition pour un accompagnement sur mesure.
            </p>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         COORDONNÉES & FORMULAIRE
    ════════════════════════════════════════ --}}
    <section class="py-20 bg-[var(--dark-2)]">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

                {{-- Bloc Coordonnées --}}
                <div class="lg:col-span-5 space-y-8">
                    <h2 class="text-3xl font-display tracking-wide text-[var(--white)] mb-8">Nos Coordonnées</h2>

                    <div class="space-y-6">
                        <div class="info-card">
                            <div class="info-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="info-title">Localisation</h4>
                                <p class="info-desc">Yaoundé, Cameroun</p>
                                <p class="text-[0.7rem] text-[var(--gray)] font-heading uppercase tracking-widest mt-1">Intervention nationale</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="info-title">Téléphone / WhatsApp</h4>
                                <p class="info-desc">+237 674 180 413</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="info-title">Email</h4>
                                <p class="info-desc">polamsarl@gmail.com</p>
                            </div>
                        </div>

                        <div class="info-card">
                            <div class="info-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="info-title">Heures d'ouverture</h4>
                                <p class="info-desc">Lundi - Samedi</p>
                                <p class="text-[0.75rem] font-bold text-[var(--orange)] mt-1">07H30 - 18H00</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bloc Formulaire Livewire --}}
                <div class="lg:col-span-7">
                    <div class="form-wrapper relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[var(--orange)] to-transparent"></div>

                        <h3 class="text-xl md:text-2xl font-heading font-bold text-[var(--white)] mb-8 uppercase tracking-wide">Laissez-nous un message</h3>

                        {{-- Le composant Livewire s'adaptera via les CSS '.form-wrapper' déclarées plus haut --}}
                        <livewire:pages.public.contact-form />
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         FAQ (NOUVELLE SECTION)
    ════════════════════════════════════════ --}}
    <section class="py-24 bg-[var(--dark)]">
        <div class="container mx-auto px-6 max-w-4xl">
            <div class="text-center mb-14">
                <div class="flex justify-center"><div class="badge-tag">FAQ</div></div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-display text-[var(--white)] tracking-wide mt-2 mb-4">
                    Questions <span class="text-[var(--orange)]">Fréquentes</span>
                </h2>
                <p class="text-[var(--gray-light)] font-light">Tout ce que vous devez savoir avant de démarrer un projet avec nous.</p>
            </div>

            <div class="space-y-4">
                <details class="faq-item" name="faq">
                    <summary class="faq-summary">
                        Intervenez-vous en dehors de Yaoundé ?
                        <span class="faq-icon">▼</span>
                    </summary>
                    <div class="faq-content">
                        Absolument. Bien que notre siège soit situé à Yaoundé, les équipes de POLAM SARL sont mobiles et interviennent sur toute l'étendue du territoire national (Cameroun) ainsi que dans la sous-région, selon l'envergure de votre projet.
                    </div>
                </details>

                <details class="faq-item" name="faq">
                    <summary class="faq-summary">
                        Comment se déroule la demande de devis ?
                        <span class="faq-icon">▼</span>
                    </summary>
                    <div class="faq-content">
                        Une fois que vous nous contactez (via le formulaire, WhatsApp ou par téléphone), un expert analyse votre demande. Si nécessaire, nous programmons une visite technique sur le site pour évaluer les contraintes réelles. Ensuite, nous vous transmettons un devis détaillé, transparent et gratuit sous 24 à 48 heures.
                    </div>
                </details>

                <details class="faq-item" name="faq">
                    <summary class="faq-summary">
                        Proposez-vous des garanties sur le matériel installé ?
                        <span class="faq-icon">▼</span>
                    </summary>
                    <div class="faq-content">
                        Oui. Tous les équipements que nous fournissons (panneaux solaires, caméras, câblage, équipements IT) proviennent de marques reconnues et bénéficient de la garantie constructeur. De plus, nous offrons une garantie sur notre main-d'œuvre et un service après-vente (SAV) réactif en cas d'anomalie.
                    </div>
                </details>

                <details class="faq-item" name="faq">
                    <summary class="faq-summary">
                        Prenez-vous en charge la maintenance de systèmes que vous n'avez pas installés ?
                        <span class="faq-icon">▼</span>
                    </summary>
                    <div class="faq-content">
                        Oui, nous proposons des services de maintenance préventive et curative (dépannage) pour les installations électriques, parcs informatiques, systèmes de sécurité et équipements biomédicaux existants. Nous réalisons d'abord un audit technique de l'existant avant toute intervention.
                    </div>
                </details>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         MAP
    ════════════════════════════════════════ --}}
    <section class="w-full h-[450px] relative bg-[var(--dark-4)] border-t border-[color-mix(in_srgb,var(--white)_5%,transparent)]">

        <div class="absolute top-6 right-6 z-10 hidden md:block">
            <div class="bg-[var(--dark-3)] p-6 rounded-[4px] shadow-2xl border border-[color-mix(in_srgb,var(--orange)_30%,transparent)] max-w-xs">
                <h4 class="font-heading font-bold text-[var(--white)] uppercase tracking-wide mb-2 flex items-center gap-2">
                    <span class="text-[var(--orange)]">📍</span> Retrouvez-nous
                </h4>
                <p class="text-sm text-[var(--gray-light)] font-light leading-relaxed">
                    Installés au cœur du Cameroun, nous sommes prêts à déployer nos solutions technologiques pour vous.
                </p>
            </div>
        </div>

        <iframe class="w-full h-full grayscale-map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127357.54580210279!2d11.43387803276856!3d3.844119339396291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf7a309a7977%3A0x7f54bad35e693c52!2sYaound%C3%A9%2C%20Cameroun!5e0!3m2!1sfr!2sfr!4v1714000000000!5m2!1sfr!2sfr"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </section>

</div>
@endsection

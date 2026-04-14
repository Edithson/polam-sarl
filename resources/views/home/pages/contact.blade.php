@extends('home.index')

@section('content')

{{-- reCAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_PUBLIC_KEY') }}"></script>

<style>
    /* ══════════════════════════════════════
       GLOBAL
    ══════════════════════════════════════ */
    .contact-page {
        background: #111111;
        color: #ffffff;
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .contact-hero {
        background: #111111;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(244,123,32,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(244,123,32,0.06) 1px, transparent 1px);
        background-size: 52px 52px;
    }

    .hero-glow-left {
        position: absolute;
        top: -100px; left: -150px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(244,123,32,0.12) 0%, transparent 65%);
        pointer-events: none;
    }

    .hero-glow-right {
        position: absolute;
        bottom: -150px; right: -150px;
        width: 450px; height: 450px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(244,123,32,0.07) 0%, transparent 65%);
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
        border-radius: 50px; padding: 0.32rem 0.9rem;
        margin-bottom: 1rem; width: fit-content;
    }
    .badge-tag::before { content: '●'; font-size: 0.45rem; }

    /* ══════════════════════════════════════
       COORDONNÉES
    ══════════════════════════════════════ */
    .contact-body {
        background: #111111;
    }

    .coord-card {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.3rem 1.5rem;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.07);
        background: #1A1A1A;
        transition: border-color 0.3s ease, background 0.3s ease, transform 0.3s ease;
    }

    .coord-card:hover {
        border-color: rgba(244,123,32,0.35);
        background: #1F1F1F;
        transform: translateX(4px);
    }

    .coord-icon {
        flex-shrink: 0;
        width: 46px; height: 46px;
        border-radius: 12px;
        background: rgba(244,123,32,0.12);
        display: flex; align-items: center; justify-content: center;
        transition: background 0.3s;
    }

    .coord-card:hover .coord-icon {
        background: rgba(244,123,32,0.22);
    }

    .coord-icon svg {
        width: 22px; height: 22px;
        color: #F47B20;
        stroke: #F47B20;
    }

    .coord-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.35);
        margin-bottom: 0.25rem;
    }

    .coord-value {
        font-size: 0.92rem;
        color: rgba(255,255,255,0.8);
        line-height: 1.55;
    }

    .coord-value a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .coord-value a:hover { color: #F47B20; }

    .coord-sub {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.35);
        margin-top: 0.2rem;
        font-style: italic;
    }

    .hours-open {
        font-size: 0.82rem;
        font-weight: 700;
        color: #F47B20;
        margin-top: 0.2rem;
        letter-spacing: 0.03em;
    }

    /* ══════════════════════════════════════
       RÉSEAUX SOCIAUX
    ══════════════════════════════════════ */
    .social-row {
        display: flex; gap: 0.75rem; flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .social-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.5rem 1.1rem;
        border-radius: 50px;
        border: 1.5px solid rgba(255,255,255,0.1);
        font-size: 0.78rem; font-weight: 600;
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        transition: all 0.25s;
    }

    .social-btn:hover {
        border-color: #F47B20;
        background: rgba(244,123,32,0.08);
        color: #F47B20;
    }

    /* ══════════════════════════════════════
       FORMULAIRE
    ══════════════════════════════════════ */
    .form-card {
        background: #1A1A1A;
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 20px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #F47B20, #FF9A45, transparent);
    }

    .form-card h3 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.02em;
        margin-bottom: 0.35rem;
    }

    .form-card .form-subtitle {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.4);
        margin-bottom: 2rem;
    }

    /* Focus ring override */
    input:focus,
    select:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px rgba(244,123,32,0.18) !important;
        outline: none;
    }

    /* ══════════════════════════════════════
       MAP
    ══════════════════════════════════════ */
    .map-wrapper {
        position: relative;
        width: 100%;
        height: 420px;
        overflow: hidden;
    }

    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: 0;
        filter: grayscale(100%) invert(90%) hue-rotate(180deg) brightness(0.75) contrast(1.1);
        transition: filter 0.7s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .map-wrapper:hover iframe {
        filter: grayscale(30%) brightness(0.9);
    }

    .map-badge {
        position: absolute;
        top: 1rem; right: 1rem;
        z-index: 10;
        background: #1A1A1A;
        border: 1px solid rgba(244,123,32,0.25);
        border-radius: 14px;
        padding: 1rem 1.3rem;
        max-width: 260px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }

    .map-badge h4 {
        font-weight: 700;
        color: #ffffff;
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .map-badge p {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.45);
        line-height: 1.55;
    }

    .map-badge .map-pin {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.72rem; font-weight: 600; color: #F47B20;
        text-transform: uppercase; letter-spacing: 0.08em;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .map-wrapper iframe {
            filter: grayscale(0%) brightness(0.85);
        }
        .map-badge { display: none; }
        .form-card { padding: 1.5rem; }
    }
</style>

<div class="contact-page">

    {{-- ════════════════════════════════════════
         HERO
    ════════════════════════════════════════ --}}
    <section class="contact-hero pt-36 pb-20">
        <div class="hero-glow-left"></div>
        <div class="hero-glow-right"></div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="badge-tag mx-auto">Contactez-nous</div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-5"
                style="letter-spacing:-0.03em; line-height:1.05">
                Parlons de votre
                <span style="color:#F47B20">projet</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg leading-relaxed" style="color:rgba(255,255,255,0.55)">
                Vous avez un projet électrique, solaire ou technologique ? Notre équipe jeune et qualifiée
                est à votre disposition pour une étude gratuite et un devis personnalisé.
            </p>

            {{-- Quick contact chips --}}
            <div class="flex flex-wrap gap-3 justify-center mt-8">
                <a href="tel:+237699070353"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                          border border-[rgba(244,123,32,0.3)] text-[#F47B20]
                          text-sm font-600 bg-[rgba(244,123,32,0.07)]
                          hover:bg-[rgba(244,123,32,0.15)] transition-all">
                    📞 699 070 353
                </a>
                <a href="tel:+237674180413"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                          border border-[rgba(244,123,32,0.3)] text-[#F47B20]
                          text-sm font-600 bg-[rgba(244,123,32,0.07)]
                          hover:bg-[rgba(244,123,32,0.15)] transition-all">
                    📞 674 180 413
                </a>
                <a href="mailto:polamsarl@gmail.com"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full
                          border border-white/10 text-white/60
                          text-sm font-600 hover:border-[#F47B20] hover:text-[#F47B20]
                          transition-all">
                    ✉️ polamsarl@gmail.com
                </a>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         COORDONNÉES + FORMULAIRE
    ════════════════════════════════════════ --}}
    <section class="contact-body py-16">
        <div class="container mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                {{-- ── COORDONNÉES (gauche) ── --}}
                <div class="lg:col-span-5 space-y-4">

                    <h2 class="text-xl font-bold text-white mb-6" style="letter-spacing:-0.01em">
                        Nos coordonnées
                    </h2>

                    {{-- Adresse --}}
                    <div class="coord-card">
                        <div class="coord-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="coord-label">Localisation</div>
                            <div class="coord-value">
                                Yaoundé, Cameroun
                            </div>
                            <div class="coord-sub">Interventions à Yaoundé, Douala & environs</div>
                        </div>
                    </div>

                    {{-- Téléphone --}}
                    <div class="coord-card">
                        <div class="coord-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="coord-label">Téléphone</div>
                            <div class="coord-value">
                                <a href="tel:+237699070353">+237 699 070 353</a><br>
                                <a href="tel:+237674180413">+237 674 180 413</a>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="coord-card">
                        <div class="coord-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="coord-label">Email</div>
                            <div class="coord-value">
                                <a href="mailto:polamsarl@gmail.com">polamsarl@gmail.com</a>
                            </div>
                        </div>
                    </div>

                    {{-- Horaires --}}
                    <div class="coord-card">
                        <div class="coord-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="coord-label">Heures d'ouverture</div>
                            <div class="coord-value">Lundi – Vendredi</div>
                            <div class="hours-open">07H30 – 17H30</div>
                            <div class="coord-sub">Samedi sur rendez-vous</div>
                        </div>
                    </div>

                    {{-- Réseaux sociaux --}}
                    <div class="coord-card" style="flex-direction:column;align-items:flex-start;gap:0.75rem">
                        <div class="coord-label">Suivez-nous</div>
                        <div class="social-row">
                            <a href="https://www.facebook.com/polamsarl"
                               target="_blank" rel="noopener" class="social-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                                </svg>
                                Facebook
                            </a>
                            <a href="https://www.linkedin.com/company/polam-sarl/"
                               target="_blank" rel="noopener" class="social-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                                    <circle cx="4" cy="4" r="2"/>
                                </svg>
                                LinkedIn
                            </a>
                        </div>
                    </div>

                </div>

                {{-- ── FORMULAIRE (droite) ── --}}
                <div class="lg:col-span-7">
                    <div class="form-card">
                        <h3>Envoyez-nous un message</h3>
                        <p class="form-subtitle">
                            Décrivez votre projet et nous vous recontactons sous 24h.
                        </p>

                        {{-- Livewire component (identique à l'original) --}}
                        <livewire:pages.public.contact-form />

                        {{-- ─── Fallback statique si Livewire non disponible ───
                             Commentez le livewire ci-dessus et décommentez le bloc ci-dessous

                        <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-700 uppercase tracking-widest"
                                           style="color:rgba(255,255,255,0.4)">Nom complet</label>
                                    <input type="text" name="name" required
                                           placeholder="Votre nom"
                                           class="bg-[#242424] border border-white/8 rounded-xl px-4 py-3
                                                  text-white placeholder-white/25 text-sm
                                                  focus:border-[#F47B20] transition-colors">
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-700 uppercase tracking-widest"
                                           style="color:rgba(255,255,255,0.4)">Téléphone</label>
                                    <input type="tel" name="phone"
                                           placeholder="+237 6XX XXX XXX"
                                           class="bg-[#242424] border border-white/8 rounded-xl px-4 py-3
                                                  text-white placeholder-white/25 text-sm
                                                  focus:border-[#F47B20] transition-colors">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-700 uppercase tracking-widest"
                                       style="color:rgba(255,255,255,0.4)">Email</label>
                                <input type="email" name="email" required
                                       placeholder="votre@email.com"
                                       class="bg-[#242424] border border-white/8 rounded-xl px-4 py-3
                                              text-white placeholder-white/25 text-sm
-                                              focus:border-[#F47B20] transition-colors">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-700 uppercase tracking-widest"
                                       style="color:rgba(255,255,255,0.4)">Service concerné</label>
                                <select name="service"
                                        class="bg-[#242424] border border-white/8 rounded-xl px-4 py-3
                                               text-white text-sm focus:border-[#F47B20] transition-colors">
                                    <option value="">Sélectionner un service…</option>
                                    <option>Installation Électrique</option>
                                    <option>Énergie Solaire</option>
                                    <option>Domotique</option>
                                    <option>Vidéosurveillance & Alarme</option>
                                    <option>Réseaux & Télécommunications</option>
                                    <option>Maintenance & Dépannage</option>
                                    <option>Biomédical & Informatique</option>
                                    <option>Commerce général / Import-Export</option>
                                    <option>Autre</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-700 uppercase tracking-widest"
                                       style="color:rgba(255,255,255,0.4)">Votre message</label>
                                <textarea name="message" rows="4" required
                                          placeholder="Décrivez brièvement votre besoin ou projet…"
                                          class="bg-[#242424] border border-white/8 rounded-xl px-4 py-3
                                                 text-white placeholder-white/25 text-sm resize-none
                                                 focus:border-[#F47B20] transition-colors"></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full bg-[#F47B20] text-white font-700 py-3.5 rounded-xl
                                           text-sm tracking-wide hover:bg-[#C55E00]
                                           hover:-translate-y-0.5 hover:shadow-[0_8px_28px_rgba(244,123,32,0.35)]
                                           transition-all duration-300 flex items-center justify-center gap-2">
                                Envoyer le message →
                            </button>
                        </form>
                        ─── fin fallback ─── --}}

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════
         CARTE GOOGLE MAPS
    ════════════════════════════════════════ --}}
    <section class="map-wrapper">

        <div class="map-badge hidden md:block">
            <div class="map-pin">📍 Nos bureaux</div>
            <h4>POLAM SARL</h4>
            <p>Yaoundé, Cameroun — disponibles du lundi au vendredi de 07H30 à 17H30.</p>
        </div>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127374.72!2d11.4948!3d3.8480!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf6c13781c87%3A0x13c1e4d9e98765!2sYaound%C3%A9%2C%20Cameroun!5e0!3m2!1sfr!2scm!4v1700000000000!5m2!1sfr!2scm"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

    </section>

</div>

@endsection

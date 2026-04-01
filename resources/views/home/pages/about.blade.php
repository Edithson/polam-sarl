@extends('home.index')

@section('content')

<style>
        /* Hero Header */
        .about-hero {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 50%, #166534 100%);
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Stats Animation */
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #16a34a, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        /* Value Cards */
        .value-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #16a34a, #ec4899);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.15);
        }

        .value-card:hover::before {
            transform: scaleX(1);
        }

        .value-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .value-card:hover .value-icon {
            transform: scale(1.1) rotate(-5deg);
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #16a34a, #ec4899);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
        }

        .timeline-item:nth-child(odd) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            width: calc(50% - 2.5rem);
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .timeline-item:hover .timeline-content {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.15);
        }

        .timeline-dot {
            width: 20px;
            height: 20px;
            background: white;
            border: 4px solid #16a34a;
            border-radius: 50%;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .timeline-item:nth-child(even) .timeline-dot {
            border-color: #ec4899;
        }

        .timeline-item:hover .timeline-dot {
            transform: translateX(-50%) scale(1.5);
            box-shadow: 0 0 20px rgba(22, 163, 74, 0.5);
        }

        /* Expertise Bars */
        .expertise-bar {
            background: #f3f4f6;
            border-radius: 10px;
            height: 14px;
            overflow: hidden;
        }

        .expertise-fill {
            height: 100%;
            background: linear-gradient(90deg, #16a34a, #ec4899);
            border-radius: 10px;
            transition: width 1.5s ease-in-out;
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
            padding: 2rem;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.4);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .timeline::before {
                left: 20px;
            }

            .timeline-item {
                flex-direction: column !important;
                align-items: flex-start;
                padding-left: 4rem;
            }

            .timeline-content {
                width: 100%;
            }

            .timeline-dot {
                left: 10px;
                transform: translateX(0);
            }

            .timeline-item:hover .timeline-dot {
                transform: scale(1.5);
            }
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 2.5rem;
            }

            .value-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }
    </style>

<!-- Hero Section -->
    @include('home.sections.hero_about')

    <!-- Introduction & Stats -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <!-- Introduction -->
            <div class="max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 text-center">Qui sommes-nous ?</h2>
                <div class="space-y-5 text-gray-600 text-lg leading-relaxed">
                    <p>
                        <strong class="text-green-600 font-semibold">{{ $siteName }}</strong> est le leader incontesté de
                        l'ingénierie documentaire en Afrique noire francophone. Nous proposons une offre intégrée
                        complète incluant l'archivage manuel, l'archivage électronique, des logiciels GEIDE et des
                        solutions de dématérialisation.
                    </p>
                    <p>
                        Notre expertise couvre la gestion globale du cycle de vie des documents : documents entrants,
                        dossiers de soumission, documents internes et externes. Nous maîtrisons parfaitement
                        l'interaction avec les principaux systèmes d'information (ERP, PLM, CRM, GMAO, messagerie,
                        intranet, extranet).
                    </p>
                    <p>
                        Nos Systèmes d'Archivage Électronique (SAE) s'articulent autour de trois piliers essentiels :
                        <strong class="text-green-600">50% organisationnel</strong>, <strong class="text-green-600">25%
                            réglementaire</strong> et <strong class="text-green-600">25% informatique</strong>,
                        garantissant une approche équilibrée et conforme.
                    </p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-lg">
                    <div class="stat-number" data-target="15">0</div>
                    <p class="text-gray-600 font-semibold mt-2">Années d'Expérience</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-pink-50 to-white rounded-2xl shadow-lg">
                    <div class="stat-number" data-target="200">0</div>
                    <p class="text-gray-600 font-semibold mt-2">Clients Satisfaits</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-lg">
                    <div class="stat-number" data-target="50">0</div>
                    <p class="text-gray-600 font-semibold mt-2">K+ Documents Gérés</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-pink-50 to-white rounded-2xl shadow-lg">
                    <div class="stat-number" data-target="5">0</div>
                    <p class="text-gray-600 font-semibold mt-2">Pays en Afrique</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Notre Mission</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        <strong class="text-green-600">{{ $siteName }}</strong> s'engage à transformer la gestion
                        documentaire des entreprises africaines en proposant des solutions innovantes, sécurisées et
                        conformes aux normes internationales.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        Nous accompagnons nos clients dans leur transition numérique en combinant expertise technique,
                        connaissance des réglementations locales et approche organisationnelle adaptée aux réalités du
                        terrain.
                    </p>
                    <a href="{{ route('contact') }}" class="btn-primary">Contactez-nous</a>
                </div>
                <div class="order-1 lg:order-2">
                    <div
                        class="w-full h-96 bg-gradient-to-br from-green-100 to-pink-100 rounded-3xl shadow-2xl flex items-center justify-center p-2">
                        <img class="w-full h-full rounded-3xl" src="{{ asset('media/img/socials/formation.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Valeurs -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Nos Valeurs</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Les principes qui guident notre action au quotidien
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="value-card">
                    <div class="value-icon">🎯</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Excellence</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Nous visons l'excellence dans chaque projet, en délivrant des solutions de qualité supérieure
                        qui dépassent les attentes de nos clients.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Partenariat</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Nous construisons des relations durables basées sur la confiance, l'écoute et l'accompagnement
                        personnalisé de nos clients.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">🔒</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Sécurité</h3>
                    <p class="text-gray-600 leading-relaxed">
                        La protection de vos données est notre priorité absolue. Nous appliquons les plus hauts
                        standards de sécurité et de conformité.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">💡</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Innovation</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Nous investissons continuellement dans la recherche et l'adoption des technologies les plus
                        avancées du marché.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">🌍</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Engagement Local</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Enracinés en Afrique, nous comprenons les défis locaux et proposons des solutions adaptées à
                        notre contexte.
                    </p>
                </div>

                <div class="value-card">
                    <div class="value-icon">⚖️</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Intégrité</h3>
                    <p class="text-gray-600 leading-relaxed">
                        L'honnêteté, la transparence et l'éthique professionnelle sont au cœur de toutes nos actions et
                        décisions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Histoire - Timeline -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Notre Histoire</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Un parcours marqué par l'innovation et la croissance continue
                </p>
            </div>

            <div class="timeline max-w-5xl mx-auto">
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-green-600 mb-2">2008</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Création de {{ $siteName }}</h4>
                        <p class="text-gray-600">
                            Lancement de nos activités d'archivage manuel à Yaoundé, avec une vision claire : devenir le
                            leader de la gestion documentaire en Afrique francophone.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-pink-600 mb-2">2012</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Expansion vers le numérique</h4>
                        <p class="text-gray-600">
                            Introduction de nos premières solutions d'archivage électronique et de numérisation
                            professionnelle. Plus de 50 clients nous font confiance.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-green-600 mb-2">2015</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Lancement des solutions GEIDE</h4>
                        <p class="text-gray-600">
                            Développement et déploiement de nos logiciels propriétaires de Gestion Électronique des
                            Informations et Documents d'Entreprise.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-pink-600 mb-2">2018</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Certification et Expansion régionale</h4>
                        <p class="text-gray-600">
                            Obtention des certifications ISO et expansion de nos services dans 5 pays d'Afrique
                            francophone. Plus de 150 clients actifs.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-green-600 mb-2">2023</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Leader reconnu du marché</h4>
                        <p class="text-gray-600">
                            {{ $siteName }} s'impose comme le leader incontesté de l'ingénierie documentaire en Afrique
                            francophone avec plus de 200 clients et 50K+ documents gérés.
                        </p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <h3 class="text-2xl font-bold text-pink-600 mb-2">2025</h3>
                        <h4 class="text-xl font-semibold text-gray-800 mb-3">Innovation et Futur</h4>
                        <p class="text-gray-600">
                            Intégration de l'Intelligence Artificielle dans nos solutions, lancement de services cloud
                            et vision d'expansion panafricaine.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Expertise -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Notre Expertise</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Des compétences reconnues dans tous les aspects de la gestion documentaire
                </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-8">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Archivage & Numérisation</h3>
                        <span class="text-green-600 font-bold text-lg">95%</span>
                    </div>
                    <div class="expertise-bar">
                        <div class="expertise-fill" data-width="95" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Systèmes GEIDE & SAE</h3>
                        <span class="text-green-600 font-bold text-lg">92%</span>
                    </div>
                    <div class="expertise-bar">
                        <div class="expertise-fill" data-width="92" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Dématérialisation</h3>
                        <span class="text-green-600 font-bold text-lg">90%</span>
                    </div>
                    <div class="expertise-bar">
                        <div class="expertise-fill" data-width="90" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Gestion Documentaire</h3>
                        <span class="text-green-600 font-bold text-lg">88%</span>
                    </div>
                    <div class="expertise-bar">
                        <div class="expertise-fill" data-width="88" style="width: 0%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Sécurité des Données</h3>
                        <span class="text-green-600 font-bold text-lg">85%</span>
                    </div>
                    <div class="expertise-bar">
                        <div class="expertise-fill" data-width="85" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-green-600 via-green-700 to-green-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 1000 1000">
                <circle cx="200" cy="200" r="150" fill="white" opacity="0.3">
                    <animate attributeName="r" values="150;180;150" dur="4s" repeatCount="indefinite" />
                </circle>
                <circle cx="800" cy="600" r="200" fill="#ec4899" opacity="0.2">
                    <animate attributeName="r" values="200;230;200" dur="5s" repeatCount="indefinite" />
                </circle>
            </svg>
        </div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                Prêt à transformer votre gestion documentaire ?
            </h2>
            <p class="text-lg md:text-xl text-green-50 mb-10 max-w-2xl mx-auto leading-relaxed">
                Contactez-nous dès aujourd'hui pour une consultation gratuite et découvrez comment nos solutions peuvent
                transformer votre entreprise.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                    class="bg-white text-green-600 px-10 py-4 rounded-full font-bold text-lg hover:bg-pink-500 hover:text-white transition-all duration-300 inline-block shadow-xl">
                    Demander un devis gratuit
                </a>
                <a href="{{ route('service') }}"
                    class="bg-transparent border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-green-600 transition-all duration-300 inline-block">
                    Voir nos services
                </a>
            </div>
        </div>
    </section>

    <script>

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.length > 1) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offsetTop = target.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Animated counter for stats
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (target === 50 ? 'K+' : '+');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (target === 50 ? 'K+' : '+');
                }
            }, 16);
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate stats
                    if (entry.target.classList.contains('stat-number')) {
                        animateCounter(entry.target);
                    }

                    // Animate expertise bars
                    if (entry.target.classList.contains('expertise-fill')) {
                        const width = entry.target.getAttribute('data-width');
                        setTimeout(() => {
                            entry.target.style.width = width + '%';
                        }, 200);
                    }

                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe stat numbers
        document.querySelectorAll('.stat-number').forEach(stat => {
            observer.observe(stat);
        });

        // Observe expertise bars
        document.querySelectorAll('.expertise-fill').forEach(bar => {
            observer.observe(bar);
        });

        // Timeline animation on scroll
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.timeline-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = `all 0.6s ease ${index * 0.1}s`;
            timelineObserver.observe(item);
        });

        // Value cards animation
        const valueObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.value-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.5s ease ${index * 0.1}s`;
            valueObserver.observe(card);
        });
    </script>

@endsection

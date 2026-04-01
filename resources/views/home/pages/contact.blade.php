@extends('home.index')

@section('content')

<!-- recaptcha -->
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_PUBLIC_KEY') }}"></script>

<style>

        /* Animation personnalisée pour la carte (Map) */
        .grayscale-map {
            filter: grayscale(100%);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .grayscale-map:hover {
            filter: grayscale(0%);
        }

        /* Effet Glassmorphism pour les éléments flottants */
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Personnalisation des champs de formulaire au focus */
        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            /* Couleur Emerald de CINV-CORSA */
        }

        /* Style pour l'animation de succès du bouton */
        .btn-success {
            background-color: #10b981 !important;
            /* Emerald-500 */
            transform: scale(1.02);
        }

        /* Ajustement pour les écrans tactiles sur la map */
        @media (max-width: 768px) {
            .grayscale-map {
                filter: grayscale(0%);
            }
        }
    </style>

    <section class="relative bg-slate-900 py-20 overflow-hidden pt-20 md:pt-32 lg:pt-40">
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 left-0 w-72 h-72 bg-emerald-500 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-3xl translate-x-1/3 translate-y-1/3">
            </div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Contactez nos <span
                    class="text-emerald-400">experts</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                Vous avez un projet d'archivage ou de transformation digitale ? Notre équipe est à votre disposition
                pour un audit personnalisé à Yaoundé et partout en Afrique.
            </p>
        </div>
    </section>

    <section class="py-16 px-10 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-5 space-y-8">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 mb-6">Nos Coordonnées</h2>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">Localisation</h4>
                                    <p class="text-gray-600">Carrefour Camp SONEL Essos,<br>Yaoundé, Cameroun</p>
                                    <p class="text-sm text-gray-400 italic">BP 5747 Yaoundé</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">Téléphone</h4>
                                    <p class="text-gray-600">+237 6 96 15 69 81</p>
                                    <p class="text-gray-600">+237 6 99 15 69 81</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">Email</h4>
                                    <p class="text-gray-600">contact@cinvcorsa.com</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">Heures d'ouverture</h4>
                                    <p class="text-gray-600">Lundi - Vendredi</p>
                                    <p class="text-sm font-semibold text-emerald-600">08H30 - 17H00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                        <h3 class="text-2xl font-bold text-slate-800 mb-6">Envoyez-nous un message</h3>

                        <livewire:pages.public.contact-form />
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="w-full h-[450px] bg-gray-200 relative">
        <div class="absolute top-2 right-2 z-10 hidden md:block">
            <div class="bg-white p-4 rounded-2xl shadow-xl border border-gray-100 max-w-xs">
                <h4 class="font-bold text-slate-800">Retrouvez-nous</h4>
                <p class="text-sm text-gray-500 mt-1 italic">Situé au carrefour Camp SONEL Essos, nous vous accueillons
                    dans nos locaux de Yaoundé.</p>
            </div>
        </div>

        <iframe class="w-full h-full grayscale hover:grayscale-0 transition-all duration-700"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15923.328362621092!2d11.530342987158203!3d3.8631169000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf704e03108d%3A0x6b8045e0322b27d4!2sEssos%2C%20Yaound%C3%A9!5e0!3m2!1sfr!2scm!4v1703340000000!5m2!1sfr!2scm"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </section>

@endsection

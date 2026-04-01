<!-- CTA Section -->
<section class="relative py-24 overflow-hidden bg-slate-900">

    <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>

    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#10b981 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[40px] p-8 md:p-16 shadow-2xl overflow-hidden relative">
        <img src="{{asset('media/img/autres/cta.png')}}" alt="" class="w-full h-full absolute top-0 left-0 object-cover object-center opacity-10 pointer-events-none">

            <div class="absolute top-0 right-0 p-8 opacity-20 hidden lg:block">
                <svg class="w-40 h-40 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9l-7-7z"></path>
                </svg>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12">

                <div class="lg:w-2/3 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2 bg-emerald-500/20 text-emerald-400 px-4 py-2 rounded-full mb-6">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest">Disponible pour de nouveaux projets</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                        Faites entrer vos archives dans <span class="text-emerald-400">une nouvelle ère.</span>
                    </h2>

                    <p class="text-gray-400 text-lg md:text-xl mb-10 max-w-2xl leading-relaxed">
                        Ne laissez plus vos documents devenir un fardeau. Optimisez votre espace, sécurisez vos données et accélérez vos recherches avec l'expertise CINV-CORSA.
                    </p>

                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 items-center">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=V+K&background=10b981&color=fff" alt="Client">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=A+M&background=3b82f6&color=fff" alt="Client">
                            <img class="w-10 h-10 rounded-full border-2 border-slate-900" src="https://ui-avatars.com/api/?name=S+T&background=8b5cf6&color=fff" alt="Client">
                        </div>
                        <p class="text-sm text-gray-500 italic">+200 organisations nous font confiance au Cameroun.</p>
                    </div>
                </div>

                <div class="lg:w-1/3 w-full flex flex-col gap-4">
                    <a href="{{ route('contact') }}" class="group relative flex items-center justify-center bg-emerald-600 text-white px-8 py-5 rounded-2xl font-bold text-lg hover:bg-emerald-500 transition-all duration-300 shadow-xl shadow-emerald-900/20 overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            Démarrer mon Audit Gratuit
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                        <div class="absolute inset-0 w-1/2 h-full bg-white/20 skew-x-[-20deg] -translate-x-[150%] group-hover:translate-x-[250%] transition-transform duration-700"></div>
                    </a>

                    <a href="tel:+23760770861" class="flex items-center justify-center border border-white/10 text-white px-8 py-5 rounded-2xl font-bold text-lg hover:bg-white/5 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Parler à un expert
                    </a>

                    <p class="text-center text-xs text-gray-500 mt-2">Réponse garantie sous 24h ouvrables.</p>
                </div>

            </div>
        </div>
    </div>
</section>

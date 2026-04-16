<section class="py-20 bg-[var(--dark-2)] transition-colors duration-300" id="realisations">
  <div class="container mx-auto px-6 max-w-7xl">

    <div class="flex flex-col md:flex-row md:justify-between md:align-bottom gap-6 mb-12">
      <div>
        <div class="flex items-center gap-2 font-heading text-[10px] font-bold tracking-[0.2em] uppercase text-[var(--orange)] mb-2">
            <span class="w-6 h-[1.5px] bg-[var(--orange)]"></span>
            Nos chantiers
        </div>
        <h2 class="text-4xl md:text-5xl font-display text-[var(--white)] tracking-wide">
            Réalisations <span class="text-[var(--orange)]">sur le terrain</span>
        </h2>
      </div>
      <div class="md:self-end">
        <a href="{{ route('service') }}" class="btn-ghost flex items-center gap-2" style="padding: 0.8rem 1.5rem; font-size: 0.75rem;">
            Voir tous les projets
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-[280px]">

      <div class="group relative overflow-hidden rounded-[4px] md:col-span-2 lg:col-span-1 lg:row-span-2 cursor-pointer shadow-lg border border-white/5">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('media/img/services/468736674_122174472032248917_6077360893160087508_n.jpg') }}" alt="Chantier Résidentiel">

        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="absolute top-4 left-4 bg-[var(--orange)] text-black font-heading text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-sm shadow-md">
            En cours
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
            <h3 class="font-heading font-bold text-white text-xl md:text-2xl uppercase tracking-wide">Chantier Résidentiel</h3>
            <p class="text-[var(--orange)] font-heading text-xs mt-1 tracking-wider">Prédallage & câblage préencastré · 2025</p>
        </div>
      </div>

      <div class="group relative overflow-hidden rounded-[4px] cursor-pointer shadow-lg border border-white/5">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('media/img/services/electricite_salle.png') }}" alt="Salle Polyvalente">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="absolute top-4 left-4 bg-white/10 backdrop-blur-md text-white border border-white/20 font-heading text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-sm">
            Livré
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
          <h3 class="font-heading font-bold text-white text-lg uppercase tracking-wide leading-tight">Électrification Salle Polyvalente</h3>
          <p class="text-[var(--gray-light)] font-heading text-xs mt-1 tracking-wider group-hover:text-[var(--orange)] transition-colors">Éclairage & lustre décoratif · 2024</p>
        </div>
      </div>

      <div class="group relative overflow-hidden rounded-[4px] cursor-pointer shadow-lg border border-white/5">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('media/img/services/installation_solaire.png') }}" alt="Installation Solaire">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="absolute top-4 left-4 bg-white/10 backdrop-blur-md text-white border border-white/20 font-heading text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-sm">
            Livré
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
          <h3 class="font-heading font-bold text-white text-lg uppercase tracking-wide leading-tight">Installation Solaire</h3>
          <p class="text-[var(--gray-light)] font-heading text-xs mt-1 tracking-wider group-hover:text-[var(--orange)] transition-colors">Système hybride 5kW · 2024</p>
        </div>
      </div>

      <div class="group relative overflow-hidden rounded-[4px] cursor-pointer shadow-lg border border-white/5">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('media/img/services/469955117_122175761240248917_2051757559915711150_n.jpg') }}" alt="Vidéosurveillance Entreprise">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="absolute top-4 left-4 bg-white/10 backdrop-blur-md text-white border border-white/20 font-heading text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-sm">
            Livré
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
          <h3 class="font-heading font-bold text-white text-lg uppercase tracking-wide leading-tight">Vidéosurveillance Entreprise</h3>
          <p class="text-[var(--gray-light)] font-heading text-xs mt-1 tracking-wider group-hover:text-[var(--orange)] transition-colors">16 caméras IP + NVR · 2025</p>
        </div>
      </div>

      <div class="group relative overflow-hidden rounded-[4px] cursor-pointer shadow-lg border border-white/5">
        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ asset('media/img/services/cablade_reseau.jpg') }}" alt="Câblage Structuré">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

        <div class="absolute top-4 left-4 bg-white/10 backdrop-blur-md text-white border border-white/20 font-heading text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-sm">
            Livré
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
          <h3 class="font-heading font-bold text-white text-lg uppercase tracking-wide leading-tight">Câblage Structuré</h3>
          <p class="text-[var(--gray-light)] font-heading text-xs mt-1 tracking-wider group-hover:text-[var(--orange)] transition-colors">Réseau fibre + RJ45 · 2024</p>
        </div>
      </div>

    </div>
  </div>
</section>

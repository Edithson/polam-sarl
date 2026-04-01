<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CINV-CORSA</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ $siteLogo ? asset('storage/' . $siteLogo) : asset('media/img/logo.png') }}" type="image/png">

    @vite(['resources/css/home.css', 'resources/js/app.js'])

    <script>
    window.translations = {
        slides: [
            {
                tag: {!! json_encode(__('home.slide1_tag')) !!},
                title: {!! json_encode(__('home.slide1_title')) !!},
                desc: {!! json_encode(__('home.slide1_desc')) !!}
            },
            {
                tag: {!! json_encode(__('home.slide2_tag')) !!},
                title: {!! json_encode(__('home.slide2_title')) !!},
                desc: {!! json_encode(__('home.slide2_desc')) !!}
            },
            {
                tag: {!! json_encode(__('home.slide3_tag')) !!},
                title: {!! json_encode(__('home.slide3_title')) !!},
                desc: {!! json_encode(__('home.slide3_desc')) !!}
            }
        ]
    };
</script>

</head>
<body>
    <section>
        @include('home.layout.nav_bar')
        <div class="w-full h-auto mt-0 mb-0">
            @yield('content')
        </div>
        @include('home.layout.footer')
    </section>

    <div class="fixed bottom-18 right-2 flex flex-col gap-4 z-50">
        {{-- centrer le texte dans le bouton --}}
        <button
            id="backToTop"
            class="hidden bg-white text-slate-900 p-4 rounded-full shadow-2xl hover:bg-slate-100 transition-all duration-300 transform hover:scale-110 items-center justify-center"
            onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        >
            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M12 8L12 16M12 8L9 11M12 8L15 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

        </button>

        @php
            $whatsappNumber = "23760770861";
            $message = rawurlencode("Bonjour CINV-CORSA, j'aimerais avoir plus d'informations sur vos services.");
        @endphp
        <a
            href="https://wa.me/{{ $whatsappNumber }}?text={{ $message }}"
            target="_blank"
            class="p-4 bg-[#25D366] text-white rounded-full shadow-2xl hover:bg-[#20ba5a] transition-all duration-300 transform hover:scale-110 flex items-center justify-center"
            title="Contactez-nous sur WhatsApp"
        >
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </a>
    </div>

    <script>
        // Logique pour le bouton Retour en Haut
        const backToTop = document.getElementById('backToTop');

        window.onscroll = function() {
            // Apparaît après avoir défilé 30% de la hauteur de la fenêtre
            if (document.body.scrollTop > window.innerHeight * 0.3 || document.documentElement.scrollTop > window.innerHeight * 0.3) {
                backToTop.classList.remove('hidden');
                backToTop.classList.add('flex');
            } else {
                backToTop.classList.add('hidden');
                backToTop.classList.remove('flex');
            }
        };
    </script>
</body>

<script src="{{ asset('js/home/script.js') }}"></script>
</html>

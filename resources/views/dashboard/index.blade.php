<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POLAM SARL</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <link rel="icon" href="{{ $siteLogo ? asset('storage/' . $siteLogo) : asset('media/img/logo.png') }}" type="image/png"> --}}
    <link rel="icon" href="{{ asset('media/img/logo.png') }}" type="image/png">

    @vite(['resources/css/dashboard.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        @include('dashboard.layout.sidebar')
        @include('dashboard.layout.header')
        <main class="flex-1 flex flex-col min-w-0 bg-gray-50 overflow-y-auto mt-15">
            @yield('content')
        </main>
        @include('dashboard.layout.footer')
    </div>

    <script>
        // Configuration de base pour les toasts (petites alertes en haut à droite)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        // 1. Écouter les messages Flash de Laravel (Session)
        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Accès refusé', text: "{{ session('error') }}", confirmButtonColor: '#10b981' });
        @endif

        @if(session('warning'))
            Toast.fire({ icon: 'warning', title: "{{ session('warning') }}" });
        @endif

        // 2. Écouter les événements Livewire (pour Volt)
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                icon: event.detail[0].type,
                title: event.detail[0].title,
                text: event.detail[0].text,
                confirmButtonColor: '#10b981',
            });
        });

        window.addEventListener('swal:toast', event => {
            Toast.fire({
                icon: event.detail[0].type,
                title: event.detail[0].title
            });
        });
    </script>
</body>

<script src="{{ asset('js/dashboard/script.js') }}"></script>
</html>

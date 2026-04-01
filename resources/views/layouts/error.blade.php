@php
    // On vérifie si l'URL commence par 'admin'
    $isAdmin = request()->is('admin') || request()->is('admin/*');

    // On définit la route et le label selon le contexte
    $homeRoute = $isAdmin ? route('admin_dashboard') : route('home');
    $homeLabel = $isAdmin ? 'Retour au tableau de bord' : "Retour à l'accueil";

@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - CINV-CORSA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center">
        @yield('content')
    </div>
</body>
</html>

@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center p-6 text-center">
    <h1 class="text-9xl font-bold text-slate-200">403</h1>
    {{-- Illustration ou Icône --}}
    <div class="w-24 h-24 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mb-6 shadow-sm border border-red-100">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
            </path>
        </svg>
    </div>

    {{-- Message d'erreur --}}
    <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Accès refusé</h1>
    <p class="text-lg text-slate-500 max-w-md mx-auto mb-8">
        {{ __($exception->getMessage() ?: "Désolé, vous n'avez pas les autorisations nécessaires pour accéder à cette section.") }}
    </p>

    {{-- Actions --}}
    <div class="flex gap-4">
        <a href="{{ url()->previous() }}" class="px-6 py-3 rounded-xl font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">
            Retourner en arrière
        </a>
        <a href="{{ $homeRoute }}" class="px-6 py-3 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
            {{ $homeLabel }}
        </a>
    </div>
</div>
@endsection

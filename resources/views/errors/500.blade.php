@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center p-6 text-center">
    <h1 class="text-9xl font-bold text-slate-200">500</h1>
    <div class="w-24 h-24 bg-red-50 text-red-600 rounded-3xl flex items-center justify-center mb-6 shadow-sm border border-red-100">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Erreur système</h1>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Une erreur inattendue s'est produite de notre côté. Nos administrateurs ont été alertés.</p>
    <a href="{{ $homeRoute }}" class="text-emerald-600 font-bold hover:underline">Retourner en sécurité</a>
</div>
@endsection

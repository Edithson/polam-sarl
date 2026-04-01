@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center p-6 text-center">
    <h1 class="text-9xl font-bold text-slate-200">419</h1>
    <div class="w-24 h-24 bg-amber-50 text-amber-500 rounded-3xl flex items-center justify-center mb-6 shadow-sm border border-amber-100">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Session expirée</h1>
    <p class="text-slate-500 max-w-md mx-auto mb-8">Pour des raisons de sécurité, votre session a expiré. Veuillez rafraîchir la page et réessayer.</p>
    <button onclick="window.location.reload()" class="bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Rafraîchir la page</button>
</div>
@endsection

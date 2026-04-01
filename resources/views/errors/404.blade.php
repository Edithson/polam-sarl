@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center p-6 text-center">
    <h1 class="text-9xl font-bold text-slate-200">404</h1>
    <div class="w-24 h-24 bg-blue-50 text-emerald-500 rounded-3xl flex items-center justify-center mb-6 shadow-sm border border-blue-100">
        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Oups ! Page introuvable</h1>
    <p class="text-slate-500 max-w-md mx-auto mb-8">La ressource que vous recherchez semble avoir été déplacée ou n'existe plus.</p>
    <a href="{{ $homeRoute }}" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-800 transition-all">{{ $homeLabel }}</a>
</div>
@endsection

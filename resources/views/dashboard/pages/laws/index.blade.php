@extends('dashboard.index')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Lois</h1>
            <p class="text-slate-500">Gestion des textes de loi</p>
        </div>
        @can('create', App\Models\Laws::class)
            {{-- Bouton Actif --}}
            <a href="{{ route('laws.create') }}"
            class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-emerald-500/20">
                Ajouter une loi
            </a>
        @else
            {{-- Bouton Grisé --}}
            <button disabled
                    title="Vous n'avez pas les permissions nécessaires"
                    class="bg-slate-200 text-slate-400 px-6 py-3 rounded-xl font-bold cursor-not-allowed opacity-70">
                Ajouter une loi (Verrouillé)
            </button>
        @endcan
    </div>

    <livewire:pages.admin.laws.list />
</div>
@endsection

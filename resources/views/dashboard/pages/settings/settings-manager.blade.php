@extends('dashboard.index')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Paramètres du site</h1>
            <p class="text-slate-500 text-sm">Modifiez les informations de votre site</p>
        </div>

        <livewire:pages.admin.settings-manager />
    </div>
@endsection

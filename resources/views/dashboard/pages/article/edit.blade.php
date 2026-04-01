@extends('dashboard.index')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Modifier l'article</h1>
            <p class="text-slate-500 text-sm">Modifiez les informations de : <span class="text-emerald-600 italic">"{{ $article->title }}"</span></p>
        </div>

        <livewire:pages.admin.article-edit :article="$article" />
    </div>
@endsection

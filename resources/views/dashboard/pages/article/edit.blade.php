@extends('dashboard.index')

@section('content')
    <div class="p-6">
        <livewire:pages.admin.article-edit :article="$article" />
    </div>
@endsection

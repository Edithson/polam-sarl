@extends('dashboard.index')

@section('content')

    <div class="py-12">
        <livewire:pages.admin.laws.edit :law="$law" />
    </div>

@endsection

@extends('dashboard.index')

@section('content')

    <div class="py-12">
        <livewire:pages.admin.user.edit :user="$user" />
    </div>

@endsection

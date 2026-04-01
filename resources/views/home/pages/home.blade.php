@extends('home.index')

@section('content')
    @include('home.sections.hero')
    @include('home.sections.stats')
    @include('home.sections.about')
    @include('home.sections.articles', ['articles' => $articles])
    @include('home.sections.choise')
    @include('home.sections.services2')
    @include('home.sections.cta1')
    @include('home.sections.customers')
    @include('home.sections.partners')
    @include('home.sections.industrial_process')
    @include('home.sections.laws')
    @include('home.sections.cta')

    <script src="{{ asset('js/home/slide_home.js') }}"></script>
@endsection

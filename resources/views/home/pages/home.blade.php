@extends('home.index')

@section('content')
    @include('home.sections.hero')
    {{-- @include('home.sections.marquee') --}}
    @include('home.sections.services2')
    @include('home.sections.about2')
    @include('home.sections.articles', ['articles' => $articles])
    @include('home.sections.service3')
    @include('home.sections.realisations')
    @include('home.sections.whyus')
    @include('home.sections.cta')
    {{--@include('home.sections.cta1')--}}

@endsection

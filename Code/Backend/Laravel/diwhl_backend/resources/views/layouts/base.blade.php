@extends('components.layouts.app')

@section('content')
    <x-header />
    <h1>from base</h1>

    <main>
        @yield('main-content')
    </main>

    <x-footer />
@endsection

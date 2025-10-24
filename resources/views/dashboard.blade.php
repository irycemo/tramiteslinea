@extends('layouts.admin')

@section('content')

    @if(auth()->user()->hasRole('Administrador'))

        @livewire('dashboard.dashboard-admin', ['lazy' => true])

    @else

        @livewire('dashboard.dashboard-entidad', ['lazy' => true])

    @endif

@endsection

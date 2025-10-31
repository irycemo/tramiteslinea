@extends('layouts.admin')

@section('content')

    @if (isset($query['error']))

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center mb-6" role="alert">

            <span class="block sm:inline">{{ $query['error'] }}</span>

        </div>

    @elseif (isset($query['succeess']))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-center mb-6" role="alert">

            <span class="block sm:inline">{{ $query['succeess'] }}</span>

        </div>

    @endif

    @if(auth()->user()->hasRole('Administrador'))

        @livewire('dashboard.dashboard-admin', ['lazy' => true])

    @else

        @livewire('dashboard.dashboard-entidad', ['lazy' => true])

    @endif

@endsection

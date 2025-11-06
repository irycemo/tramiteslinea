@extends('layouts.admin')

@section('content')

    @if (isset($query['error']))

        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg font-semibold relative text-center mb-6" role="alert">

            <span class="block sm:inline">{{ $query['error'] }}</span>

        </div>

    @elseif (isset($query['success']))

        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg font-semibold relative text-center mb-6" role="alert">

            <span class="block sm:inline">{{ $query['success'] }}</span>

        </div>

    @endif

    @if(auth()->user()->hasRole('Administrador'))

        @livewire('dashboard.dashboard-admin', ['lazy' => true])

    @else

        @livewire('dashboard.dashboard-entidad', ['lazy' => true])

    @endif

    <x-header class="mt-5">Nuevas preguntas frecuentes</x-header>

    <div class="bg-white shadow-xl rounded-lg p-4 mt-5" wire:loading.class.delaylongest="opacity-50">

        <div class="w-full lg:w-1/2 mx-auto ">

            <ul class="w-full space-y-3">

                @foreach ($preguntas as $item)

                    <li class="cursor-pointer hover:bg-gray-100 rounded-lg text-gray-700 border border-gray-300 flex justify-between">

                        <a href="{{ route('preguntas_frecuentes') . '?search=' . $item->titulo }}" class="w-full h-full p-3 flex justify-between items-center">

                            <span>{{ $item->titulo }}</span>

                        </a>

                    </li>

                @endforeach

                <li class="cursor-pointer bg-gray-200 rounded-lg text-gray-700 border border-gray-400 flex justify-between ">

                    <a href="{{ route('preguntas_frecuentes') }}" class="w-full h-full p-1 flex justify-center items-center text-gray-700">

                       Ver mas

                    </a>

                </li>

            </ul>

        </div>

    </div>

@endsection

@extends('layouts.admin')

@section('content')

    @livewire('dashboard.dashboard', ['lazy' => true])

@endsection

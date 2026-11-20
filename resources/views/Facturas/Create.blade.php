
@extends('layouts.app')

@section('title')
    Crear factura
@endsection

@section('content')

{{-- Breadcrumb --}}
    <div class="text-xs text-au-text-muted mb-1">
        <a href="{{ route('factura.index') }}" class="hover:text-au-brown-dark">
            factura
        </a>

        <span class="mx-1">/</span>

        <span class="text-au-brown-darkest">Nueva factura</span>
    </div>

    {{-- Título --}}
    <h1 class="text-xl font-bold text-au-brown-darkest mb-6">
        Nueva factura
    </h1>

    {{-- Contenedor principal --}}
    <div class="w-full max-w-7xl mx-auto">

        {{-- Componente principal de la factura --}}
        <livewire:create-factura
            :clientes="$clientes"
            :mesas="$mesas"
        />

    </div>

@endsection

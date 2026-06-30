<x-mail::message>

@if($aviso->entidad->notario)
    <p>{{ $aviso->entidad->notarioTitular->name }}</p>
@endif

{{ $entidad }}

Se le informa que esta autoridad catastral ha reiniciado la operación del traslado de dominio con folio {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}, por error en la operación. Es necesario volver a cerrar el aviso.

Con fundamento en el Reglamento de la Ley de la Función Registral y Catastral del Estado de Michoacán de Ocampo

{!! $observaciones !!}

<x-mail::button :url="$url">
Ir al Sistema de Trámites en Línea
</x-mail::button>

Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>

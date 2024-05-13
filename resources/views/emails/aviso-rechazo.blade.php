<x-mail::message>
{{ $entidad }}

Se le informa que esta autoridad catastral ha rechazado el traslado de dominio con folio {{ $observacion->aviso->año }}-{{ $observacion->aviso->folio }}-{{ $observacion->aviso->usuario }}

Con fundamento en el Reglamento de la Ley de la Función Registral y Catastral del Estado de Michoacán de Ocampo

{!! $observacion->observacion !!}

<x-mail::button :url="$url">
Ir al Sistema de Trámites en Línea
</x-mail::button>

Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>

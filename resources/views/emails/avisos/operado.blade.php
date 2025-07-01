<x-mail::message>

@if($aviso->entidad->notario)
    <p>{{ $aviso->entidad->notarioTitular->name }}</p>
@endif

{{ $entidad }}

<p>Se le informa que esta autoridad catastral ha realizado la actualización del aviso con folio {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</p>
<p>Con cuenta predial: {{ $aviso->predio->cuentaPredial() }}</p>
<p>Con clave catastral: {{ $aviso->predio->claveCatastral() }}</p>

Para solicitar los servicios que sean necesarios, serán presentando conforme a las disposiciones y plazos establecidos por los artículos 61 fracción II, 69 y 70 de la Ley de Hacienda del Estado de Michoacán de Ocampo y 29 Fracción X inciso A de la ley de Ingresos del Estado de Michoacán de Ocampo vigente el el presente año fiscal.

<x-mail::button :url="$url">
Ir al Sistema de Trámites en Línea
</x-mail::button>

Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>

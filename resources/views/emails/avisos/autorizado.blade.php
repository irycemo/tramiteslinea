<x-mail::message>

@if($aviso->entidad->notario)
    <p>{{ $aviso->entidad->notarioTitular->name }}</p>
@endif

<p>{{ $entidad }}</p>

<p>Se le informa que esta autoridad catastral ha autorizado el traslado de dominio con folio {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}.</p>
<p>Con cuenta predial: {{ $aviso->predio->cuentaPredial() }}.</p>
<p>Con clave catastral: {{ $aviso->predio->claveCatastral() }}.</p>

@if($observaciones)

    Condicionantes:

    {{ $observaciones }}

@endif

1. La actualización en la base de datos, queda condicionada a la presentación del traslado original debidamente sellado y firmado para cotejo con la copia original.
2. Presentación del avalúo en original debidamente firmado para cotejo con la copia original.
3. Presentación de la constancia de no adeudo.
4. Presentación del certificado catastral.
5. Anexos que acompañen al docuemento.
6. En caso de sentencias judiciales, debera presentar copia de la misma debidamente cotejada o certificada.
7. En el caso de avaluos bancarios la presente autorización solo es para presentación de documentos en las oficinas de rentas.

Es motivo de rechazo el no contar con los elementos necesarios para la autorización definitiva.

<x-mail::button :url="$url">
Ir al Sistema de Trámites en Línea
</x-mail::button>

Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>
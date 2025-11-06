<x-mail::message>

<p>{{ $user->name }}</p>

<p>Se le informa que ha sido registrada(o) en el Sistema de Trámites en Línea.</p>
<p>Correo: {{ $user->email }}</p>
<p>Contraseña: sistema</p>

<x-mail::button :url="$url">
Ir al Sistema de Trámites en Línea
</x-mail::button>

Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>
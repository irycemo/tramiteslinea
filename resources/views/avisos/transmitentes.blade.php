<div >

    <p class="separador">transmitentes</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Nombre / Razón social</th>
                <th style="padding-right: 10px;">% de propiedad</th>
                <th style="padding-right: 10px;">% de nuda</th>
                <th style="padding-right: 10px;">% de usufructo</th>
                <th style="padding-right: 10px;">Generales</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->transmitentes() as $transmitente)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $transmitente->persona->nombre }} {{ $transmitente->persona->ap_paterno }} {{ $transmitente->persona->ap_materno }} {{ $transmitente->persona->razon_social }}</p>
                        @if($transmitente->persona->multiple_nombre)
                            <p style="margin:0">({{ $transmitente->persona->multiple_nombre }})</p>
                        @endif
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">
                            @if(isset($predio->partes_iguales))

                                @if($predio->partes_iguales)

                                    Partes iguales

                                @else

                                    {{ $transmitente->porcentaje_propiedad ?? '0.00' }}%

                                @endif

                            @else

                                {{ $transmitente->porcentaje_propiedad ?? '0.00' }}%

                            @endif
                        </p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $transmitente->porcentaje_nuda ?? '0.00' }} %</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $transmitente->porcentaje_usufructo ?? '0.00' }} %</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>
                            @if($transmitente->persona->rfc)RFC: <strong>{{ $transmitente->persona->rfc }}</strong>,@endif
                            @if($transmitente->persona->curp)CURP: <strong>{{ $transmitente->persona->curp }}</strong>,@endif
                            @if($transmitente->persona->nacionalidad)Nacionalidad: <strong>{{ $transmitente->persona->nacionalidad }}</strong>,@endif
                            @if($transmitente->persona->fecha_nacimiento)Fecha de nacimiento: <strong>{{ $transmitente->persona->fecha_nacimiento }}</strong>,@endif
                            @if($transmitente->persona->estado_civil)Estado civil: <strong>{{ $transmitente->persona->estado_civil }}</strong>,@endif
                            @if($transmitente->persona->calle)Calle: <strong>{{ $transmitente->persona->calle }}</strong>,@endif
                            @if($transmitente->persona->numero_exterior)Número exterior: <strong>{{ $transmitente->persona->numero_exterior }}</strong>,@endif
                            @if($transmitente->persona->numero_interior)Número interior: <strong>{{ $transmitente->persona->numero_interior }}</strong>,@endif
                            @if($transmitente->persona->colonia)Colonia: <strong>{{ $transmitente->persona->colonia }}</strong>,@endif
                            @if($transmitente->persona->cp)Código postal: <strong>{{ $transmitente->persona->cp }}</strong>,@endif
                            @if($transmitente->persona->entidad)Entidad: <strong>{{ $transmitente->persona->entidad }}</strong>,@endif
                            @if($transmitente->persona->municipio)Municipio: <strong>{{ $transmitente->persona->municipio }}</strong>,@endif
                            @if($transmitente->persona->ciudad)Ciudad: <strong>{{ $transmitente->persona->ciudad }}</strong>,@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

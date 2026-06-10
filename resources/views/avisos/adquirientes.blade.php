<div >

    <p class="separador">adquirientes</p>

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

            @foreach ($predio->adquirientes() as $adquiriente)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $adquiriente->persona->nombre }} {{ $adquiriente->persona->ap_paterno }} {{ $adquiriente->persona->ap_materno }} {{ $adquiriente->persona->razon_social }}</p>
                        @if($adquiriente->persona->multiple_nombre)
                            <p style="margin:0">({{ $adquiriente->persona->multiple_nombre }})</p>
                        @endif
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">
                            @if(isset($predio->partes_iguales))

                                @if($predio->partes_iguales)

                                    Partes iguales

                                @else

                                    {{ $adquiriente->porcentaje_propiedad ?? '0.00' }}%

                                @endif

                            @else

                                {{ $adquiriente->porcentaje_propiedad ?? '0.00' }}%

                            @endif
                        </p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $adquiriente->porcentaje_nuda ?? '0.00' }} %</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $adquiriente->porcentaje_usufructo ?? '0.00' }} %</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>
                            @if($adquiriente->persona->rfc)RFC: <strong>{{ $adquiriente->persona->rfc }}</strong>,@endif
                            @if($adquiriente->persona->curp)CURP: <strong>{{ $adquiriente->persona->curp }}</strong>,@endif
                            @if($adquiriente->persona->nacionalidad)Nacionalidad: <strong>{{ $adquiriente->persona->nacionalidad }}</strong>,@endif
                            @if($adquiriente->persona->fecha_nacimiento)Fecha de nacimiento: <strong>{{ $adquiriente->persona->fecha_nacimiento }}</strong>,@endif
                            @if($adquiriente->persona->estado_civil)Estado civil: <strong>{{ $adquiriente->persona->estado_civil }}</strong>,@endif
                            @if($adquiriente->persona->calle)Calle: <strong>{{ $adquiriente->persona->calle }}</strong>,@endif
                            @if($adquiriente->persona->numero_exterior)Número exterior: <strong>{{ $adquiriente->persona->numero_exterior }}</strong>,@endif
                            @if($adquiriente->persona->numero_interior)Número interior: <strong>{{ $adquiriente->persona->numero_interior }}</strong>,@endif
                            @if($adquiriente->persona->colonia)Colonia: <strong>{{ $adquiriente->persona->colonia }}</strong>,@endif
                            @if($adquiriente->persona->cp)Código postal: <strong>{{ $adquiriente->persona->cp }}</strong>,@endif
                            @if($adquiriente->persona->entidad)Entidad: <strong>{{ $adquiriente->persona->entidad }}</strong>,@endif
                            @if($adquiriente->persona->municipio)Municipio: <strong>{{ $adquiriente->persona->municipio }}</strong>,@endif
                            @if($adquiriente->persona->ciudad)Ciudad: <strong>{{ $adquiriente->persona->ciudad }}</strong>,@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

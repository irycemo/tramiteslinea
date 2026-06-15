<div class="no-break">

    <p class="separador">fideicomiso</p>

    <p style=" margin-bottom: 8px;">
        Objeto principal del fideicomiso: <strong>{{ $aviso->descripcion_fideicomiso }}
    </p>

    <p style="text-align: center; font-weight:bold;">Fiduciarias</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Tipo de persona</th>
                <th style="padding-right: 10px;">Nombre / Razón social</th>
                <th style="padding-right: 10px;">Genreales</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->fiduciarias() as $fiduciaria)

                <tr>
                    <td style="padding-right: 40px;">
                        <p>{{ $fiduciaria->persona->tipo }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>{{ $fiduciaria->persona->nombre }} {{ $fiduciaria->persona->ap_paterno }} {{ $fiduciaria->persona->ap_materno }} {{ $fiduciaria->persona->razon_social }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>
                            @if($fiduciaria->persona->nacionalidad)Nacionalidad: <strong>{{ $fiduciaria->persona->nacionalidad }}</strong,@endif
                            @if($fiduciaria->persona->fecha_nacimiento)Fecha de nacimiento: <strong>{{ $fiduciaria->persona->fecha_nacimiento }}</strong>,@endif
                            @if($fiduciaria->persona->estado_civil)Estado civil: <strong>{{ $fiduciaria->persona->estado_civil }}</strong>,@endif
                            @if($fiduciaria->persona->calle)Calle: <strong>{{ $fiduciaria->persona->calle }}</strong>,@endif
                            @if($fiduciaria->persona->numero_exterior)Número exterior: <strong>{{ $fiduciaria->persona->numero_exterior }}</strong>,@endif
                            @if($fiduciaria->persona->numero_interior)Número interior: <strong>{{ $fiduciaria->persona->numero_interior }}</strong>,@endif
                            @if($fiduciaria->persona->colonia)Colonia: <strong>{{ $fiduciaria->persona->colonia }}</strong>,@endif
                            @if($fiduciaria->persona->cp)Código postal: <strong>{{ $fiduciaria->persona->cp }}</strong>,@endif
                            @if($fiduciaria->persona->entidad)Entidad: <strong>{{ $fiduciaria->persona->entidad }}</strong>,@endif
                            @if($fiduciaria->persona->municipio)Municipio: <strong>{{ $fiduciaria->persona->municipio }}</strong>,@endif
                            @if($fiduciaria->persona->ciudad)Ciudad: <strong>{{ $fiduciaria->persona->ciudad }}</strong>,@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

    <p style="text-align: center; font-weight:bold;">Fideicomitentes</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Tipo de persona</th>
                <th style="padding-right: 10px;">Nombre / Razón social</th>
                <th style="padding-right: 10px;">Genreales</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->fideicomitentes() as $fideicomitente)

                <tr>
                    <td style="padding-right: 40px;">
                        <p>{{ $fideicomitente->persona->tipo }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>{{ $fideicomitente->persona->nombre }} {{ $fideicomitente->persona->ap_paterno }} {{ $fideicomitente->persona->ap_materno }} {{ $fideicomitente->persona->razon_social }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>
                            @if($fideicomitente->persona->nacionalidad)Nacionalidad: <strong>{{ $fideicomitente->persona->nacionalidad }}</strong>,@endif
                            @if($fideicomitente->persona->fecha_nacimiento)Fecha de nacimiento: <strong>{{ $fideicomitente->persona->fecha_nacimiento }}</strong>,@endif
                            @if($fideicomitente->persona->estado_civil)Estado civil: <strong>{{ $fideicomitente->persona->estado_civil }}</strong>,@endif
                            @if($fideicomitente->persona->calle)Calle: <strong>{{ $fideicomitente->persona->calle }}</strong>,@endif
                            @if($fideicomitente->persona->numero_exterior)Número exterior: <strong>{{ $fideicomitente->persona->numero_exterior }}</strong>,@endif
                            @if($fideicomitente->persona->numero_interior)Número interior: <strong>{{ $fideicomitente->persona->numero_interior }}</strong>,@endif
                            @if($fideicomitente->persona->colonia)Colonia: <strong>{{ $fideicomitente->persona->colonia }}</strong>,@endif
                            @if($fideicomitente->persona->cp)Código postal: <strong>{{ $fideicomitente->persona->cp }}</strong>,@endif
                            @if($fideicomitente->persona->entidad)Entidad: <strong>{{ $fideicomitente->persona->entidad }}</strong>,@endif
                            @if($fideicomitente->persona->municipio)Municipio: <strong>{{ $fideicomitente->persona->municipio }}</strong>,@endif
                            @if($fideicomitente->persona->ciudad)Ciudad: <strong>{{ $fideicomitente->persona->ciudad }}</strong>,@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

    <p style="text-align: center; font-weight:bold;">Fideicomisarios</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Tipo de persona</th>
                <th style="padding-right: 10px;">Nombre / Razón social</th>
                <th style="padding-right: 10px;">Genreales</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->Fideicomisarios() as $fidecomisario)

                <tr>
                    <td style="padding-right: 40px;">
                        <p>{{ $fidecomisario->persona->tipo }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>{{ $fidecomisario->persona->nombre }} {{ $fidecomisario->persona->ap_paterno }} {{ $fidecomisario->persona->ap_materno }} {{ $fidecomisario->persona->razon_social }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p>
                            @if($fidecomisario->persona->nacionalidad)Nacionalidad: <strong>{{ $fidecomisario->persona->nacionalidad }}</strong>,@endif
                            @if($fidecomisario->persona->fecha_nacimiento)Fecha de nacimiento: <strong>{{ $fidecomisario->persona->fecha_nacimiento }}</strong>,@endif
                            @if($fidecomisario->persona->estado_civil)Estado civil: <strong>{{ $fidecomisario->persona->estado_civil }}</strong>,@endif
                            @if($fidecomisario->persona->calle)Calle: <strong>{{ $fidecomisario->persona->calle }}</strong>,@endif
                            @if($fidecomisario->persona->numero_exterior)Número exterior: <strong>{{ $fidecomisario->persona->numero_exterior }}</strong>,@endif
                            @if($fidecomisario->persona->numero_interior)Número interior: <strong>{{ $fidecomisario->persona->numero_interior }}</strong>,@endif
                            @if($fidecomisario->persona->colonia)Colonia: <strong>{{ $fidecomisario->persona->colonia }}</strong>,@endif
                            @if($fidecomisario->persona->cp)Código postal: <strong>{{ $fidecomisario->persona->cp }}</strong>,@endif
                            @if($fidecomisario->persona->entidad)Entidad: <strong>{{ $fidecomisario->persona->entidad }}</strong>,@endif
                            @if($fidecomisario->persona->municipio)Municipio: <strong>{{ $fidecomisario->persona->municipio }}</strong>,@endif
                            @if($fidecomisario->persona->ciudad)Ciudad: <strong>{{ $fidecomisario->persona->ciudad }}</strong>,@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

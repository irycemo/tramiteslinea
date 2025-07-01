<div class="no-break">

    <p class="separador">fideicomiso</p>

    <p style=" margin-bottom: 8px;">
        <strong>Objeto principal del fideicomiso:</strong> {{ $aviso->descripcion_fideicomiso }}
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
                            @if($fiduciaria->persona->nacionalidad)<strong>Nacionalidad:</strong> {{ $fiduciaria->persona->nacionalidad }},@endif
                            @if($fiduciaria->persona->fecha_nacimiento)<strong>Fecha de nacimiento:</strong> {{ $fiduciaria->persona->fecha_nacimiento }},@endif
                            @if($fiduciaria->persona->estado_civil)<strong>Estado civil:</strong> {{ $fiduciaria->persona->estado_civil }},@endif
                            @if($fiduciaria->persona->calle)<strong>Calle:</strong> {{ $fiduciaria->persona->calle }},@endif
                            @if($fiduciaria->persona->numero_exterior)<strong>Número exterior:</strong> {{ $fiduciaria->persona->numero_exterior }},@endif
                            @if($fiduciaria->persona->numero_interior)<strong>Número interior:</strong> {{ $fiduciaria->persona->numero_interior }},@endif
                            @if($fiduciaria->persona->colonia)<strong>Colonia:</strong> {{ $fiduciaria->persona->colonia }},@endif
                            @if($fiduciaria->persona->cp)<strong>Código postal:</strong> {{ $fiduciaria->persona->cp }},@endif
                            @if($fiduciaria->persona->entidad)<strong>Entidad:</strong> {{ $fiduciaria->persona->entidad }},@endif
                            @if($fiduciaria->persona->municipio)<strong>Municipio:</strong> {{ $fiduciaria->persona->municipio }},@endif
                            @if($fiduciaria->persona->ciudad)<strong>Ciudad:</strong> {{ $fiduciaria->persona->ciudad }},@endif

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
                            @if($fideicomitente->persona->nacionalidad)<strong>Nacionalidad:</strong> {{ $fideicomitente->persona->nacionalidad }},@endif
                            @if($fideicomitente->persona->fecha_nacimiento)<strong>Fecha de nacimiento:</strong> {{ $fideicomitente->persona->fecha_nacimiento }},@endif
                            @if($fideicomitente->persona->estado_civil)<strong>Estado civil:</strong> {{ $fideicomitente->persona->estado_civil }},@endif
                            @if($fideicomitente->persona->calle)<strong>Calle:</strong> {{ $fideicomitente->persona->calle }},@endif
                            @if($fideicomitente->persona->numero_exterior)<strong>Número exterior:</strong> {{ $fideicomitente->persona->numero_exterior }},@endif
                            @if($fideicomitente->persona->numero_interior)<strong>Número interior:</strong> {{ $fideicomitente->persona->numero_interior }},@endif
                            @if($fideicomitente->persona->colonia)<strong>Colonia:</strong> {{ $fideicomitente->persona->colonia }},@endif
                            @if($fideicomitente->persona->cp)<strong>Código postal:</strong> {{ $fideicomitente->persona->cp }},@endif
                            @if($fideicomitente->persona->entidad)<strong>Entidad:</strong> {{ $fideicomitente->persona->entidad }},@endif
                            @if($fideicomitente->persona->municipio)<strong>Municipio:</strong> {{ $fideicomitente->persona->municipio }},@endif
                            @if($fideicomitente->persona->ciudad)<strong>Ciudad:</strong> {{ $fideicomitente->persona->ciudad }},@endif

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
                            @if($fidecomisario->persona->nacionalidad)<strong>Nacionalidad:</strong> {{ $fidecomisario->persona->nacionalidad }},@endif
                            @if($fidecomisario->persona->fecha_nacimiento)<strong>Fecha de nacimiento:</strong> {{ $fidecomisario->persona->fecha_nacimiento }},@endif
                            @if($fidecomisario->persona->estado_civil)<strong>Estado civil:</strong> {{ $fidecomisario->persona->estado_civil }},@endif
                            @if($fidecomisario->persona->calle)<strong>Calle:</strong> {{ $fidecomisario->persona->calle }},@endif
                            @if($fidecomisario->persona->numero_exterior)<strong>Número exterior:</strong> {{ $fidecomisario->persona->numero_exterior }},@endif
                            @if($fidecomisario->persona->numero_interior)<strong>Número interior:</strong> {{ $fidecomisario->persona->numero_interior }},@endif
                            @if($fidecomisario->persona->colonia)<strong>Colonia:</strong> {{ $fidecomisario->persona->colonia }},@endif
                            @if($fidecomisario->persona->cp)<strong>Código postal:</strong> {{ $fidecomisario->persona->cp }},@endif
                            @if($fidecomisario->persona->entidad)<strong>Entidad:</strong> {{ $fidecomisario->persona->entidad }},@endif
                            @if($fidecomisario->persona->municipio)<strong>Municipio:</strong> {{ $fidecomisario->persona->municipio }},@endif
                            @if($fidecomisario->persona->ciudad)<strong>Ciudad:</strong> {{ $fidecomisario->persona->ciudad }},@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

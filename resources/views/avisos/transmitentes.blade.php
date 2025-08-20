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
                            @if($transmitente->persona->nacionalidad)<strong>Nacionalidad:</strong> {{ $transmitente->persona->nacionalidad }},@endif
                            @if($transmitente->persona->fecha_nacimiento)<strong>Fecha de nacimiento:</strong> {{ $transmitente->persona->fecha_nacimiento }},@endif
                            @if($transmitente->persona->estado_civil)<strong>Estado civil:</strong> {{ $transmitente->persona->estado_civil }},@endif
                            @if($transmitente->persona->calle)<strong>Calle:</strong> {{ $transmitente->persona->calle }},@endif
                            @if($transmitente->persona->numero_exterior)<strong>Número exterior:</strong> {{ $transmitente->persona->numero_exterior }},@endif
                            @if($transmitente->persona->numero_interior)<strong>Número interior:</strong> {{ $transmitente->persona->numero_interior }},@endif
                            @if($transmitente->persona->colonia)<strong>Colonia:</strong> {{ $transmitente->persona->colonia }},@endif
                            @if($transmitente->persona->cp)<strong>Código postal:</strong> {{ $transmitente->persona->cp }},@endif
                            @if($transmitente->persona->entidad)<strong>Entidad:</strong> {{ $transmitente->persona->entidad }},@endif
                            @if($transmitente->persona->municipio)<strong>Municipio:</strong> {{ $transmitente->persona->municipio }},@endif
                            @if($transmitente->persona->ciudad)<strong>Ciudad:</strong> {{ $transmitente->persona->ciudad }},@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

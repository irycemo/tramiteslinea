<div class="no-break">

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
                            @if($adquiriente->persona->nacionalidad)<strong>Nacionalidad:</strong> {{ $adquiriente->persona->nacionalidad }},@endif
                            @if($adquiriente->persona->fecha_nacimiento)<strong>Fecha de nacimiento:</strong> {{ $adquiriente->persona->fecha_nacimiento }},@endif
                            @if($adquiriente->persona->estado_civil)<strong>Estado civil:</strong> {{ $adquiriente->persona->estado_civil }},@endif
                            @if($adquiriente->persona->calle)<strong>Calle:</strong> {{ $adquiriente->persona->calle }},@endif
                            @if($adquiriente->persona->numero_exterior)<strong>Número exterior:</strong> {{ $adquiriente->persona->numero_exterior }},@endif
                            @if($adquiriente->persona->numero_interior)<strong>Número interior:</strong> {{ $adquiriente->persona->numero_interior }},@endif
                            @if($adquiriente->persona->colonia)<strong>Colonia:</strong> {{ $adquiriente->persona->colonia }},@endif
                            @if($adquiriente->persona->cp)<strong>Código postal:</strong> {{ $adquiriente->persona->cp }},@endif
                            @if($adquiriente->persona->entidad)<strong>Entidad:</strong> {{ $adquiriente->persona->entidad }},@endif
                            @if($adquiriente->persona->municipio)<strong>Municipio:</strong> {{ $adquiriente->persona->municipio }},@endif
                            @if($adquiriente->persona->ciudad)<strong>Ciudad:</strong> {{ $adquiriente->persona->ciudad }},@endif

                        </p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

@if(count($predio->terrenos))

    <p class="separador">Terrenos</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Superficie</th>
                <th style="padding-right: 10px;">Demerito</th>
                <th style="padding-right: 10px;">Valor demeritado</th>
                <th style="padding-right: 10px;">Valor unitario</th>
                <th style="padding-right: 10px;">Valor de terreno</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->terrenos as $terreno)

                <tr >
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terreno->superficie }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terreno->demerito }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terreno->valor_demeritado }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terreno->valor_unitario }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">${{ number_format($terreno->valor_terreno, 2) }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endif

@if(count($predio->terrenosComun))

    <p class="separador">Terrenos de área común</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Superficie</th>
                <th style="padding-right: 10px;">Indiviso</th>
                <th style="padding-right: 10px;">Valor unitario</th>
                <th style="padding-right: 10px;">Superficie proporcional</th>
                <th style="padding-right: 10px;">Valor de terreno</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->terrenosComun as $terrenoComun)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terrenoComun->area_terreno_comun }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terrenoComun->indiviso_terreno }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terrenoComun->valor_unitario }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $terrenoComun->superficie_proporcional }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">${{ number_format($terrenoComun->valor_terreno_comun, 2) }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endif

@if(count($predio->construcciones))

    <p class="separador">Construcciones</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">referencia</th>
                <th style="padding-right: 10px;">superficie</th>
                <th style="padding-right: 10px;">Valor unitario</th>
                <th style="padding-right: 10px;">Valor construcción</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->construcciones as $construccion)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccion->referencia }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccion->superficie }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccion->valor_unitario }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">${{ number_format($construccion->valor_construccion, 2) }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endif

@if(count($predio->construccionesComun))

    <p class="separador">Construcciones de área común</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Superficie</th>
                <th style="padding-right: 10px;">superficie proporcional</th>
                <th style="padding-right: 10px;">Indiviso</th>
                <th style="padding-right: 10px;">Valor de clasificación</th>
                <th style="padding-right: 10px;">Valor construcción</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->construccionesComun as $construccionComun)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccionComun->area_comun_construccion }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccionComun->superficie_proporcional }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccionComun->indiviso_construccion }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">{{ $construccionComun->valor_clasificacion_construccion }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0;">${{ number_format($construccionComun->valor_construccion_comun, 2) }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endif
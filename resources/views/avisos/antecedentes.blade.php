<div class="no-break">

    <p class="separador">antecedentes</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px;">Folio real</th>
                <th style="padding-right: 10px;">movimiento registral</th>
                <th style="padding-right: 10px;">Tomo</th>
                <th style="padding-right: 10px;">registro</th>
                <th style="padding-right: 10px;">sección</th>
                <th style="padding-right: 10px;">distrito</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($aviso->antecedentes as $antecedente)

                <tr>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->folio_real ?? 'N/A' }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->movimiento_registral ?? 'N/A' }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->tomo ?? 'N/A' }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->registro ?? 'N/A' }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->seccion ?? 'N/A' }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $antecedente->distrito ?? 'N/A' }}</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

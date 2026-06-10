<p class="separador">Superficies y valor catastral</p>

<table style="width: 100%">
    <tbody  >
        <tr style="text-align: left;">
            <td style="width: 50%;">

                superficie notarial: <strong>{{ $predio->superficie_notarial_formateada }} @if($predio->tipo_predio == 1) Metros cuadrado; @else Hectáreas @endif</strong>

            </td>

        </tr>
        <tr style="text-align: left;">
            <td style="width: 50%;">

                Superficie de terreno: <strong>{{ $predio->superficie_total_terreno_formateada }} @if($predio->tipo_predio == 1) Metros cuadrado; @else Hectáreas @endif</strong>

            </td>
            <td style="width: 50%;">

                Superficie de construcción: <strong>{{ $predio->superficie_total_construccion_formateada }} Metros cuadrados</strong>

            </td>
        </tr>
    </tbody>

</table>

<table style="width: 100%">
    <tbody  >
        <tr style="text-align: left;">
            <td style="width: 50%;">

                @if ($predio->valor_total_terreno)
                    valor total de terreno: <strong>${{ number_format($predio->valor_total_terreno, 2) }}</strong>
                @endif

            </td>
            <td style="width: 50%;">

                @if ($predio->valor_total_construccion)
                    valor total de construcción: <strong>${{ number_format($predio->valor_total_construccion, 2) }}</strong>
                @endif

            </td>
        </tr>
    </tbody>

</table>

<p class="parrafo">
    Valor catastral: <strong>${{ number_format($predio->valor_catastral, 2) }}</strong>
</p>

<p class="separador">Superficies y valor catastral</p>

<p class="parrafo">

    <strong>Superficie de terreno:</strong>  {{ $predio->superficie_total_terreno_formateada }} @if($predio->tipo_predio == 1) Metros cuadrado; @else Hectáreas; @endif

    @if ($predio->superficie_construccion)

        <strong>Superficie de construcción:</strong> {{ $predio->superficie_total_construccion_formateada }} @if($predio->tipo_predio == 1) Metros cuadrados; @else Hectáreas; @endif

    @endif

    @if ($predio->superficie_judicial)
        <strong>superficie judicial:</strong>  {{ $predio->superficie_judicial_formateada }};
    @endif

    @if ($predio->superficie_notarial)
        <strong>superficie notarial:</strong> {{ $predio->superficie_notarial_formateada }};
    @endif

</p>

<p>

    @if ($predio->valor_total_terreno)
        <strong>valor total de terreno:</strong> ${{ number_format($predio->valor_total_terreno, 2) }};
    @endif

    @if ($predio->valor_total_construccion)
        <strong>valor total de construcción:</strong> ${{ number_format($predio->valor_total_construccion, 2) }};
    @endif

</p>

<p class="parrafo">
    <strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}
</p>

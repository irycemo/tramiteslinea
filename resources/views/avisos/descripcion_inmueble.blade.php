<p class="separador">Superficies y valor catastral</p>

<p class="parrafo">

    <strong>Superficie de terreno:</strong>  {{ $predio->superficie_terreno }}

    @if ($predio->superficie_construccion)

        <strong>Superficie de construcción:</strong> {{ $predio->superficie_construccion }} Metros cuadrados

    @endif

    @if ($predio->superficie_judicial)
        <strong>superficie judicial:</strong>  {{ $predio->superficie_judicial }};
    @endif

    @if ($predio->superficie_notarial)
        <strong>superficie notarial:</strong> {{ $predio->superficie_notarial }};
    @endif

    @if ($predio->area_comun_terreno)
        <strong>área de terreno común:</strong> {{ $predio->area_comun_terreno }} Metros cuadrados;
    @endif

    @if ($predio->area_comun_construccion)
        <strong>área de construcción común:</strong> {{ $predio->area_comun_construccion }} Metros cuadrados;
    @endif

    @if ($predio->valor_terreno_comun)
        <strong>valor de terreno común:</strong> {{ number_format($predio->valor_terreno_comun, 2) }};
    @endif

    @if ($predio->valor_construccion_comun)
        <strong>valor de construcción común:</strong> {{ number_format($predio->valor_construccion_comun, 2) }};
    @endif

    @if ($predio->valor_total_terreno)
        <strong>valor total de terreno:</strong> {{ number_format($predio->valor_total_terreno, 2) }};
    @endif

    @if ($predio->valor_total_construccion)
        <strong>valor total de construcción:</strong> {{ number_format($predio->valor_total_construccion, 2) }};
    @endif

</p>

<p class="parrafo">
    <strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}
</p>

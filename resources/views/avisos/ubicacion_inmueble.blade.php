<p class="separador">UBICACIÓN DEL INMUEBLE</p>

<p class="parrafo">

    @if ($predio->codigo_postal)
        <strong>CÓDIGO POSTAL:</strong> {{ $predio->codigo_postal }};
    @endif

    @if ($predio->tipo_asentamiento)
        <strong>TIPO DE ASENTAMIENTO:</strong> {{ $predio->tipo_asentamiento }};
    @endif

    @if ($predio->nombre_asentamiento)
        <strong>NOMBRE DEL ASENTAMIENTO:</strong> {{ $predio->nombre_asentamiento }};
    @endif

    @if ($predio->municipio)
        <strong>MUNICIPIO:</strong> {{ $predio->municipio }};
    @endif

    @if ($predio->localidad)
        <strong>LOCALIDAD:</strong> {{ $predio->localidad }};
    @endif

    @if ($predio->tipo_vialidad)
        <strong>TIPO DE VIALIDAD:</strong> {{ $predio->tipo_vialidad }};
    @endif

    @if ($predio->nombre_vialidad)
        <strong>NOMBRE DE LA VIALIDAD:</strong> {{ $predio->nombre_vialidad }};
    @endif

    @if ($predio->numero_exterior)
        <strong>NÚMERO EXTERIOR:</strong> {{ $predio->numero_exterior }};
    @endif

    @if ($predio->numero_interior)
        <strong>NÚMERO INTERIOR:</strong> {{ $predio->numero_interior }};
    @endif

    @if ($predio->nombre_edificio)
        <strong>EDIFICIO:</strong> {{ $predio->nombre_edificio }};
    @endif

    @if ($predio->clave_edificio)
        <strong>clave del edificio:</strong> {{ $predio->clave_edificio }};
    @endif

    @if ($predio->departamento_edificio)
        <strong>DEPARTAMENTO:</strong> {{ $predio->departamento_edificio }};
    @endif

    @if ($predio->numero_exterior_2)
        <strong>número exterior 2:</strong> {{ $predio->numero_exterior_2 }};
    @endif

    @if ($predio->numero_adicional)
        <strong>número adicional:</strong> {{ $predio->numero_adicional }};
    @endif

    @if ($predio->numero_adicional_2)
        <strong>número adicional 2:</strong> {{ $predio->numero_adicional_2 }};
    @endif

    @if ($predio->lote_fraccionador)
        <strong>lote del fraccionador:</strong> {{ $predio->lote_fraccionador }};
    @endif

    @if ($predio->manzana_fraccionador)
        <strong>manzana del fraccionador:</strong> {{ $predio->manzana_fraccionador }};
    @endif

    @if ($predio->etapa_fraccionador)
        <strong>etapa del fraccionador:</strong> {{ $predio->etapa_fraccionador }};
    @endif

    @if ($predio->ubicacion_en_manzana)
        <strong>ubicación en manzana:</strong> {{ $predio->ubicacion_en_manzana }};
    @endif

    @if ($predio->nombre_predio)
        <strong>Predio Rústico Denominado ó Antecedente:</strong> {{ $predio->nombre_predio }};
    @endif

    @if ($predio->observaciones)
        <strong>OBSERVACIONES:</strong> {{ $predio->observaciones }}.
    @endif

</p>

@if($predio->xutm || $predio->lat)

    <p class="parrafo">
        <strong>Coordenadas geográficas: </strong>
    </p>

    @if($predio->xutm)

        <p class="parrafo">

            <strong>UTM: </strong>
            <strong>X:</strong> {{ $predio->xutm }}, <strong>Y:</strong> {{ $predio->yutm }},  <strong>Z:</strong> {{ $predio->zutm }}

            @if($predio->xutm)

                 | <strong>GEO: </strong>
                <strong>LAT:</strong> {{ $predio->lat }}, <strong>LON:</strong> {{ $predio->lon }}

            @endif

        </p>

    @endif

@endif
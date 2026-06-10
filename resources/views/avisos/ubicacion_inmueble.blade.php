<p class="separador">UBICACIÓN DEL INMUEBLE</p>

<div>

    @if ($predio->tipo_vialidad)
        <span>TIPO DE VIALIDAD: <strong>{{ $predio->tipo_vialidad }}</strong></span>
    @endif

    @if ($predio->nombre_vialidad)
        <span style="padding-left: 5px;">NOMBRE DE LA VIALIDAD: <strong>{{ $predio->nombre_vialidad }}</strong></span>
    @endif

    @if ($predio->numero_exterior)
        <span style="padding-left: 5px;">NÚMERO EXTERIOR: <strong>{{ $predio->numero_exterior }}</strong></span>
    @endif

    @if ($predio->numero_interior)
        <span style="padding-left: 5px;">NÚMERO INTERIOR: <strong>{{ $predio->numero_interior }}</strong></span>
    @endif

    @if ($predio->numero_exterior_2)
        <span style="padding-left: 5px;">número exterior 2: <strong>{{ $predio->numero_exterior_2 }}</strong></span>
    @endif

    @if ($predio->numero_adicional)
        <span style="padding-left: 5px;">número adicional: <strong>{{ $predio->numero_adicional }}</strong></span>
    @endif

    @if ($predio->numero_adicional_2)
        <span style="padding-left: 5px;">número adicional 2: <strong>{{ $predio->numero_adicional_2 }}</strong></span>
    @endif

    @if ($predio->tipo_asentamiento)
        <span style="padding-left: 5px;">TIPO DE ASENTAMIENTO: <strong>{{ $predio->tipo_asentamiento }}</strong></span>
    @endif

    @if ($predio->nombre_asentamiento)
        <span style="padding-left: 5px;">NOMBRE DEL ASENTAMIENTO: <strong>{{ $predio->nombre_asentamiento }}</strong></span>
    @endif

    @if ($predio->codigo_postal)
        <span style="padding-left: 5px;">CÓDIGO POSTAL: <strong>{{ $predio->codigo_postal }}</strong></span>
    @endif

</div>

<p class="parrafo">

    @if ($predio->nombre_edificio)
        EDIFICIO: <strong>{{ $predio->nombre_edificio }}</strong>
    @endif

    @if ($predio->clave_edificio)
        clave del edificio: <strong>{{ $predio->clave_edificio }}</strong>
    @endif

    @if ($predio->departamento_edificio)
        DEPARTAMENTO: <strong>{{ $predio->departamento_edificio }}</strong>
    @endif

    @if ($predio->lote_fraccionador)
        lote del fraccionador: <strong>{{ $predio->lote_fraccionador }}</strong>
    @endif

    @if ($predio->manzana_fraccionador)
        manzana del fraccionador: <strong>{{ $predio->manzana_fraccionador }}</strong>
    @endif

    @if ($predio->etapa_fraccionador)
        etapa del fraccionador: <strong>{{ $predio->etapa_fraccionador }}</strong>
    @endif

    @if ($predio->ubicacion_en_manzana)
        ubicación en manzana: <strong>{{ $predio->ubicacion_en_manzana }}</strong>
    @endif

    @if ($predio->nombre_predio)
        Predio Rústico Denominado ó Antecedente: <strong>{{ $predio->nombre_predio }}</strong>
    @endif

</p>

<p class="parrafo">

    @if ($predio->municipio)
        MUNICIPIO: <strong>{{ $datos_control->municipio ?? $predio->municipio }}</strong>
    @endif

    @if ($predio->localidad)
        LOCALIDAD: <strong>{{ $datos_control->oficina ?? $predio->localidad }}</strong>
    @endif

</p>

@if($predio->xutm || $predio->lat)

    Coordenadas geográficas:

    <table style="width: 100%;">

        <tbody>
            <tr>
                <td style="text-align: left;">

                    UTM
                    X: <strong>{{ $predio->xutm }}</strong>, Y: <strong>{{ $predio->yutm }}</strong>, Z: <strong>{{ $predio->zutm }}</strong>

                </td>
                <td style="">

                    GEO
                    LAT: <strong>{{ $predio->lat }}</strong>, LON: <strong>{{ $predio->lon }}</strong>

                </td>
            </tr>
        </tbody>

    </table>

@endif
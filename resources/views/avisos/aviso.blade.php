<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aviso</title>
</head>
<style>

    /* @page {
        margin: 0cm 0cm;
    } */


    header{
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;
        text-align: center;
    }

    .encabezado{
        height: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }


    body{
        margin-top: 120px;
        counter-reset: page;
        height: 100%;
        background-image: url("storage/img/escudo_fondo.png");
        background-size: cover;
        font-family: sans-serif;
        font-weight: normal;
        line-height: 1.5;
        text-transform: uppercase;
        font-size: 10px;
    }

    .titulo{
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    .fundamento{
        text-align: justify;
        font-size: 10px;
    }

    .separador{
        text-align: justify;
        border-bottom: 1px solid black;
        padding: 0 20px 0 20px;
        border-radius: 25px;
        border-color: gray;
        letter-spacing: 5px;
        margin: 0 0 5px 0;
    }

    .informacion{
        padding: 0 20px 0 20px;
        margin-bottom: 10px;
    }

    .informacion p{
        margin: 0;
    }

    table{
        margin-bottom: 5px;
        margin-left: auto;
        margin-right: auto;
    }

    footer{
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        background: #5E1D45;
        color: white;
        font-size: 12px;
        text-transform: lowercase;
    }

    .fot{
        padding: 2px;
    }

    .fot p{
        text-align: center;
        margin: 0;
        margin-left: 10px;
    }

    .qr{
        display: block;
    }

    .caracteristicas-tabla{
        page-break-inside: avoid;
    }

    .totales{
        flex: auto;
    }

    .imagenes{
        width: 200px;
    }

    .borde{
        display: inline;
        border-top: 1px solid;
    }

</style>
<body >

    <header>

            <img class="encabezado" src="{{ public_path('storage/img/encabezado.png') }}" alt="encabezado">

    </header>

    <footer>

        <div class="fot">
            <p>www.irycem.michoacan.gob.mx</p>
        </div>

    </footer>

    <main>

        <div>

            <p class="titulo">Aviso de modificación de inmuebles</p>

            <p class="fundamento">
                c.c. tesorero municipal y/o autoridad catastral de {{ $municipio }}, michoacán en cumplimiento de lo dispuesto en el artículo 56 y demas relativos a la ley de hacienda municipal vigente del estado. asi como el artículo 85 de la ley de la función registral y catastral de estado de michoacán, manifiesto a usted:
            </p>

        </div>

        <p class="separador">Información general</p>

        <div class="informacion" >

            <table style="width: 100%">

                <thead>

                    <tr>
                        <th style="text-align: left;">Folio</th>
                        <th style="text-align: left;">Declarante</th>
                        <th style="text-align: left;">Clave catastral</th>
                        <th style="text-align: left;">cuenta predial</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td style="padding-right: 40px;">
                            <p>{{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }}</p>
                        </td>
                        <td style="padding-right: 40px;">
                            <p>{{ $aviso->entidad->titular->name }}</p>
                        </td>
                        <td>
                            <p>{{ $aviso->claveCatastral() }}</p>
                        </td>

                        <td>
                            <p>{{ $aviso->cuentaPredial() }}</p>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <p class="separador">Acto / Escritura</p>

        <div class="informacion" >

            <p><strong>Acto transmitivo de dominio:</strong> {{ $aviso->acto }}</p>
            <p><strong>Para el caso de adquisición por resolución judicial, fecha en la que causo ejecutoria:</strong> {{ $aviso->fecha_ejecutoria }}</p>
            <p>
                <strong>Tipo de escritura:</strong> {{ $aviso->tipo_escritura }},
                <strong>Número de escritura:</strong> {{ $aviso->numero_escritura }},
                <strong>Volumen de escritura:</strong> {{ $aviso->volumen_escritura }}
            </p>
            <p>
                <strong>Lugar de otorgamiento:</strong> {{ $aviso->lugar_otorgamiento }},
                <strong>Fecha de otorgamiento:</strong> {{ $aviso->fecha_otorgamiento }}
            </p>
            <p>
                <strong>Lugar de firma:</strong> {{ $aviso->lugar_firma }},
                <strong>Fecha de firma:</strong> {{ $aviso->fecha_firma }}
            </p>

        </div>

        <p class="separador">Identificación del inmueble</p>

        <div class="informacion" >

            <p style=" margin-bottom: 8px;">
                @if($aviso->tipo_asentamiento)<strong>Tipo de asentamiento:</strong> {{ $aviso->tipo_asentamiento }},@endif
                @if($aviso->nombre_asentamiento)<strong>Nombre del asentamiento:</strong> {{ $aviso->nombre_asentamiento }},@endif
                @if($aviso->tipo_vialidad)<strong>Tipo de vialidad:</strong> {{ $aviso->tipo_vialidad }},@endif
                @if($aviso->nombre_vialidad)<strong>Nombre de la vialidad:</strong> {{ $aviso->nombre_vialidad }},@endif
                @if($aviso->numero_interior)<strong>Número interior:</strong> {{ $aviso->numero_interior }},@endif
                @if($aviso->numero_exterior)<strong>Número exterior:</strong> {{ $aviso->numero_exterior }},@endif
                @if($aviso->numero_exterior_2)<strong>Número exterior 2:</strong> {{ $aviso->numero_exterior_2 }},@endif
                @if($aviso->numero_adicional)<strong>Número adicional:</strong> {{ $aviso->numero_adicional }},@endif
                @if($aviso->numero_adicional_2)<strong>Número adicional 2:</strong> {{ $aviso->numero_adicional_2 }},@endif
                @if($aviso->codigo_postal)<strong>Código postal:</strong> {{ $aviso->codigo_postal }}@endif
            </p>

            <p style=" margin-bottom: 8px;">
                @if($aviso->nombre_edificio)<strong>Nombre del edificio:</strong> {{ $aviso->nombre_edificio }},@endif
                @if($aviso->clave_edificio)<strong>Clave del edificio:</strong> {{ $aviso->clave_edificio }},@endif
                @if($aviso->departamento_edificio)<strong>Departamento:</strong> {{ $aviso->departamento_edificio }}@endif
            </p>

            <p style=" margin-bottom: 8px;">
                @if($aviso->lote_fraccionador)<strong>Lote del fraccionador:</strong> {{ $aviso->lote_fraccionador }},@endif
                @if($aviso->manzana_fraccionador)<strong>Manzana del fraccionador:</strong> {{ $aviso->manzana_fraccionador }},@endif
                @if($aviso->etapa_fraccionador)<strong>Etapa del fraccionador:</strong> {{ $aviso->etapa_fraccionador }}@endif
                @if($aviso->ubicacion_en_manzana)<strong>Ubicación del aviso en la manzana:</strong> {{ $aviso->ubicacion_en_manzana }}@endif
            </p>

            <p style="">
                @if($aviso->nombre_aviso)<strong>aviso Rústico Denominado ó Antecedente:</strong> {{ $aviso->nombre_aviso }}@endif
            </p>

            @if($aviso->xutm || $aviso->lat)

                <p style=" margin-top: 8px;">
                    <strong>Coordenadas geográficas: </strong>
                </p>

                @if($aviso->xutm)

                        <strong>UTM: </strong>
                        <strong>X:</strong> {{ $aviso->xutm }}, <strong>Y:</strong> {{ $aviso->yutm }},  <strong>Z:</strong> {{ $aviso->zutm }}

                @endif

                @if($aviso->xutm)
                    <p style="">
                        <strong>GEO: </strong>
                        <strong>LAT:</strong> {{ $aviso->lat }}, <strong>LON:</strong> {{ $aviso->lon }}
                    </p>
                @endif

            @endif

        </div>

        <p class="separador">Colindancias</p>

        <div class="informacion" >

            <table>

                <thead>

                    <tr>
                        <th style="text-align: left;">Viento</th>
                        <th style="text-align: left;">Longitud</th>
                        <th style="text-align: left;">Descripción</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($aviso->colindancias as $colindancia)

                        <tr>
                            <td style="padding-right: 40px;">
                                <p>{{ $colindancia->viento }}</p>
                            </td>
                            <td style="padding-right: 40px;">
                                <p>{{ number_format($colindancia->longitud, 2) }} mts.</p>
                            </td>
                            <td>
                                <p>{{ $colindancia->descripcion }}</p>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <p class="separador">Superficies y valor catastral</p>

        <div class="informacion">

            <p style=" margin: 4px 0 4px 0;">
                @if($aviso->superficie_terreno > 0)<strong>Superficie de terreno:</strong> {{ number_format($aviso->superficie_terreno, 2) }},@endif
                @if($aviso->superficie_construccion > 0)<strong>Superficie de construcción:</strong> {{ number_format($aviso->superficie_construccion, 2) }},@endif
            </p>

            <p><strong>Valor catastral: </strong>${{ number_format($aviso->valor_catastral, 2) }}</p>

        </div>

        <p class="separador">Transmitentes</p>

        <div class="informacion">

            <table style="width: 100%">

                <thead>

                    <tr>
                        <th style="text-align: left;">Tipo de persona</th>
                        <th style="text-align: left;">Nombre / Razón social</th>
                        <th style="text-align: left;">% de propiedad</th>
                        <th style="text-align: left;">% de nuda</th>
                        <th style="text-align: left;">% de usufructo</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($aviso->transmitentes() as $transmitente)

                        <tr>
                            <td style="padding-right: 40px;">
                                <p>{{ $transmitente->persona->tipo }}</p>
                            </td>
                            <td style="padding-right: 40px;">
                                <p>{{ $transmitente->persona->nombre }} {{ $transmitente->persona->ap_paterno }} {{ $transmitente->persona->ap_materno }} {{ $transmitente->persona->razon_social }}</p>
                            </td>
                            <td>
                                <p>{{ $transmitente->porcentaje ?? 0 }}</p>
                            </td>
                            <td>
                                <p>{{ $transmitente->porcentaje_nuda ?? 0 }}</p>
                            </td>
                            <td>
                                <p>{{ $transmitente->porcentaje_usufructo ?? 0 }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="5" style="border-bottom: 0.5px solid gray">
                                <strong>Generales:</strong>
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

        <p class="separador">Adquirientes</p>

        <div class="informacion">

            <table style="width: 100%">

                <thead>

                    <tr>
                        <th style="text-align: left;">Tipo de persona</th>
                        <th style="text-align: left;">Nombre / Razón social</th>
                        <th style="text-align: left;">% de propiedad</th>
                        <th style="text-align: left;">% de nuda</th>
                        <th style="text-align: left;">% de usufructo</th>
                    </tr>

                </thead>

                <tbody >

                    @foreach ($aviso->adquirientes() as $adquiriente)

                        <tr >
                            <td style="padding-right: 40px;">
                                <p>{{ $adquiriente->persona->tipo }}</p>
                            </td>
                            <td style="padding-right: 40px;">
                                <p>{{ $adquiriente->persona->nombre }} {{ $adquiriente->persona->ap_paterno }} {{ $adquiriente->persona->ap_materno }} {{ $adquiriente->persona->razon_social }}</p>
                            </td>
                            <td>
                                <p>{{ $adquiriente->porcentaje ?? 0 }}</p>
                            </td>
                            <td>
                                <p>{{ $adquiriente->porcentaje_nuda ?? 0 }}</p>
                            </td>
                            <td>
                                <p>{{ $adquiriente->porcentaje_usufructo ?? 0 }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="5" style="border-bottom: 0.5px solid gray">
                                <strong>Generales:</strong>
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

        <p class="separador">Antecedentes</p>

        <div class="informacion">

            <table style="width: 100%">

                <thead>

                    <tr>
                        <th style="text-align: left;">Tomo</th>
                        <th style="text-align: left;">Registro</th>
                        <th style="text-align: left;">Sección</th>
                        <th style="text-align: left;">Distrito</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($aviso->antecedentes as $antecedente)

                        <tr>
                            <td style="padding-right: 40px;">
                                <p>{{ $antecedente->tomo }}</p>
                            </td>
                            <td style="padding-right: 40px;">
                                <p>{{ $antecedente->registro }}</p>
                            </td>
                            <td>
                                <p>{{ $antecedente->seccion }}</p>
                            </td>
                            <td>
                                <p>{{ $antecedente->distrito }}</p>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="5" style="border-bottom: 0.5px solid gray">
                                <strong>Acto:</strong><p>{{ $antecedente->acto }}</p>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <p class="separador">Fideicomisos</p>

        <div class="informacion">

            @if($aviso->fiduciaria()->count())

                <p style="text-align: center">Fiduciaria</p>

                <table style="width: 100%">

                    <thead>

                        <tr>
                            <th style="text-align: left;">Tipo de persona</th>
                            <th style="text-align: left;">Nombre / Razón social</th>
                            <th style="text-align: left;">% de propiedad</th>
                            <th style="text-align: left;">% de nuda</th>
                            <th style="text-align: left;">% de usufructo</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($aviso->fiduciaria() as $fiduciaria)

                            <tr>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fiduciaria->persona->tipo }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fiduciaria->persona->nombre }} {{ $fiduciaria->persona->ap_paterno }} {{ $fiduciaria->persona->ap_materno }} {{ $fiduciaria->persona->razon_social }}</p>
                                </td>
                                <td>
                                    <p>{{ $fiduciaria->porcentaje ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fiduciaria->porcentaje_nuda ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fiduciaria->porcentaje_usufructo ?? 0 }}</p>
                                </td>
                            </tr>
                            <tr >
                                <td colspan="5" style="border-bottom: 0.5px solid gray">
                                    <strong>Generales:</strong>
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

            @endif

            @if($aviso->fideicomitentes()->count())

                <p style="text-align: center">Fideicomitentes</p>

                <table style="width: 100%">

                    <thead>

                        <tr>
                            <th style="text-align: left;">Tipo de persona</th>
                            <th style="text-align: left;">Nombre / Razón social</th>
                            <th style="text-align: left;">% de propiedad</th>
                            <th style="text-align: left;">% de nuda</th>
                            <th style="text-align: left;">% de usufructo</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($aviso->fideicomitentes() as $fideicomitente)

                            <tr>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fideicomitente->persona->tipo }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fideicomitente->persona->nombre }} {{ $fideicomitente->persona->ap_paterno }} {{ $fideicomitente->persona->ap_materno }} {{ $fideicomitente->persona->razon_social }}</p>
                                </td>
                                <td>
                                    <p>{{ $fideicomitente->porcentaje ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fideicomitente->porcentaje_nuda ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fideicomitente->porcentaje_usufructo ?? 0 }}</p>
                                </td>
                            </tr>
                            <tr >
                                <td colspan="5" style="border-bottom: 0.5px solid gray">
                                    <strong>Generales:</strong>
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

            @endif

            @if($aviso->fideicomisarios()->count())

                <p style="text-align: center">Fideicomitentes</p>

                <table style="width: 100%">

                    <thead>

                        <tr>
                            <th style="text-align: left;">Tipo de persona</th>
                            <th style="text-align: left;">Nombre / Razón social</th>
                            <th style="text-align: left;">% de propiedad</th>
                            <th style="text-align: left;">% de nuda</th>
                            <th style="text-align: left;">% de usufructo</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($aviso->fideicomisarios() as $fidecomisario)

                            <tr>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fidecomisario->persona->tipo }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ $fidecomisario->persona->nombre }} {{ $fidecomisario->persona->ap_paterno }} {{ $fidecomisario->persona->ap_materno }} {{ $fidecomisario->persona->razon_social }}</p>
                                </td>
                                <td>
                                    <p>{{ $fidecomisario->porcentaje ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fidecomisario->porcentaje_nuda ?? 0 }}</p>
                                </td>
                                <td>
                                    <p>{{ $fidecomisario->porcentaje_usufructo ?? 0 }}</p>
                                </td>
                            </tr>
                            <tr >
                                <td colspan="5" style="border-bottom: 0.5px solid gray">
                                    <strong>Generales:</strong>
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

            @endif

            <p style=" margin-bottom: 8px;">
                @if($aviso->descripcion_fideicomiso)<strong>Objeto principal del fideicomiso:</strong> {{ $aviso->descripcion_fideicomiso }}@endif
            </p>

        </div>

        <p class="separador">Croquis / I.S.A.I.</p>

        <div class="informacion">

            <table style="width: 100%">

                <thead>

                    <tr>
                        <th style="text-align: center;">Croquis</th>
                        <th style="text-align: center;">I.S.A.I.</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td style="padding-right: 40px;">
                            <img class="imagenes" src="{{ public_path('avisos/' . $aviso->croquis->url) }}" alt="Croquis">
                        </td>
                        <td style="padding-right: 40px;">

                            <table style="width: 100%">

                                <thead>

                                    <tr>
                                        <th style="text-align: left;"></th>
                                        <th style="text-align: left;"></th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Base gravable:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->base_gravable, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Reducción:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->reduccion, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Valor base:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->valor_base, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Valor isai:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->valor_isai, 2) }}
                                        </td>
                                    </tr>

                                    <tr></tr>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Valor de adquisición:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->valor_adquisicion, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-right: 40px;">
                                            <strong>Valor de avalúo:</strong>
                                        </td>
                                        <td style="padding-right: 40px; text-align: right;">
                                            ${{ number_format($aviso->valor_catastral, 2) }}
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        @if($aviso->observaciones)

            <p class="separador">Observaciones</p>

            <div class="informacion">

                <p>{{ $aviso->observaciones }}</p>

            </div>

        @endif

        <table style="width: 100%; margin-bottom: 20px;" class="caracteristicas-tabla">

            <thead>

                <tr>
                    <th style="text-align: center; padding-right: 40px;">Firma</th>
                    <th style="text-align: center; padding-right: 40px;">Sello</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td style="padding-right: 40px; text-align: center;">

                        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">
                            @if($aviso->entidad->titular)
                                {{ $aviso->entidad->titular->name }}
                            @else
                                {{ $aviso->entidad->dependencia }}
                            @endif
                        </p>
                        @if($aviso->entidad->numero_notaria)
                            <p style="text-align: center; margin: 0" >Notaria {{ $aviso->entidad->numero_notaria }}</p>
                            <p style="text-align: center; margin: 0" >{{ $aviso->entidad->titular->rfc }}</p>
                        @endif
                    </td>
                </tr>

            </tbody>

        </table>

        <div class="informacion caracteristicas-tabla">
            <p><strong>Impreso el:</strong> {{ now()->format('d-m-Y H:i:s') }} <strong>Impreso por:</strong> {{ auth()->user()->name }}</p>
        </div>

    </main>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aviso</title>
</head>

<style>
    header{
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;
        text-align: center;
    }

    header img{
        height: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }


    body{
        margin-top: 120px;
        margin-bottom: 40px;
        counter-reset: page;
        height: 100%;
        background-image: url("storage/img/escudo_fondo.png");
        background-size: cover;
        background-position: 0 -50px !important;
        font-family: sans-serif;
        font-weight: normal;
        line-height: 1.5;
        text-transform: uppercase;
        font-size: 9px;
    }

    .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    .container{
        display: flex;
        align-content: space-around;
    }

    .parrafo{
        text-align: justify;
    }

    .firma{
        text-align: center;
    }

    .control{
        text-align: center;
    }

    .atte{
        margin-bottom: 10px;
    }

    .borde{
        display: inline;
        border-top: 1px solid;
    }

    .tabla{
        width: 100%;
        font-size: 10px;
        margin-bottom: 30px;;
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
        text-align: right;
        padding-right: 10px;
        text-transform: lowercase;
    }

    .fot{
        display: flex;
        padding: 2px;
        text-align: center;
    }

    .fot p{
        display: inline-block;
        width: 33%;
        margin: 0;
    }

    .qr{
        display: block;
    }

    .no-break{
        page-break-inside: avoid;
    }

    table{
        margin-bottom: 5px;
        margin-left: auto;
        margin-right: auto;
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

    .titulo{
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        margin: 0;
    }

</style>

<body>

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
                c.c. tesorero municipal y/o autoridad catastral de {{ $predio->municipio }}, michoacán en cumplimiento de lo dispuesto en el artículo 56 y demas relativos a la ley de hacienda municipal vigente del estado. asi como el artículo 85 de la ley de la función registral y catastral de estado de michoacán, manifiesto a usted:
            </p>

        </div>

        <p class="separador">Información general</p>

        <div class="informacion" >

            <p>
                <strong>Folio del aviso:</strong> {{ $aviso->año }}-{{ $aviso->folio }}-{{ $aviso->usuario }},

                <strong>Declarante:</strong>

                @if($aviso->entidad->numero_notaria)
                    {{ $aviso->entidad->notarioTitular->name }}
                @else
                    {{ $aviso->entidad->dependencia }}
                @endif,

                <strong>cuenta predial:</strong> {{ $aviso->predio->cuentaPredial() }},

                <strong>Clave catastral:</strong> {{ $aviso->predio->claveCatastral() }}
            </p>

        </div>

        <p class="separador">Acto / Escritura</p>

        <div class="informacion" >

            <p><strong>Acto transmitivo de dominio:</strong> {{ $aviso->acto }}</p>
            <p><strong>Para el caso de adquisición por resolución judicial, fecha en la que causo ejecutoria: </strong> {{ $aviso->fecha_ejecutoria }}</p>
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

        @include('avisos.ubicacion_inmueble')

        @include('avisos.colindancias')

        @include('avisos.descripcion_inmueble')

        @include('avisos.transmitentes')

        @include('avisos.adquirientes')

        @if($aviso->antecedentes->count())

            @include('avisos.antecedentes')

        @endif

        @if($aviso->descripcion_fideicomiso)

            @include('avisos.fideicomiso')

        @endif

        @if($aviso->valor_isai)

            <div class="no-break">

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
                                                <td style="text-align: right;">
                                                    <strong>Base gravable:</strong>
                                                </td>
                                                <td style="padding-right: 40px; text-align: right;">
                                                    ${{ number_format($aviso->base_gravable, 2) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong>Reducción:</strong>
                                                </td>
                                                <td style="padding-right: 40px; text-align: right;">
                                                    ${{ number_format($aviso->reduccion, 2) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong>Valor base:</strong>
                                                </td>
                                                <td style="padding-right: 40px; text-align: right;">
                                                    ${{ number_format($aviso->valor_base, 2) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong>Valor isai:</strong>
                                                </td>
                                                <td style="padding-right: 40px; text-align: right;">
                                                    ${{ number_format($aviso->valor_isai, 2) }}
                                                </td>
                                            </tr>

                                            <tr></tr>

                                            <tr>
                                                <td style="text-align: right;">
                                                    <strong>Valor de adquisición:</strong>
                                                </td>
                                                <td style="padding-right: 40px; text-align: right;">
                                                    ${{ number_format($aviso->valor_adquisicion, 2) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="text-align: right;">
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

            </div>

        @endif

        @if($aviso->observaciones)

            <p class="separador">Observaciones</p>

            <div class="informacion">

                <p>{{ $aviso->observaciones }}</p>

            </div>

        @endif

        <div class="no-break">

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
                                @if($aviso->entidad->numero_notaria)
                                    {{ $aviso->entidad->notarioTitular->name }}
                                @else
                                    {{ $aviso->entidad->dependencia }}
                                @endif
                            </p>
                            @if($aviso->entidad->numero_notaria)
                                <p style="text-align: center; margin: 0" >Notaria {{ $aviso->entidad->numero_notaria }}</p>
                                {{-- <p style="text-align: center; margin: 0" >{{ $aviso->entidad->titular->rfc }}</p> --}}
                            @endif
                        </td>
                    </tr>

                </tbody>

            </table>

            <div class="informacion caracteristicas-tabla">
                <p><strong>Impreso el:</strong> {{ $datos_control->impreso_en }}</p>
                <p><strong>Impreso por:</strong> {{ $datos_control->impreso_por }}</p>
            </div>

        </div>

    </main>

</body>
</html>

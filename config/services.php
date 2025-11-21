<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'flag' => env('AWS_FLAG'),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'peritos_externos' => [
        'token' => env('SISTEMA_PERITOS_EXTERNOS_TOKEN'),
        'consultar_avaluo' => env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'),
        'reactivar_avaluo' => env('SISTEMA_PERITOS_EXTERNOS_REACTIVAR_AVALUO'),
        'generar_avaluo_pdf' => env('SISTEMA_PERITOS_EXTERNOS_GENERAR_AVALUO_PDF'),
    ],

    'sgc' => [
        'token' => env('SGC_TOKEN'),
        'consultar_predio' => env('SGC_CONSULTAR_PREDIO'),
        'consultar_cuenta_predial' => env('SGC_CONSULTAR_CUENTA_PREDIAL'),
        'consultar_certificado_catastral' => env('SGC_CONSULTAR_CERTIFICADO_CATASTRAL'),
        'consultar_propietarios' => env('SGC_CONSULTAR_PROPIETARIOS'),
        'consultar_propietarios_predio_id' => env('SGC_CONSULTAR_PROPIETARIOS_PREDIO_ID'),
        'consultar_tramite_id' => env('SGC_CONSULTAR_TRAMITE_ID'),
        'consultar_tramite_aviso' => env('SGC_CONSULTAR_TRAMITE_AVISO'),
        'consultar_tramite_aviso_aclaratorio' => env('SGC_CONSULTAR_TRAMITE_AVISO_ACLARATORIO'),
        'consultar_certificado_aviso' => env('SGC_CONSULTAR_CERTIFICADO_AVISO'),
        'consultar_rechazos' => env('SGC_CONSULTAR_RECHAZOS'),
        'consultar_tramites' => env('SGC_CONSULTAR_TRAMITES'),
        'consultar_servicios' => env('SGC_CONSULTAR_SERVICIOS'),
        'consultar_certificados' => env('SGC_CONSULTAR_CERTIFICADOS'),
        'consultar_estadisticas' => env('SGC_CONSULTAR_ESTADISTICAS'),
        'consultar_oficinas' => env('SGC_CONSULTAR_OFICINAS'),
        'ingresar_aviso_aclaratorio' => env('SGC_INGRESAR_AVISO_ACLARATORIO'),
        'ingresar_revision_aviso' => env('SGC_INGRESAR_REVISION_AVISO'),
        'inactivarTraslado' => env('SGC_INACTIVAR_TRASLADO'),
        'crear_tramite' => env('SGC_CREAR_TRAMITE'),
        'crear_requerimiento' => env('SGC_CREAR_REQUERIMIENTO'),
        'generar_certificado_pdf' => env('SGC_GENERAR_CERTIFICADO_PDF'),
        'acreditar_pago' => env('SGC_ACREDITAR_PAGO'),
    ],

    'sap' => [
        'secret_key' => env('SAP_SECRET_KEY'),
        'secret_iv' => env('SAP_SECRET_IV'),
        'link_pago_linea' => env('SAP_PAGO_LINEA_URL'),
    ],

    'sistema_tramites' => [
        'token' => env('SISTEMA_TRAMITES_TOKEN'),
        'acreditar_pago' => env('SISTEMA_TRAMITES_ACREDITAR_PAGO'),
        'crear_tramite' => env('SISTEMA_TRAMITES_CREAR_TRAMITE'),
        'consultar_servicios' => env('SISTEMA_TRAMITES_CONSULTAR_SERVICIOS'),
        'consultar_tramites' => env('SISTEMA_TRAMITES_CONSULTAR_TRAMITES'),
    ],

    'sistema_rpp' => [
        'token' => env('SISTEMA_RPP_TOKEN'),
        'consultar_folio_real' => env('SISTEMA_RPP_CONSULTAR_FOLIO_REAL'),
        'consultar_antecedentes' => env('SISTEMA_RPP_CONSULTAR_ANTECEDENTES'),
        'generar_certificado_gravamen_pdf' => env('SISTEMA_RPP_GENERAR_CERTIFICADO_GRAVAMEN_PDF'),
        'consultar_certificados' => env('SISTEMA_RPP_CONSULTAR_CERTIFICADOS_GRAVAMEN'),
        'consultar_estadisticas' => env('SISTEMA_RPP_CONSULTAR_ESTADISTICAS'),
    ],

];

<?php

namespace App\Traits;

trait SapTrait
{

    public function encrypt_decrypt(string $action, string $string): string
    {

        $output = false;

        $encrypt_method = "AES-256-CBC";

        $secret_key = config('services.sap.secret_key');

        $secret_iv = config('services.sap.secret_iv');

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ( $action == 'encrypt' ) {

            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

            $output = base64_encode($output);

        } else if( $action == 'decrypt' ) {

            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        }

        return $output;

    }

    public function getToken(string $linea_captura, int $monto, string $fecha_vencimiento):string
    {

        $output = false;

        $string = $linea_captura . $monto . config('services.sap.concepto') . $fecha_vencimiento;

        $encrypt_method = "AES-256-CBC";

        $secret_key = config('services.sap.secret_key');

        $secret_iv = config('services.sap.secret_iv');

        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

        return $output;

    }

}

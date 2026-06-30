<?php
class FirmaDigital
{
    private static string $rutaPrivada = __DIR__ . '/llaves/privada.pem';
    private static string $rutaPublica = __DIR__ . '/llaves/publica.pem';

    public static function asegurarLlaves(): void
    {
        $carpeta = __DIR__ . '/llaves';
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0700, true);
        }
        if (!file_exists(self::$rutaPrivada) || !file_exists(self::$rutaPublica)) {

            // Buscar el archivo openssl.cnf en ubicaciones comunes de WAMP/XAMPP
            $posiblesRutas = [
                'C:\\wamp64\\bin\\apache\\apache2.4.65\\conf\\openssl.cnf',
                'C:\\wamp64\\bin\\php\\php8.3.28\\extras\\ssl\\openssl.cnf',
                'C:\\wamp64\\bin\\php\\php8.3.28\\openssl.cnf',
                'C:\\xampp\\apache\\conf\\openssl.cnf',
                'C:\\xampp\\php\\extras\\ssl\\openssl.cnf',
            ];

            $rutaCnf = null;
            foreach ($posiblesRutas as $ruta) {
                if (file_exists($ruta)) {
                    $rutaCnf = $ruta;
                    break;
                }
            }

            $configuracion = [
                'private_key_bits' => 2048,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ];

            if ($rutaCnf !== null) {
                $configuracion['config'] = $rutaCnf;
            }

            $recurso = openssl_pkey_new($configuracion);

            if ($recurso === false) {
                $error = openssl_error_string();
                die("No se pudo generar la llave OpenSSL. Verifica la ruta de openssl.cnf "
                    . "en config/FirmaDigital.php. Error OpenSSL: " . ($error ?: 'desconocido'));
            }

            openssl_pkey_export($recurso, $llavePrivada, null, ['config' => $rutaCnf]);
            $detalles = openssl_pkey_get_details($recurso);

            file_put_contents(self::$rutaPrivada, $llavePrivada);
            file_put_contents(self::$rutaPublica, $detalles['key']);
        }
    }

    public static function construirCadena(array $datos): string
    {
        return implode('|', [
            $datos['nombre']    ?? '',
            $datos['apellido']  ?? '',
            $datos['identidad'] ?? '',
            $datos['correo']    ?? '',
            $datos['celular']   ?? '',
            $datos['sexo']      ?? '',
        ]);
    }

    public static function firmar(array $datos): string
    {
        self::asegurarLlaves();
        $llavePrivada = openssl_pkey_get_private(file_get_contents(self::$rutaPrivada));
        $cadena = self::construirCadena($datos);

        openssl_sign($cadena, $firmaBinaria, $llavePrivada, OPENSSL_ALGO_SHA256);

        return base64_encode($firmaBinaria);
    }

    public static function verificar(array $datos, string $firmaBase64): bool
    {
        self::asegurarLlaves();
        $llavePublica = openssl_pkey_get_public(file_get_contents(self::$rutaPublica));
        $cadena = self::construirCadena($datos);
        $firmaBinaria = base64_decode($firmaBase64);

        $resultado = openssl_verify($cadena, $firmaBinaria, $llavePublica, OPENSSL_ALGO_SHA256);
        return $resultado === 1;
    }
}
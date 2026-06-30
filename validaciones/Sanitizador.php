<?php
class Sanitizador
{
    public static function limpiarTexto(string $texto): string
    {
        $texto = trim($texto);
        $texto = strip_tags($texto);
        $texto = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
        return preg_replace('/\s+/', ' ', $texto);
    }

    public static function tipoTitulo(string $texto): string
    {
        $texto = self::limpiarTexto($texto);
        return mb_convert_case(mb_strtolower($texto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    public static function limpiarCorreo(string $correo): string
    {
        return filter_var(trim(strtolower($correo)), FILTER_SANITIZE_EMAIL);
    }

    public static function limpiarNumerico(string $valor): string
    {
        return preg_replace('/\D/', '', $valor);
    }

    public static function limpiarEntero($valor): int
    {
        return (int) filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function sanearFormulario(array $datos): array
    {
        return [
            'identidad'          => self::limpiarTexto($datos['identidad']),
            'nombre'             => self::tipoTitulo($datos['nombre']),
            'apellido'           => self::tipoTitulo($datos['apellido']),
            'edad'               => self::limpiarEntero($datos['edad']),
            'sexo'               => self::limpiarTexto($datos['sexo']),
            'pais_residencia_id' => self::limpiarEntero($datos['pais_residencia_id']),
            'nacionalidad_id'    => self::limpiarEntero($datos['nacionalidad_id']),
            'correo'             => self::limpiarCorreo($datos['correo']),
            'celular'            => self::limpiarNumerico($datos['celular']),
            'observaciones'      => self::limpiarTexto($datos['observaciones'] ?? ''),
            'areas'              => array_map('intval', $datos['areas'] ?? []),
        ];
    }
}
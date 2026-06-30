<?php
class Validador
{
    public static function identidadValida(string $identidad): bool
    {
        return (bool) preg_match('/^[A-Za-z0-9\-]{5,20}$/', trim($identidad));
    }

    public static function nombreValido(string $texto): bool
    {
        return (bool) preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,100}$/u', trim($texto));
    }

    public static function edadValida($edad): bool
    {
        return filter_var($edad, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 120]
        ]) !== false;
    }

    public static function sexoValido(string $sexo): bool
    {
        return in_array($sexo, ['Masculino', 'Femenino', 'Otro'], true);
    }

    public static function correoValido(string $correo): bool
    {
        return filter_var(trim($correo), FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function celularValido(string $celular): bool
    {
        return (bool) preg_match('/^[0-9]{8}$/', trim($celular));
    }

    public static function paisValido($idPais): bool
    {
        return filter_var($idPais, FILTER_VALIDATE_INT) !== false && (int)$idPais > 0;
    }

    public static function areasValidas($areas): bool
    {
        return is_array($areas) && count($areas) > 0;
    }

    public static function validarFormulario(array $datos): array
    {
        $errores = [];

        if (empty($datos['identidad']) || !self::identidadValida($datos['identidad'])) {
            $errores['identidad'] = 'Identidad inválida.';
        }
        if (empty($datos['nombre']) || !self::nombreValido($datos['nombre'])) {
            $errores['nombre'] = 'Nombre inválido.';
        }
        if (empty($datos['apellido']) || !self::nombreValido($datos['apellido'])) {
            $errores['apellido'] = 'Apellido inválido.';
        }
        if (!isset($datos['edad']) || !self::edadValida($datos['edad'])) {
            $errores['edad'] = 'Edad inválida.';
        }
        if (empty($datos['sexo']) || !self::sexoValido($datos['sexo'])) {
            $errores['sexo'] = 'Sexo inválido.';
        }
        if (empty($datos['pais_residencia_id']) || !self::paisValido($datos['pais_residencia_id'])) {
            $errores['pais_residencia_id'] = 'País de residencia inválido.';
        }
        if (empty($datos['nacionalidad_id']) || !self::paisValido($datos['nacionalidad_id'])) {
            $errores['nacionalidad_id'] = 'Nacionalidad inválida.';
        }
        if (empty($datos['correo']) || !self::correoValido($datos['correo'])) {
            $errores['correo'] = 'Correo inválido.';
        }
        if (empty($datos['celular']) || !self::celularValido($datos['celular'])) {
            $errores['celular'] = 'Celular inválido (8 dígitos).';
        }
        if (!self::areasValidas($datos['areas'] ?? null)) {
            $errores['areas'] = 'Seleccione al menos un área de interés.';
        }

        return $errores;
    }
}
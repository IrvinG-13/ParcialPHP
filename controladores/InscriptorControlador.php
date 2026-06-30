<?php
require_once __DIR__ . '/../modelos/InscriptorModelo.php';
require_once __DIR__ . '/../validaciones/Validador.php';
require_once __DIR__ . '/../validaciones/Sanitizador.php';

class InscriptorControlador
{
    public function mostrarFormulario(): void
    {
        $paises = InscriptorModelo::obtenerPaises();
        $areas  = InscriptorModelo::obtenerAreasInteres();
        $errores = [];
        $datosPrevios = [];
        require __DIR__ . '/../vistas/formulario.php';
    }

    public function guardarInscripcion(): void
    {
        $errores = Validador::validarFormulario($_POST);

        if (empty($errores)) {
            $datosLimpios = Sanitizador::sanearFormulario($_POST);

            if (InscriptorModelo::existeCorreo($datosLimpios['correo'])) {
                $errores['correo'] = 'Este correo ya está registrado.';
            }
            if (InscriptorModelo::existeIdentidad($datosLimpios['identidad'])) {
                $errores['identidad'] = 'Esta identidad ya está registrada.';
            }
            if (InscriptorModelo::existeCelular($datosLimpios['celular'])) {
                $errores['celular'] = 'Este celular ya está registrado.';
            }
        }

        if (!empty($errores)) {
            $paises = InscriptorModelo::obtenerPaises();
            $areas  = InscriptorModelo::obtenerAreasInteres();
            $datosPrevios = $_POST;
            require __DIR__ . '/../vistas/formulario.php';
            return;
        }

        InscriptorModelo::guardar($datosLimpios);
        header('Location: index.php?accion=exito');
        exit;
    }

    public function mostrarExito(): void
    {
        require __DIR__ . '/../vistas/exito.php';
    }

    public function mostrarReporte(): void
    {
        require_once __DIR__ . '/../config/FirmaDigital.php';
        $registros = InscriptorModelo::obtenerReporte();

        foreach ($registros as &$registro) {
            $registro['integro'] = FirmaDigital::verificar($registro, $registro['firma_digital']);
        }
        unset($registro);

        require __DIR__ . '/../vistas/reporte.php';
    }

    public function exportarExcel(): void
    {
        require __DIR__ . '/../exportaciones/exportar_excel.php';
    }
}
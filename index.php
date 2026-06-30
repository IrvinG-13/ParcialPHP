<?php
require_once __DIR__ . '/controladores/InscriptorControlador.php';

$controlador = new InscriptorControlador();
$accion = $_GET['accion'] ?? 'formulario';

switch ($accion) {
    case 'guardar':
        $controlador->guardarInscripcion();
        break;
    case 'exito':
        $controlador->mostrarExito();
        break;
    case 'reporte':
        $controlador->mostrarReporte();
        break;
    case 'exportar':
        $controlador->exportarExcel();
        break;
    case 'formulario':
    default:
        $controlador->mostrarFormulario();
        break;
}
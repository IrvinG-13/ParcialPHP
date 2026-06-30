<?php
require_once __DIR__ . '/../modelos/InscriptorModelo.php';
require_once __DIR__ . '/../config/FirmaDigital.php';

$registros = InscriptorModelo::obtenerReporte();
foreach ($registros as &$r) {
    $r['integro'] = FirmaDigital::verificar($r, $r['firma_digital']);
}
unset($r);

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="reporte_inscripciones_' . date('Ymd_His') . '.xls"');
echo "\xEF\xBB\xBF";
?>
<table border="1">
    <tr>
        <th>Identidad</th><th>Nombre</th><th>Apellido</th><th>Edad</th>
        <th>Sexo</th><th>País Residencia</th><th>Nacionalidad</th><th>Correo</th>
        <th>Celular</th><th>Áreas de Interés</th><th>Fecha</th><th>Integridad</th>
    </tr>
    <?php foreach ($registros as $r): ?>
    <tr>
        <td><?= htmlspecialchars($r['identidad']) ?></td>
        <td><?= htmlspecialchars($r['nombre']) ?></td>
        <td><?= htmlspecialchars($r['apellido']) ?></td>
        <td><?= htmlspecialchars($r['edad']) ?></td>
        <td><?= htmlspecialchars($r['sexo']) ?></td>
        <td><?= htmlspecialchars($r['pais_residencia']) ?></td>
        <td><?= htmlspecialchars($r['nacionalidad']) ?></td>
        <td><?= htmlspecialchars($r['correo']) ?></td>
        <td><?= htmlspecialchars($r['celular']) ?></td>
        <td><?= htmlspecialchars($r['areas'] ?? '') ?></td>
        <td><?= htmlspecialchars($r['fecha_registro']) ?></td>
        <td><?= $r['integro'] ? 'Verificado' : 'Vulnerado' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
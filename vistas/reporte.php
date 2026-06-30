<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de Inscripciones</title>
<link rel="stylesheet" href="publico/estilos.css">
</head>
<body>
<div class="contenedor" style="max-width:95%;">
    <div class="encabezado">
        <h1>Reporte de Inscripciones</h1>
        <p>Auditoría de Integridad (firma digital OpenSSL)</p>
    </div>
    <div style="padding:20px;">
        <a class="boton" href="index.php?accion=exportar">Exportar a Excel</a>
        <a class="boton" href="index.php?accion=formulario">Volver al Formulario</a>

        <table class="reporte" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>Identidad</th><th>Nombre</th><th>Apellido</th><th>Edad</th>
                    <th>Sexo</th><th>País Residencia</th><th>Nacionalidad</th><th>Correo</th>
                    <th>Celular</th><th>Áreas de Interés</th><th>Fecha</th><th>Integridad</th>
                </tr>
            </thead>
            <tbody>
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
                    <td>
                        <?php if ($r['integro']): ?>
                            <span class="badge badge-verde">✔ Verificado</span>
                        <?php else: ?>
                            <span class="badge badge-rojo">✖ Vulnerado</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <footer>&copy; <?= date('Y') ?> iTECH. All rights reserved.</footer>
</div>
</body>
</html>
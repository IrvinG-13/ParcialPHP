<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Formulario de Inscripción - iTECH</title>
<link rel="stylesheet" href="publico/estilos.css">
</head>
<body>
<div class="contenedor">
    <div class="encabezado">
        <h1>Formulario de Inscripción</h1>
        <p>Fecha: <?= date('d/m/Y') ?></p>
    </div>

    <form action="index.php?accion=guardar" method="POST">
        <div class="campo">
            <label for="identidad">Identidad (Documento de Identificación)</label>
            <input type="text" id="identidad" name="identidad"
                   value="<?= htmlspecialchars($datosPrevios['identidad'] ?? '') ?>" required>
            <?php if (!empty($errores['identidad'])): ?><div class="error"><?= $errores['identidad'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?= htmlspecialchars($datosPrevios['nombre'] ?? '') ?>" required>
            <?php if (!empty($errores['nombre'])): ?><div class="error"><?= $errores['nombre'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido"
                   value="<?= htmlspecialchars($datosPrevios['apellido'] ?? '') ?>" required>
            <?php if (!empty($errores['apellido'])): ?><div class="error"><?= $errores['apellido'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" min="1" max="120"
                   value="<?= htmlspecialchars($datosPrevios['edad'] ?? '') ?>" required>
            <?php if (!empty($errores['edad'])): ?><div class="error"><?= $errores['edad'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label>Sexo</label>
            <div class="radio-grupo">
                <?php foreach (['Masculino', 'Femenino', 'Otro'] as $opcion): ?>
                    <label>
                        <input type="radio" name="sexo" value="<?= $opcion ?>"
                            <?= (($datosPrevios['sexo'] ?? '') === $opcion) ? 'checked' : '' ?> required>
                        <?= $opcion ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($errores['sexo'])): ?><div class="error"><?= $errores['sexo'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="pais_residencia_id">País de Residencia</label>
            <select id="pais_residencia_id" name="pais_residencia_id" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id'] ?>"
                        <?= ((string)($datosPrevios['pais_residencia_id'] ?? '') === (string)$p['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errores['pais_residencia_id'])): ?><div class="error"><?= $errores['pais_residencia_id'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="nacionalidad_id">Nacionalidad</label>
            <select id="nacionalidad_id" name="nacionalidad_id" required>
                <option value="">-- Seleccione --</option>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id'] ?>"
                        <?= ((string)($datosPrevios['nacionalidad_id'] ?? '') === (string)$p['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errores['nacionalidad_id'])): ?><div class="error"><?= $errores['nacionalidad_id'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo"
                   value="<?= htmlspecialchars($datosPrevios['correo'] ?? '') ?>" required>
            <?php if (!empty($errores['correo'])): ?><div class="error"><?= $errores['correo'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="celular">Celular</label>
            <input type="tel" id="celular" name="celular" maxlength="8"
                   value="<?= htmlspecialchars($datosPrevios['celular'] ?? '') ?>" required>
            <?php if (!empty($errores['celular'])): ?><div class="error"><?= $errores['celular'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label>Tema Tecnológico que le gustaría aprender</label>
            <div class="checkbox-grupo">
                <?php foreach ($areas as $a): ?>
                    <?php $seleccionadas = $datosPrevios['areas'] ?? []; ?>
                    <label>
                        <input type="checkbox" name="areas[]" value="<?= $a['id'] ?>"
                            <?= in_array($a['id'], $seleccionadas) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($a['nombre']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($errores['areas'])): ?><div class="error"><?= $errores['areas'] ?></div><?php endif; ?>
        </div>

        <div class="campo">
            <label for="observaciones">Observaciones o Consulta sobre el evento</label>
            <textarea id="observaciones" name="observaciones" rows="3"><?= htmlspecialchars($datosPrevios['observaciones'] ?? '') ?></textarea>
        </div>

        <button type="submit">Enviar Inscripción</button>
    </form>

    <footer>
        &copy; <?= date('Y') ?> iTECH. All rights reserved. | Contacto: contacto@itech.com | Tel: 6000-0000
    </footer>
</div>
</body>
</html>
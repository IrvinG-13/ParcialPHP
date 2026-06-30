<?php
require_once __DIR__ . '/../config/Conexion.php';
require_once __DIR__ . '/../config/FirmaDigital.php';

class InscriptorModelo
{
    public static function obtenerPaises(): array
    {
        return Conexion::consultar("SELECT id, nombre FROM paises ORDER BY nombre");
    }

    

    public static function obtenerAreasInteres(): array
    {
        return Conexion::consultar("SELECT id, nombre FROM areas_interes ORDER BY id");
    }

    public static function existeCorreo(string $correo): bool
    {
        $fila = Conexion::consultar("SELECT id FROM inscriptores WHERE correo = ?", [$correo]);
        return count($fila) > 0;
    }

    public static function existeIdentidad(string $identidad): bool
    {
        $fila = Conexion::consultar("SELECT id FROM inscriptores WHERE identidad = ?", [$identidad]);
        return count($fila) > 0;
    }

    public static function existeCelular(string $celular): bool
    {
        $fila = Conexion::consultar("SELECT id FROM inscriptores WHERE celular = ?", [$celular]);
        return count($fila) > 0;
    }

    public static function guardar(array $datos): int
    {
        $pdo = Conexion::obtenerConexion();
        $pdo->beginTransaction();

        try {
            $firma = FirmaDigital::firmar($datos);

            $sql = "INSERT INTO inscriptores
                        (identidad, nombre, apellido, edad, sexo, pais_residencia_id,
                         nacionalidad_id, correo, celular, observaciones, firma_digital)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            Conexion::ejecutar($sql, [
                $datos['identidad'], $datos['nombre'], $datos['apellido'],
                $datos['edad'], $datos['sexo'], $datos['pais_residencia_id'],
                $datos['nacionalidad_id'], $datos['correo'], $datos['celular'],
                $datos['observaciones'], $firma,
            ]);

            $idInscriptor = (int) Conexion::ultimoId();

            $sqlArea = "INSERT INTO inscriptor_temas (inscriptor_id, area_interes_id) VALUES (?,?)";
            foreach ($datos['areas'] as $idArea) {
                Conexion::ejecutar($sqlArea, [$idInscriptor, $idArea]);
            }

            $pdo->commit();
            return $idInscriptor;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function obtenerReporte(): array
    {
        $sql = "SELECT i.id, i.identidad, i.nombre, i.apellido, i.edad, i.sexo,
                       pr.nombre AS pais_residencia, na.nombre AS nacionalidad,
                       i.correo, i.celular, i.observaciones, i.firma_digital,
                       i.fecha_registro,
                       GROUP_CONCAT(ar.nombre ORDER BY ar.nombre SEPARATOR ', ') AS areas
                FROM inscriptores i
                JOIN paises pr ON pr.id = i.pais_residencia_id
                JOIN paises na ON na.id = i.nacionalidad_id
                LEFT JOIN inscriptor_temas it ON it.inscriptor_id = i.id
                LEFT JOIN areas_interes ar ON ar.id = it.area_interes_id
                GROUP BY i.id
                ORDER BY i.fecha_registro DESC";

        return Conexion::consultar($sql);
    }
}
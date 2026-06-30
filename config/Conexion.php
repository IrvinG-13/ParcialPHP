<?php
class Conexion
{
    private static $host   = '127.0.0.1';
    private static $bd     = 'parcial';
    private static $usuario = 'root';
    private static $clave   = '';
    private static $charset = 'utf8mb4';

    private static ?PDO $pdo = null;

    public static function obtenerConexion(): PDO
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$bd . ";charset=" . self::$charset;
            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$pdo = new PDO($dsn, self::$usuario, self::$clave, $opciones);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function consultar(string $sql, array $parametros = []): array
    {
        $stmt = self::obtenerConexion()->prepare($sql);
        $stmt->execute($parametros);
        return $stmt->fetchAll();
    }

    public static function ejecutar(string $sql, array $parametros = []): int
    {
        $stmt = self::obtenerConexion()->prepare($sql);
        $stmt->execute($parametros);
        return $stmt->rowCount();
    }

    public static function ultimoId(): string
    {
        return self::obtenerConexion()->lastInsertId();
    }
}
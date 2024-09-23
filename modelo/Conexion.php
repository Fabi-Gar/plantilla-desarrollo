<?php
class Conexion {

    public static function Conectar() {
        try {
            $con = new PDO("mysql:host=localhost;dbname=pos", "root", "");  // Ajusta estos datos a tu configuración
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>

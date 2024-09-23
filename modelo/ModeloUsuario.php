<?php
require_once 'Conexion.php';  // Asegúrate de que la clase de conexión se incluya

class ModeloUsuario {

    public static function MdlBuscarUsuario($tabla, $item, $valor) {
        try {
            // Preparar la consulta SQL
            $stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            
            // Enlazar parámetros
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Retornar el resultado
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Asegúrate de usar FETCH_ASSOC para un array asociativo

        } catch (PDOException $e) {
            die("Error al buscar usuario: " . $e->getMessage());
        }
    }
}
?>

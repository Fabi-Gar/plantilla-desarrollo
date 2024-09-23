<?php
require_once 'modelo/Conexion.php';

try {
    $conn = Conexion::Conectar();
    echo "Conexión exitosa";
} catch (Exception $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

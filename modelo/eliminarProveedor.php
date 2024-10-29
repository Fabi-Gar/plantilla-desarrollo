<?php
require_once 'Conexion.php';

if (isset($_POST['id'])) {
    try {
        $con = Conexion::Conectar();
        $stmt = $con->prepare("DELETE FROM proveedores WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        
        header("Location: ../index.php");
    } catch (PDOException $e) {
        die("Error al eliminar proveedor: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?>

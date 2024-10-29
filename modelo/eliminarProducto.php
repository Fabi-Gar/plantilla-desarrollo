<?php
require_once 'Conexion.php'; 

try {
    $con = Conexion::Conectar();
    $id = $_POST['id'];

    $stmt = $con->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../index.php"); // Redirigir a la página principal después de eliminar
} catch (PDOException $e) {
    die("Error al eliminar el producto: " . $e->getMessage());
}
?>

<?php
require_once 'Conexion.php';

if (isset($_POST['id_categoria'])) {
    try {
        $con = Conexion::Conectar();
        $stmt = $con->prepare("DELETE FROM categorias WHERE id_categoria = ?");
        $stmt->execute([$_POST['id_categoria']]);
        
        header("Location: ../index.php");
    } catch (PDOException $e) {
        die("Error al eliminar la categoría: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
}
?>

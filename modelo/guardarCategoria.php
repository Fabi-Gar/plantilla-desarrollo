<?php
require_once 'Conexion.php';

try {
    $con = Conexion::Conectar();
    
    if (!empty($_POST['editId'])) {
        // Actualizar categoría existente
        $stmt = $con->prepare("UPDATE categorias SET nombre = ? WHERE id_categoria = ?");
        $stmt->execute([$_POST['nombre'], $_POST['editId']]);
    } else {
        // Insertar nueva categoría
        $stmt = $con->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->execute([$_POST['nombre']]);
    }

    header("Location: ../index.php");
} catch (PDOException $e) {
    die("Error al guardar la categoría: " . $e->getMessage());
}
?>

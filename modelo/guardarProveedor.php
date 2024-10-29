<?php
require_once 'Conexion.php';

try {
    $con = Conexion::Conectar();
    
    if (!empty($_POST['editId'])) {
        $stmt = $con->prepare("UPDATE proveedores SET nombre = ?, telefono = ?, direccion = ?, email = ? WHERE id_proveedor = ?");
        $stmt->execute([$_POST['nombre'], $_POST['telefono'], $_POST['direccion'], $_POST['email'], $_POST['editId']]);
    } else {
        $stmt = $con->prepare("INSERT INTO proveedores (nombre, telefono, direccion, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['nombre'], $_POST['telefono'], $_POST['direccion'], $_POST['email']]);
    }

    header("Location: ../index.php");
} catch (PDOException $e) {
    die("Error al guardar el proveedor: " . $e->getMessage());
}
?>

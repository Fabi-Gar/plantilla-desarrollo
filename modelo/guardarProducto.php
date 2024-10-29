<?php
require_once 'Conexion.php'; 

try {
    $con = Conexion::Conectar();

    $editId = $_POST['editId'] ?? null;
    $nombre = $_POST['nombre'];
    $categoria_id = $_POST['categoria_id'];
    $proveedor_id = $_POST['proveedor_id'];
    $precio_costo = $_POST['precio_costo'];
    $precio_venta = $_POST['precio_venta'];
    $cantidad = $_POST['cantidad'];

    if ($editId) {
        // Actualización de producto
        $stmt = $con->prepare("UPDATE productos SET nombre = ?, categoria_id = ?, proveedor_id = ?, precio_costo = ?, precio_venta = ?, cantidad = ? WHERE id = ?");
        $stmt->execute([$nombre, $categoria_id, $proveedor_id, $precio_costo, $precio_venta, $cantidad, $editId]);
    } else {
        // Inserción de nuevo producto
        $stmt = $con->prepare("INSERT INTO productos (nombre, categoria_id, proveedor_id, precio_costo, precio_venta, cantidad) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $categoria_id, $proveedor_id, $precio_costo, $precio_venta, $cantidad]);
    }

    header("Location: ../index.php"); // Redirigir a la página principal después de guardar
} catch (PDOException $e) {
    die("Error al guardar el producto: " . $e->getMessage());
}
?>

<?php


try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT * FROM proveedores");
    $stmt->execute();
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener proveedores: " . $e->getMessage());
}
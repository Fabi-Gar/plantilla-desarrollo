<?php


try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT id_categoria, nombre FROM categorias");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {
    die("Error al obtener categorías: " . $e->getMessage());
}
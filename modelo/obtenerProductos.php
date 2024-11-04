<?php


try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("
        SELECT 
            p.id,
            p.nombre AS producto,
            c.nombre AS categoria,
            pr.nombre AS proveedor,
            p.precio_costo,
            p.precio_venta,
            p.cantidad
        FROM 
            productos p
        LEFT JOIN 
            categorias c ON p.categoria_id = c.id_categoria
        LEFT JOIN 
            proveedores pr ON p.proveedor_id = pr.id
    ");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
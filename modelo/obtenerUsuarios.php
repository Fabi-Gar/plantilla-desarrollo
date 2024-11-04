<?php

try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT id, nombre, usuario, password, foto, perfil, estado, fecha FROM usuario");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {
    die("Error al obtener usuarios: " . $e->getMessage());
}
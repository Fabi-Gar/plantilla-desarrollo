<?php

require_once '../modelo/Conexion.php'; 

try {
    $con = Conexion::Conectar();
    
    if (isset($_POST['editId']) && !empty($_POST['editId'])) {
        // Actualización de usuario
        $id = $_POST['editId'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $perfil = $_POST['perfil'];
        $estado = $_POST['estado'];
        $fecha = $_POST['fecha'];
        
        // Solo actualiza la contraseña si se ha proporcionado
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        // Actualiza la base de datos
        $sql = "UPDATE usuario SET nombre = :nombre, usuario = :usuario, perfil = :perfil, estado = :estado, fecha = :fecha" . ($password ? ", password = :password" : "") . " WHERE id = :id";
        $stmt = $con->prepare($sql);

        // Vincula los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        if ($password) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
    } else {
        // Creación de nuevo usuario
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $perfil = $_POST['perfil'];
        $estado = $_POST['estado'];
        $fecha = $_POST['fecha'];

        $sql = "INSERT INTO usuario (nombre, usuario, password, perfil, estado, fecha) VALUES (:nombre, :usuario, :password, :perfil, :estado, :fecha)";
        $stmt = $con->prepare($sql);

        // Vincula los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':fecha', $fecha);

        $stmt->execute();
    }

   
    header('Location: http://localhost/plantillaDesarrollo/plantilla-desarrollo/usuarios');
    exit();

} catch (PDOException $e) {
    die("Error al guardar los datos: " . $e->getMessage());
}
?>

<?php
require_once '../modelo/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $perfil = $_POST['perfil'];
    $estado = $_POST['estado'];

    // Si hay una nueva contraseña, encriptarla
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        // No cambiar la contraseña si el campo está vacío
        $password = null;
    }

    // Manejar la subida de foto si es necesario
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $foto);
    } else {
        $foto = null;
    }

    try {
        $con = Conexion::Conectar();
        $sql = "UPDATE usuario SET nombre = :nombre, usuario = :usuario, perfil = :perfil, estado = :estado";

        // Solo actualizar la contraseña si se ha proporcionado
        if ($password) {
            $sql .= ", password = :password";
        }

        // Solo actualizar la foto si se ha proporcionado
        if ($foto) {
            $sql .= ", foto = :foto";
        }

        $sql .= " WHERE id = :id";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':perfil', $perfil);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);

        // Solo vincular la contraseña si no está vacía
        if ($password) {
            $stmt->bindParam(':password', $password);
        }

        // Solo vincular la foto si no está vacía
        if ($foto) {
            $stmt->bindParam(':foto', $foto);
        }

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir y recargar la página después de actualizar
            header("Location: http://localhost/ULTIMA%20VERSION/plantilla/usuarios'");
            exit(); 
        } else {
            echo "<script>
                    alert('Error al actualizar usuario.');
                  </script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


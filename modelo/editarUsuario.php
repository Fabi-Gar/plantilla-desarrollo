<?php
require_once '../modelo/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $perfil = $_POST['perfil'];
    $estado = $_POST['estado'];

  
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
   
        $password = null;
    }

 
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $foto);
    } else {
        $foto = null;
    }

    try {
        $con = Conexion::Conectar();
        $sql = "UPDATE usuario SET nombre = :nombre, usuario = :usuario, perfil = :perfil, estado = :estado";

       
        if ($password) {
            $sql .= ", password = :password";
        }

   
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


        if ($password) {
            $stmt->bindParam(':password', $password);
        }

        if ($foto) {
            $stmt->bindParam(':foto', $foto);
        }


        if ($stmt->execute()) {
           
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


<?php
// Incluir el archivo de conexión
require_once '../modelo/Conexion.php'; // Cambia la ruta según sea necesario
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión, de lo contrario redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../vistas/login.html");
    exit();
}

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario a eliminar
    $id = $_POST['id'];

    try {
        $con = Conexion::Conectar();
        $stmt = $con->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>
                    alert('Usuario eliminado exitosamente.');
                    window.location.href = document.referrer; // Volver a la página anterior
                  </script>";
        } else {
            echo "<script>
                    alert('Error al eliminar usuario.');
                    window.history.back(); // Regresar a la página anterior
                  </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.history.back(); // Regresar a la página anterior
              </script>";
    }
} else {
    // Si no es una solicitud POST, redirigir
    header("Location: http://localhost/plantillaDesarrollo/plantilla-desarrollo/usuarios");
    exit();
}
?>

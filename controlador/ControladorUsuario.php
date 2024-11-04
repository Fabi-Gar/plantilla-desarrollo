<?php
require_once 'modelo/ModeloUsuario.php';

class ControladorUsuario {

    public function buscarUsuario() {
        if (isset($_POST["ingUsuario"]) && isset($_POST["ingPassword"])) {

            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {

                $tabla = 'usuario';  
                $item = 'usuario';  
                $valor = $_POST["ingUsuario"];

                $respuesta = ModeloUsuario::MdlBuscarUsuario($tabla, $item, $valor);

                
                var_dump($respuesta);

                if ($respuesta) {
                    
                    if ($_POST["ingPassword"] === $respuesta["password"]) {
                        session_start();
                        $_SESSION['usuario'] = $respuesta['usuario'];
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "<script>alert('La contraseña es incorrecta.'); window.location.href = 'vistas/login.html';</script>";
                    }
                } else {
                    echo "<script>alert('El usuario no existe.'); window.location.href = 'vistas/login.html';</script>";
                }
            } else {
                echo "<script>alert('Formato de usuario o contraseña inválidos.'); window.location.href = 'vistas/login.html';</script>";
            }
        } else {
            echo "<script>alert('Por favor complete todos los campos.'); window.location.href = 'vistas/login.html';</script>";
        }
    }
}
?>

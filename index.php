<?php
require_once 'modelo/Conexion.php';  // Incluye la clase de conexión primero
require 'controlador/Plantilla.Controlador.php';
require 'controlador/ControladorUsuario.php';
require_once 'modelo/ModeloUsuario.php';

session_start();  // Asegúrate de iniciar la sesión aquí

// Verificar si se están enviando los datos del formulario de login
if (isset($_POST['ingUsuario']) && isset($_POST['ingPassword'])) {
    $usuario = new ControladorUsuario();
    $usuario->buscarUsuario();
    exit();  // Asegúrate de salir para evitar que se ejecute el código siguiente
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: vistas/login.html");
    exit();
}

// Cargar la plantilla del dashboard
$plantilla = new Plantilla();
$plantilla->CrearPlantilla();
?>

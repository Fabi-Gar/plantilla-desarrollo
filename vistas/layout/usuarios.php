<?php
require_once 'modelo/Conexion.php';




if (!isset($_SESSION['usuario'])) {
    header("Location: vistas/login.html");
    exit();
}

try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT id, nombre, usuario, password, perfil, foto, estado, ultimo_login, fecha FROM usuarios");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {
    die("Error al obtener usuarios: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../public/dist/css/adminlte.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Lista de Usuarios</h1>

    <!-- Botón para abrir el modal de agregar usuario -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#modalAgregarUsuario">
        Agregar Usuario
    </button>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Perfil</th>
                <th>Foto</th>
                <th>Estado</th>
                <th>Último Login</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th> 
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($usuarios as $usuario) {
                echo "<tr>";
                echo "<td>" . $usuario['id'] . "</td>";
                echo "<td>" . $usuario['nombre'] . "</td>";
                echo "<td>" . $usuario['usuario'] . "</td>";
                echo "<td>" . $usuario['password'] . "</td>";
                echo "<td>" . $usuario['perfil'] . "</td>";
                echo "<td><img src='uploads/" . $usuario['foto'] . "' width='50'></td>";
                echo "<td>" . $usuario['estado'] . "</td>";
                echo "<td>" . $usuario['ultimo_login'] . "</td>";
                echo "<td>" . $usuario['fecha'] . "</td>";
                echo "<td>";
                echo "<div class='btn-group' role='group'>";
                echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modalEditarUsuario' data-id='" . $usuario['id'] . "'>Editar</button>";
                echo "<button type='button' class='btn btn-danger btn-sm' onclick='eliminarUsuario(" . $usuario['id'] . ")'>Eliminar</button>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalLabelAgregarUsuario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelAgregarUsuario">Formulario para Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="usuarios.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese el usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto:</label>
                        <input type="file" class="form-control-file" id="foto" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditarUsuario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelEditarUsuario">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditarUsuario" action="editar_usuario.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <div class="form-group">
                        <label for="nombreEditar">Nombre:</label>
                        <input type="text" class="form-control" id="nombreEditar" name="nombre" placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="usuarioEditar">Usuario:</label>
                        <input type="text" class="form-control" id="usuarioEditar" name="usuario" placeholder="Ingrese el usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="passwordEditar">Contraseña:</label>
                        <input type="password" class="form-control" id="passwordEditar" name="password" placeholder="Ingrese la contraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="fotoEditar">Foto:</label>
                        <input type="file" class="form-control-file" id="fotoEditar" name="foto">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function eliminarUsuario(id) {
        if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
            window.location.href = 'eliminar_usuario.php?id=' + id;
        }
    }

    // Llenar el formulario de editar usuario
    $('#modalEditarUsuario').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id'); // Extraer la información de data-* atributos
        // Aquí puedes hacer una llamada AJAX para obtener los datos del usuario y llenarlos en el formulario

        // Ejemplo (necesitas implementar la lógica para obtener los datos del usuario):
        $('#id_usuario').val(id);
        $('#nombreEditar').val(''); // Aquí deberías poner el nombre actual
        $('#usuarioEditar').val(''); // Aquí deberías poner el usuario actual
        $('#passwordEditar').val(''); // Aquí deberías poner la contraseña actual (puede que no sea necesario mostrarla)
        // etc.
    });
</script>

</body>
</html>

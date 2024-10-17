<?php

require_once 'modelo/Conexion.php'; 

try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT id, nombre, usuario, password, foto, perfil, estado, fecha FROM usuario");
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
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <!-- Botón para abrir el formulario -->
    <button type="button" class="btn btn-primary" onclick="abrirFormulario()">Agregar Usuario</button>

    <!-- Ventana modal (emergente) para el formulario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario que envía los datos a guardarUsuario.php -->
                    <form id="formUsuario" method="POST" action="modelo/guardarUsuario.php" enctype="multipart/form-data">
                        <input type="hidden" id="editId" name="editId" value="">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="perfil">Perfil</label>
                            <select class="form-control" id="perfil" name="perfil" required>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="viewer">Viewer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="text" class="form-control" id="fecha" name="fecha" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Foto</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th> <!-- Nueva columna para las acciones -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo $usuario['usuario']; ?></td>
                <td><?php echo $usuario['password']; ?></td>
                <td><img src='uploads/<?php echo $usuario['foto'] ?: "default.png"; ?>' width='50'></td>
                <td><?php echo $usuario['perfil']; ?></td>
                <td><?php echo $usuario['estado'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                <td><?php echo $usuario['fecha']; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <form action="modelo/eliminarUsuario.php" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        <button class="btn btn-warning" onclick="abrirFormularioEdicion(<?php echo htmlspecialchars(json_encode($usuario)); ?>)">Editar</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<!-- Scripts para Bootstrap y funcionalidad -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function abrirFormulario() {
    
        document.getElementById('formUsuario').reset();
        document.getElementById('editId').value = '';
        $('#usuarioModal').modal('show');

    
        let fechaActual = new Date().toISOString().slice(0, 19).replace('T', ' '); 
        document.getElementById('fecha').value = fechaActual;
    }

    function abrirFormularioEdicion(usuario) {
      
        document.getElementById('nombre').value = usuario.nombre;
        document.getElementById('usuario').value = usuario.usuario;
        document.getElementById('password').value = ''; 
        document.getElementById('perfil').value = usuario.perfil;
        document.getElementById('estado').value = usuario.estado;
        document.getElementById('fecha').value = usuario.fecha;
        document.getElementById('editId').value = usuario.id;

        $('#usuarioModal').modal('show');
    }
</script>

</body>
</html>

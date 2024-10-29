<?php
require_once 'modelo/Conexion.php'; 

try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("SELECT * FROM proveedores");
    $stmt->execute();
    $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener proveedores: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <button type="button" class="btn btn-primary" onclick="abrirFormulario()">Agregar Proveedor</button>

    <div class="modal fade" id="proveedorModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar/Editar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formProveedor" method="POST" action="modelo/guardarProveedor.php">
                        <input type="hidden" id="editId" name="editId">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proveedores as $proveedor): ?>
            <tr>
                <td><?php echo $proveedor['id']; ?></td>
                <td><?php echo $proveedor['nombre']; ?></td>
                <td><?php echo $proveedor['telefono']; ?></td>
                <td><?php echo $proveedor['direccion']; ?></td>
                <td><?php echo $proveedor['email']; ?></td>
                <td>
                    <button class="btn btn-warning" onclick="abrirFormularioEdicion(<?php echo htmlspecialchars(json_encode($proveedor)); ?>)">Editar</button>
                    <form action="modelo/eliminarProveedor.php" method="post" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres eliminar este proveedor?');">
                        <input type="hidden" name="id" value="<?php echo $proveedor['id']; ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function abrirFormulario() {
        document.getElementById('formProveedor').reset();
        document.getElementById('editId').value = '';
        $('#proveedorModal').modal('show');
    }

    function abrirFormularioEdicion(proveedor) {
        document.getElementById('nombre').value = proveedor.nombre;
        document.getElementById('telefono').value = proveedor.telefono;
        document.getElementById('direccion').value = proveedor.direccion;
        document.getElementById('email').value = proveedor.email;
        document.getElementById('editId').value = proveedor.id;
        $('#proveedorModal').modal('show');
    }
</script>

</body>
</html>

<?php
require_once 'modelo/Conexion.php'; 

require 'modelo/obtenerCategorias.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    
    <button type="button" class="btn btn-primary" onclick="abrirFormulario()">Agregar Categoría</button>

    <!-- Ventana modal para el formulario -->
    <div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                    <form id="formCategoria" method="POST" action="modelo/guardarCategoria.php">
                        <input type="hidden" id="editId" name="editId" value="">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required maxlength="100">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Categoría</button>
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?php echo $categoria['id_categoria']; ?></td>
                <td><?php echo $categoria['nombre']; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <form action="modelo/eliminarCategoria.php" method="post" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                            <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        <button class="btn btn-warning" onclick="abrirFormularioEdicion(<?php echo htmlspecialchars(json_encode($categoria)); ?>)">Editar</button>
                    </div>
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
        document.getElementById('formCategoria').reset();
        document.getElementById('editId').value = '';
        $('#categoriaModal').modal('show');
    }

    function abrirFormularioEdicion(categoria) {
        document.getElementById('nombre').value = categoria.nombre;
        document.getElementById('editId').value = categoria.id_categoria;
        $('#categoriaModal').modal('show');
    }
</script>

</body>
</html>

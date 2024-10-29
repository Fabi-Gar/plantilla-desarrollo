<?php
require_once 'modelo/Conexion.php'; 

try {
    $con = Conexion::Conectar();
    $stmt = $con->prepare("
        SELECT 
            p.id,
            p.nombre AS producto,
            c.nombre AS categoria,
            pr.nombre AS proveedor,
            p.precio_costo,
            p.precio_venta,
            p.cantidad
        FROM 
            productos p
        LEFT JOIN 
            categorias c ON p.categoria_id = c.id_categoria
        LEFT JOIN 
            proveedores pr ON p.proveedor_id = pr.id
    ");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <button type="button" class="btn btn-primary" onclick="abrirFormulario()">Agregar Producto</button>

    <div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar/Editar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formProducto" method="POST" action="modelo/guardarProducto.php">
                        <input type="hidden" id="editId" name="editId">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select class="form-control" id="categoria_id" name="categoria_id" required>
                                <option value="">Seleccione categoría</option>
                                <?php
                                // Aquí deberías agregar la consulta para obtener las categorías
                                $stmt = $con->prepare("SELECT * FROM categorias");
                                $stmt->execute();
                                $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categorias as $categoria) {
                                    echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="proveedor_id">Proveedor</label>
                            <select class="form-control" id="proveedor_id" name="proveedor_id" required>
                                <option value="">Seleccione proveedor</option>
                                <?php
                                // Aquí deberías agregar la consulta para obtener los proveedores
                                $stmt = $con->prepare("SELECT * FROM proveedores");
                                $stmt->execute();
                                $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($proveedores as $proveedor) {
                                    echo "<option value='{$proveedor['id']}'>{$proveedor['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precio_costo">Precio Compra</label>
                            <input type="number" class="form-control" id="precio_costo" name="precio_costo" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="precio_venta">Precio Venta</label>
                            <input type="number" class="form-control" id="precio_venta" name="precio_venta" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
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
                <th>Producto</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?php echo $producto['producto']; ?></td>
                <td><?php echo $producto['categoria'] ?: 'No asignada'; ?></td> <!-- Muestra "No asignada" si no hay categoría -->
                <td><?php echo $producto['proveedor'] ?: 'No asignado'; ?></td> <!-- Muestra "No asignado" si no hay proveedor -->
                <td><?php echo $producto['precio_costo']; ?></td>
                <td><?php echo $producto['precio_venta']; ?></td>
                <td><?php echo $producto['cantidad']; ?></td>
                <td>
                    <button class="btn btn-warning" onclick="abrirFormularioEdicion(<?php echo htmlspecialchars(json_encode($producto)); ?>)">Editar</button>
                    <form action="modelo/eliminarProducto.php" method="post" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
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
        document.getElementById('formProducto').reset();
        document.getElementById('editId').value = '';
        $('#productoModal').modal('show');
    }

    function abrirFormularioEdicion(producto) {
        document.getElementById('nombre').value = producto.producto;
        document.getElementById('categoria_id').value = producto.categoria_id;
        document.getElementById('proveedor_id').value = producto.proveedor_id;
        document.getElementById('precio_costo').value = producto.precio_costo;
        document.getElementById('precio_venta').value = producto.precio_venta;
        document.getElementById('cantidad').value = producto.cantidad;
        document.getElementById('editId').value = producto.id;
        $('#productoModal').modal('show');
    }
</script>

</body>
</html>

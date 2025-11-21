<?php
session_start();
require 'forms/db_connect.php';

// SEGURIDAD: Si no es admin, lo expulsamos al inicio
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$mensaje = "";

// Lógica para AGREGAR PRODUCTO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'crear_producto') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $specs = $conn->real_escape_string($_POST['specs']);
    $imagen = "assets/img/portfolio/" . $_POST['imagen']; // Asumimos que subes la foto a esa carpeta manual, o pones URL

    $sql = "INSERT INTO productos (nombre, precio, categoria, descripcion, imagen, specs) 
            VALUES ('$nombre', '$precio', '$categoria', '$descripcion', '$imagen', '$specs')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "¡Producto agregado correctamente!";
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Admin - Byte Builders</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; padding-top: 20px; }
        .admin-header { background: #333; color: white; padding: 1rem; margin-bottom: 2rem; border-radius: 5px; }
        .card { margin-bottom: 20px; border: none; shadow-sm: 0 2px 4px rgba(0,0,0,0.1); }
        .card-header { background-color: #ff5733; color: white; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center admin-header">
            <h1>Panel de Control</h1>
            <div>
                <span>Hola, <?php echo $_SESSION['user_name']; ?></span>
                <a href="index.php" class="btn btn-light btn-sm ms-2">Ver Tienda</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Salir</a>
            </div>
        </div>

        <?php if($mensaje) echo "<div class='alert alert-info'>$mensaje</div>"; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><i class="bi bi-plus-circle"></i> Agregar Producto</div>
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="accion" value="crear_producto">
                            <div class="mb-2">
                                <label>Nombre del Producto</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Precio</label>
                                <input type="number" step="0.01" name="precio" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Categoría</label>
                                <select name="categoria" class="form-control">
                                    <option value="Graphics">Gráfica (Graphics)</option>
                                    <option value="CPU">Procesador (CPU)</option>
                                    <option value="print">Memoria/Diseño (print)</option>
                                    <option value="motion">Almacenamiento/Motion</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label>Nombre de imagen (Ej: foto.jpg)</label>
                                <input type="text" name="imagen" class="form-control" placeholder="mi-producto.png" required>
                                <small class="text-muted">Asegúrate de que la imagen esté en assets/img/portfolio/</small>
                            </div>
                            <div class="mb-2">
                                <label>Specs (Detalles cortos)</label>
                                <input type="text" name="specs" class="form-control" placeholder="24GB RAM • RGB">
                            </div>
                            <div class="mb-2">
                                <label>Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                
                <div class="card">
                    <div class="card-header"><i class="bi bi-envelope"></i> Mensajes Recibidos</div>
                    <div class="card-body">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Asunto</th>
                                    <th>Mensaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM contactos ORDER BY fecha_envio DESC LIMIT 5";
                                $res = $conn->query($sql);
                                if($res->num_rows > 0){
                                    while($row = $res->fetch_assoc()){
                                        echo "<tr>";
                                        echo "<td>".$row['nombre']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        echo "<td>".$row['asunto']."</td>";
                                        echo "<td>".substr($row['mensaje'], 0, 50)."...</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No hay mensajes.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><i class="bi bi-people"></i> Últimos Suscriptores</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php
                            $sql_subs = "SELECT email FROM suscriptores ORDER BY fecha_suscripcion DESC LIMIT 5";
                            $res_subs = $conn->query($sql_subs);
                            while($sub = $res_subs->fetch_assoc()){
                                echo "<li class='list-group-item'>".$sub['email']."</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
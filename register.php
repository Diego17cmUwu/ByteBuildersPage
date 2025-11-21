<?php
require 'forms/db_connect.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

    // Por defecto el rol es 'cliente'. Solo tú desde la base de datos puedes cambiar a alguien a 'admin'.
    $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', 'cliente')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?registrado=Mq"); // Redirigir al login
        exit();
    } else {
        $mensaje = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro - Byte Builders</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        body { background: #1a1a1a; color: white; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .auth-card { background: #2a2a2a; padding: 2rem; border-radius: 10px; width: 100%; max-width: 400px; }
        .btn-primary { width: 100%; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2 class="text-center mb-4">Crear Cuenta</h2>
        <?php if($mensaje) echo "<div class='alert alert-danger'>$mensaje</div>"; ?>
        <form method="post">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-light">¿Ya tienes cuenta? Inicia sesión</a> | <a href="index.php" class="text-light">Volver al inicio</a>
            </div>
        </form>
    </div>
</body>
</html>
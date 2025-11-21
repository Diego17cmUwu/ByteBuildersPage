<?php
session_start(); // Iniciar la sesión
require 'forms/db_connect.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Contraseña correcta: Guardamos datos en la sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['rol'];
            
            header("Location: index.php"); // Redirigir al inicio
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "No existe una cuenta con este email.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Login - Byte Builders</title>
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
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        <?php if(isset($_GET['registrado'])) echo "<div class='alert alert-success'>¡Registro exitoso! Ingresa ahora.</div>"; ?>
        <?php if($mensaje) echo "<div class='alert alert-danger'>$mensaje</div>"; ?>
        <form method="post">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
            <div class="text-center mt-3">
                <a href="register.php" class="text-light">¿No tienes cuenta? Regístrate</a> | <a href="index.php" class="text-light">Volver al inicio</a>
            </div>
        </form>
    </div>
</body>
</html>
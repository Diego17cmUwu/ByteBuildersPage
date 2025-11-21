<?php
require 'forms/db_connect.php';

$email = "admin@bytebuilders.com";
$password = "admin123"; 
$nombre = "Super Admin";
$rol = "admin";

// Encriptamos la contraseña REALMENTE
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Borramos el admin anterior si existe para evitar duplicados
$conn->query("DELETE FROM usuarios WHERE email = '$email'");

// Insertamos el nuevo admin con la contraseña correcta
$sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password_hash', '$rol')";

if ($conn->query($sql) === TRUE) {
    echo "<h1>¡Admin creado con éxito!</h1>";
    echo "<p>Usuario: <b>$email</b></p>";
    echo "<p>Contraseña: <b>$password</b></p>";
    echo "<br><a href='login.php'>Ir al Login</a>";
} else {
    echo "Error: " . $conn->error;
}
?>
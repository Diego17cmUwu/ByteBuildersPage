<?php
require 'db_connect.php'; // Incluimos la conexión

// Recibir datos y limpiar para seguridad
$nombre = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$telefono = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
$asunto = $conn->real_escape_string($_POST['subject']);
$mensaje = $conn->real_escape_string($_POST['message']);

// Insertar en la base de datos
$sql = "INSERT INTO contactos (nombre, email, telefono, asunto, mensaje) 
        VALUES ('$nombre', '$email', '$telefono', '$asunto', '$mensaje')";

if ($conn->query($sql) === TRUE) {
    echo "OK"; // Respuesta simple para que el JS del frontend sepa que funcionó
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
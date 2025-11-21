<?php
require 'db_connect.php';

$email = $conn->real_escape_string($_POST['email']);

// Verificar si ya existe
$check = "SELECT id FROM suscriptores WHERE email = '$email'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "Este correo ya está suscrito.";
} else {
    $sql = "INSERT INTO suscriptores (email) VALUES ('$email')";
    if ($conn->query($sql) === TRUE) {
        echo "OK";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

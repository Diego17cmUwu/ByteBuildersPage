<?php
  include 'db_connection.php';

  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $subject = $_POST['subject'] ?? '';
  $message = $_POST['message'] ?? '';

  if ($name && $email && $message) {
      try {
          $stmt = $db->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)");
          $stmt->bindParam(':name', $name);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':phone', $phone);
          $stmt->bindParam(':subject', $subject);
          $stmt->bindParam(':message', $message);

          if ($stmt->execute()) {
              echo 'OK';
          } else {
              echo 'Error storing message.';
          }
      } catch (PDOException $e) {
          echo 'Database Error: ' . $e->getMessage();
      }
  } else {
      echo 'Missing required fields.';
  }
?>

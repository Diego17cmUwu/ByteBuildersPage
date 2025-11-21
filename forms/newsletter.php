<?php
  include 'db_connection.php';

  $email = $_POST['email'] ?? '';

  if ($email) {
      try {
          // Check if email already exists
          $stmt = $db->prepare("SELECT COUNT(*) FROM subscribers WHERE email = :email");
          $stmt->bindParam(':email', $email);
          $stmt->execute();
          if ($stmt->fetchColumn() > 0) {
               // Already subscribed, we can still return OK or a specific message.
               // For the generic handler 'OK' is best to show success.
               echo 'OK';
               exit;
          }

          $stmt = $db->prepare("INSERT INTO subscribers (email) VALUES (:email)");
          $stmt->bindParam(':email', $email);

          if ($stmt->execute()) {
              echo 'OK';
          } else {
              echo 'Error adding subscriber.';
          }
      } catch (PDOException $e) {
           // Duplicate entry might trigger exception if race condition, but we handled check above.
           // Also 'unique' constraint might trigger it.
           if ($e->getCode() == 23000) { // Integrity constraint violation
               echo 'OK'; // Treat duplicate as success
           } else {
               echo 'Database Error: ' . $e->getMessage();
           }
      }
  } else {
      echo 'Email address required.';
  }
?>

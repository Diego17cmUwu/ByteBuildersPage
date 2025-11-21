<?php
// forms/db_connection.php

try {
    // Create (connect to) SQLite database in a private folder
    // The path is relative to this file (forms/db_connection.php)
    // So ../private/database.sqlite puts it in the private folder at the root
    $db_path = __DIR__ . '/../private/database.sqlite';
    $db = new PDO('sqlite:' . $db_path);

    // Set errormode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they do not exist
    $db->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT,
        phone TEXT,
        subject TEXT,
        message TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS subscribers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

} catch(PDOException $e) {
    // Print error message
    die("Error connecting to database: " . $e->getMessage());
}
?>

<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'InvoiceDesk';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Creating database $db...\n";
    $pdo->exec("CREATE DATABASE `$db` ");
    echo "Database created successfully.\n";

} catch (PDOException $e) {
    if (strpos($e->getMessage(), "database exists") !== false) {
        echo "Database already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

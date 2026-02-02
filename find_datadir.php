<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $stmt = $pdo->query("SELECT @@datadir");
    $row = $stmt->fetch();
    echo "Data directory: " . $row[0] . "\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

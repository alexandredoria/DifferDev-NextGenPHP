<?php

$dsn = 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE') . ';user=' . getenv('DB_USERNAME') . ';password=' . getenv('DB_PASSWORD');

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Successful connection by pdo_pgsql!";
} catch(PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

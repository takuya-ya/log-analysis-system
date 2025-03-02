<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO(
        getenv('DB_DSN'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        $option
    );
    echo 'OK';
} catch (PDOException $e) {
    echo 'データベース接続に失敗しました:' . $e->getMessage() . PHP_EOL;
};

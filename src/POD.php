<?php

$config = require 'config.php';

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO(
        $config['dsn'],
        $config['user'],
        $config['password'],
        $option
    );
    echo 'OK';
} catch (PDOException $e) {
    echo 'データベース接続に失敗しました:' . $e->getMessage();
};

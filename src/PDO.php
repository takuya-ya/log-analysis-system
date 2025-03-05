<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

// echo 'メニューを選択して下さい';
// echo '1.ビュー数の多い記事を検索';
// echo '2.ドメインコードの中で人気な記事を検索';
// $menuNum = fgets(STDIN);

try {
    $pdo = new PDO(
        getenv('DB_DSN'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        $option
    );

    // ビュー数が多い記事の情報を取得
    $sql = 'SELECT domain_code, page_title, view_count
    FROM
        wiki_pageview_raw
    ORDER BY
        view_count DESC
    LIMIT :articlesNum';

    $sth = $pdo->prepare($sql);
    $articlesNum = 3;
    $sth->bindValue(':articlesNum', $articlesNum, PDO::PARAM_INT);
    $sth->execute();
    $pageViews = $sth->fetchAll();
    var_dump($pageViews);

    echo 'OK' . PHP_EOL;
} catch (PDOException $e) {
    echo 'データベース接続に失敗しました:' . $e->getMessage() . PHP_EOL;
};

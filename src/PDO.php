<?php

require 'vendor/autoload.php';

// .env ファイルを読み込むためのライブラリを使用
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// PDO のオプション設定
$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラーモードを例外（Exception）に設定
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // フェッチモードを連想配列に設定
];

// ユーザーにメニューを選択させる処理（コメントアウト中）
echo 'メニューを選択して下さい';
echo '1.ビュー数の多い記事を検索';
echo '2.ドメインコードの中で人気な記事を検索';
$selectedMenu = (int)trim(fgets(STDIN));

try {
    // 環境変数からデータベース接続情報を取得し、PDOインスタンスを作成
    $pdo = new PDO(
        getenv('DB_DSN'),      // DSN（データソース名）
        getenv('DB_USER'),     // ユーザー名
        getenv('DB_PASSWORD'), // パスワード
        $option                // オプション
    );

    // ビュー数が多い記事を取得する SQL 文
    $sql = 'SELECT domain_code, page_title, view_count
    FROM
        wiki_pageview_raw
    ORDER BY
        view_count DESC
    LIMIT :articlesNum';

    // SQL をプリペアドステートメントとして準備
    $sth = $pdo->prepare($sql);

    // 取得する記事の数を設定
    $articlesNum = 3;
    $sth->bindValue(':articlesNum', $articlesNum, PDO::PARAM_INT); // バインド

    // SQL を実行
    $sth->execute();

    // 実行結果をすべて取得（連想配列として）
    $pageViews = $sth->fetchAll();
    var_dump($pageViews); // 取得データの内容を出力（デバッグ用）

    echo 'OK' . PHP_EOL; // 成功メッセージ
} catch (PDOException $e) {
    // エラー発生時にメッセージを表示
    echo 'データベース接続に失敗しました:' . $e->getMessage() . PHP_EOL;
};

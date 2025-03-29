<?php

require __DIR__ . '/../vendor/autoload.php';

use LogAnalysisSystem\MenuFactory;
use LogAnalysisSystem\DBConnector;
use LogAnalysisSystem\Validator;

ini_set('log_errors', 'On');
ini_set('error_log', __DIR__ . '/log/error.log');

// データベース接続
$pdo = new DBConnector();
$pdo = $pdo->getPDO();

// ユーザーにメニューを選択させる処理
echo 'メニュー番号を選択して下さい' . PHP_EOL;
echo '1.ビュー数の多い記事を検索' . PHP_EOL;
echo '2.ドメインコードの中で人気な記事を検索' . PHP_EOL;
// TODO;メニューから抜ける選択肢実装
// echo '9.終了する' . PHP_EOL;

// メニューの選択
$selectedMenu = trim(fgets(STDIN));
// 数字のみの文字列か判定
$validator = new Validator;
$return = $validator->validateNumeric($selectedMenu);
// 数字以外の入力の場合は終了
if ($return) {
    exit;
};

// 選択番号に応じてインスタンス作成
// 対応していないメニュー番号の場合、matct式によりスロー発生
try {
    $menu = MenuFactory::createClass($selectedMenu);
} catch (UnhandledMatchError $e) {
    exit('対応していないメニュー番号です。' . PHP_EOL);
}

// インスタンスでデータ取得メソッド実行
try {
    $menu->executeMenu($pdo);
} catch (PDOException $e) {
    // スタックトレースでエラーの発生行など確認
    error_log($e->getMessage() . PHP_EOL . $e->getTraceAsString());
    echo 'DBエラーが発生しました。' . PHP_EOL;
    exit;
}

// 取得データを出力
$menu->displayData();

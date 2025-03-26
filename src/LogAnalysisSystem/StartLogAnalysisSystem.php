<?php

require __DIR__ . '/../vendor/autoload.php';

use LogAnalysisSystem\MenuFactory;
use LogAnalysisSystem\DBConnector;

$pdo = new DBConnector();
$pdo = $pdo->getPDO();

// ユーザーにメニューを選択させる処理
echo 'メニュー番号を選択して下さい' . PHP_EOL;
echo '1.ビュー数の多い記事を検索' . PHP_EOL;
echo '2.ドメインコードの中で人気な記事を検索' . PHP_EOL;
// TODO;メニューから抜ける選択肢実装
// echo '9.終了する' . PHP_EOL;

$selectedMenu = trim(fgets(STDIN));
// 文字列を
if (!ctype_digit($selectedMenu)) {
    exit('メニュー番号は半角英数字で入力して下さい。' . PHP_EOL);
};

// 対応していないメニュー番号の場合、matct式によりスロー発生
try {
    $menu = MenuFactory::createClass($selectedMenu);
} catch (UnhandledMatchError $e) {
    exit('対応していないメニュー番号です。' . PHP_EOL);
}

// データを取得
$menu->executeMenu($pdo);

// 取得データを出力
$menu->displayData();

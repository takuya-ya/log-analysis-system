<?php

require __DIR__ . '/../vendor/autoload.php';

use LogAnalysisSystem\MenuFactory;
use LogAnalysisSystem\DBConnector;

$pdo = new DBConnector();
$pdo = $pdo->getPDO();

// ユーザーにメニューを選択させる処理
echo 'メニューを選択して下さい' . PHP_EOL;
echo '1.ビュー数の多い記事を検索' . PHP_EOL;
echo '2.ドメインコードの中で人気な記事を検索' . PHP_EOL;

$selectedMenu = (int)trim(fgets(STDIN));

$menu = MenuFactory::createClass($selectedMenu);

// データを取得
$menu->executeMenu($pdo);

// 取得データを出力
$menu->displayData();

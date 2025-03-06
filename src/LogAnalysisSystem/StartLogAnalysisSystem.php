<?php

require '../vendor/autoload.php';

use LogAnalysisSystem\MenuFactry;
use LogAnalysisSystem\DBConnector;

$pdo = new DBConnector();
$pdo = $pdo->getPDO();
var_dump($pdo);

// ユーザーにメニューを選択させる処理
echo 'メニューを選択して下さい' . PHP_EOL;
echo '1.ビュー数の多い記事を検索' . PHP_EOL;
echo '2.ドメインコードの中で人気な記事を検索' . PHP_EOL;

$selectedMenu = (int)trim(fgets(STDIN));

$menu = MenuFactry::createClass($selectedMenu);

$menu->executeMenu($this->pdo);

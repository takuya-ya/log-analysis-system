<?php

namespace LogAnalysisSystem;

use LogAnalysisSystem\MenuAction;
use PDO;

class GetPopularArticlesByDomain implements MenuAction
{
    private $totalViewsByDomain = [];

    public function executeMenu(PDO $pdo): void
    {
        // ドメインコード毎にグループ化し、各ドメインの合計ビュー数を取得する

        // SQLプレースホルダーとバインド用のパラメータを格納するための配列を初期化
        $placeholders = [];
        $params = [];

        // ユーザーに入力を促すメッセージを表示
        echo '取得するデータのドメイン名を入力して下さい。' . PHP_EOL;
        echo 'スペースで区切る事で、複数のドメイン名を入力可能です。' . PHP_EOL;

        // 標準入力（コンソール）からドメイン名を取得し、余分な空白を除去
        $inputs = trim(fgets(STDIN));

        // 入力されたドメイン名をスペース区切りで配列に変換
        $domain_codes = explode(' ', $inputs);

        // 各ドメインコードに対応するプレースホルダーとバインド用パラメータを作成
        foreach ($domain_codes as $index => $domain_code) {
            $key = ":domain$index"; // 例: ":domain0", ":domain1", ":domain2"...
            $placeholders[] = $key;  // プレースホルダー配列に追加
            $params[$key] = $domain_code; // プレースホルダーにバインドする値をセット
        }

        // プレースホルダーをカンマ区切りで結合し、IN 句に挿入する文字列を作成
        $string = implode(',', $placeholders);

        // ドメインコード毎の合計ビュー数を取得するSQLクエリ
        $sql = "SELECT
                    domain_code, SUM(view_count)
                FROM
                    wiki_pageview_raw
                WHERE
                    domain_code IN ($string)  -- プレースホルダーがここに入る
                GROUP BY
                    domain_code";

        // SQLを準備（プレースホルダーを利用してSQLインジェクション対策）
        $stmh = $pdo->prepare($sql);

        // バインドしたパラメータを設定してSQLを実行
        $stmh->execute($params);

        // 結果をすべて取得
        $this->totalViewsByDomain = $stmh->fetchAll();
    }

    // 取得したデータを出力
    public function displayData(): void
    {
        foreach ($this->totalViewsByDomain as $pageViewByDomain) {
            echo "\"{$pageViewByDomain['domain_code']}\", {$pageViewByDomain['SUM(view_count)']}" . PHP_EOL;
        }
    }
}

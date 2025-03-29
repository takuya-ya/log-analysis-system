<?php

namespace LogAnalysisSystem;

use LogAnalysisSystem\MenuAction;
use LogAnalysisSystem\Validator;
use PDO;
use PDOException;

class GetMostViewsArticles implements MenuAction
{
    private $pageViews = [];
    public function executeMenu(PDO $pdo): void
    {
        // ビュー数が多い記事を取得する SQL 文
        $sql = 'SELECT domain_code, page_title, view_count
        FROM
            wiki_pageview_raw
        ORDER BY
            view_count DESC
        LIMIT :articlesNum';

            // PDOStatement クラスを作成
            // SQL を事前解析（静的）し、プリペアドステートメントとして準備。
            $sth = $pdo->prepare($sql);
            echo '取得する記事数を入力してください。' . PHP_EOL;
            // 取得する記事の数を設定
            $desiredArticleCount = trim(fgets(STDIN));
            $validator = new Validator();
            $return = $validator->validateNumeric($desiredArticleCount);
            if($return) {
                exit;
            }

            // 第3引数は省略可能だが、明示することで型の誤認識を防ぐ（ここでは整数型を指定）
            $sth->bindValue(':articlesNum', $desiredArticleCount, PDO::PARAM_INT); // バインド

            // SQL を実行
            $sth->execute();

            // 実行結果をすべて取得（連想配列として）
            $this->pageViews = $sth->fetchAll();
    }

    public function displayData(): void
    {
        foreach ($this->pageViews as $pageView) {
            echo "\"{$pageView['domain_code']}\", \"{$pageView['page_title']}\", {$pageView['view_count']}" . PHP_EOL;
        }
    }
}

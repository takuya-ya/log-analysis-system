<?php

namespace LogAnalysisSystem;

use LogAnalysisSystem\MenuAction;
use PDO;

class GetMostViewsArticles implements MenuAction
{

    public function executeMenu(PDO $pdo): array
    {

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
        // 第3引数は省略可能だが、明示することで型の誤認識を防ぐ（ここでは整数型を指定）
        $sth->bindValue(':articlesNum', $articlesNum, PDO::PARAM_INT); // バインド

        // SQL を実行
        $sth->execute();

        // 実行結果をすべて取得（連想配列として）
        $pageViews = $sth->fetchAll();
        return $pageViews;
    }
}

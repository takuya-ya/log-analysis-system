<?php

namespace LogAnalysisSystem;

use LogAnalysisSystem\MenuAction;
use PDO;

class GetPopularArticlesByDomain implements MenuAction
{
    public function executeMenu(PDO $pdo): array
    {
        // ドメインコード毎にグループ化し、ドメインコード名と、合計ビュー数を取得。
        $sql =
            'SELECT domain_code, SUM(view_count)
            FROM
            wiki_pageview_raw
            WHERE
            domain_code IN (:domain_code)
            GROUP BY
            domain_code'
        ;

        $domain_code = 'en';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':domain_code', $domain_code, PDO::PARAM_STR);

        $sth->execute();
        $totalViewByDomain = $sth->fetchAll();
        // 結果の取得
        return $totalViewByDomain;
    }
}

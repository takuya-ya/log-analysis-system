<?php

namespace LogAnalysisSystem;

use LogAnalysisSystem\MenuAction;

class MenuFactory
{
    public static function createClass(int $menuNum): ?MenuAction
    {
        return match($menuNum) {
            1 => new GetMostViewsArticles(),
            2 => new GetPopularArticlesByDomain(),
            default => null
        };
    }
}

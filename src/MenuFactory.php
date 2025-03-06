<?php

public function MenuFactry(int $menuNum): ?MenuAction {
    return match($menuNum) {
        1 => new getMostViewsArticles(),
        2 => new getPopularArticlesByDomain(),
        default => null
    }
} 
<?php

namespace App\Service;

use App\DTO\ArticleFormDTO;
use App\Entity\Article;

class ArticleService
{
    public function saveArticleFormDTO(ArticleFormDTO $articleFormDTO): void
    {
        $article = new Article();
        $article->title = $articleFormDTO->title;
        $article->status = $articleFormDTO->status;
        // ...
    }
}
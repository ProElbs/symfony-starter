<?php

namespace App\Twig;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private ArticleRepository $articleRepository) {}
    public function getFunctions(): array
    {
        return [
            new TwigFunction('countUpper', [$this, 'countUpperLetter']),
//            new TwigFunction('getMostRecentArticle', [$this, 'getMostRecentArticle']),
        ];
    }
    public function getFilters(): array
    {
        return [
            new TwigFilter('countUpper', [$this, 'countUpperLetter']),
//            new TwigFilter('statusIcon', [$this, 'statusIcon']),
        ];
    }

    public function countUpperLetter(string $string): int
    {
        $upperLetters = preg_replace('![^A-Z]+!', '', $string);
        if ($upperLetters === null) {
            return 0;
        }
        return mb_strlen($upperLetters);
    }

    // TODO RUN MIGRATIONS
//    public function getMostRecentArticle(): ?Article
//    {
//        $article = $this->articleRepository->getMostRecent();
//
//        if (!$article instanceof Article) {
//            return null;
//        }
//
//        return $article;
//    }
//
//    /**
//     * Filter to render a beautiful label regarding the given status
//     * (published = green, draft = orange, archived = grey ...)
//     */
//    public function statusIcon(Object $object): ?string
//    {
//        $icon = '<span class="label label-%s">%s</span>';
//
//        if ($object instanceof Article) {
//            $label = match ($object->status) {
//                Article::STATUS_PUBLISHED => 'success',
//                Article::STATUS_DRAFT => 'warning',
//                default => 'info',
//            };
//
//            return sprintf($icon, $label, $object->status);
//        }
//
//        return null;
//    }
}
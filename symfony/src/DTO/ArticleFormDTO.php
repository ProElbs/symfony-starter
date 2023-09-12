<?php

namespace App\DTO;

use App\Enum\ArticleStatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleFormDTO
{
    #[Assert\NotBlank]
    public string $title;
    public string $status = ArticleStatusEnum::STATUS_DRAFT;
    /** @var array<TagFormDTO>|null */
    public ?array $tags = null;
}
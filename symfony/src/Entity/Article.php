<?php

namespace App\Entity;

use App\Enum\ArticleStatusEnum;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(length: 255)]
    public string $title;

    #[ORM\Column]
    public string $status = ArticleStatusEnum::STATUS_DRAFT;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: "articles")]
    #[ORM\JoinTable(name: "article_tags")]
    #[ORM\JoinColumn(name: "tag_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "article_id", referencedColumnName: "id")]
    public Collection $tags;

    #[ORM\Column(type: "datetime")]
    public DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    public DateTime $updatedAt;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }
}
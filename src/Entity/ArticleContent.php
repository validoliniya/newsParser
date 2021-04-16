<?php

namespace App\Entity;

use App\Repository\ArticleContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleContentRepository::class)
 */
class ArticleContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content = '';

    /**
     * @ORM\Column(type="array")
     */
    private $imgSources = [];

    /**
     * @ORM\OneToOne(targetEntity=Article::class, inversedBy="content", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImgSources(): array
    {
        return $this->imgSources;
    }

    public function setImgSources(array $imgSources): self
    {
        $this->imgSources = $imgSources;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}

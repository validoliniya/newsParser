<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $header = '';

    /**
     * @ORM\ManyToOne(targetEntity=NewsResource::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $resource;

    /**
     * @ORM\OneToOne(targetEntity=ArticleContent::class, mappedBy="article", cascade={"persist", "remove"})
     */
    private $content;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    public function getResource(): ?NewsResource
    {
        return $this->resource;
    }

    public function setResource(NewsResource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getContent(): ?ArticleContent
    {
        return $this->content;
    }

    public function setContent(ArticleContent $content): self
    {
        // set the owning side of the relation if necessary
        if ($content->getArticle() !== $this) {
            $content->setArticle($this);
        }

        $this->content = $content;

        return $this;
    }
}

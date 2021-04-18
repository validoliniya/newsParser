<?php

namespace App\Model;

use App\Entity\Article;
use App\Entity\ArticleContent;
use App\Repository\NewsResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ArticleModel
{
    public EntityManagerInterface $entityManager;
    public NewsResourceRepository $newsResourceRepository;
    public LoggerInterface        $logger;
    public FileSystem             $fileSystem;
    public string                 $imgDir;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, NewsResourceRepository $newsResourceRepository, FileSystem $fileSystem, string $imgDir)
    {
        $this->entityManager          = $entityManager;
        $this->fileSystem             = $fileSystem;
        $this->newsResourceRepository = $newsResourceRepository;
        $this->logger                 = $logger;
        $this->imgDir                 = $imgDir;
    }

    public function saveArticlesByResource(array $news, string $resourceName): void
    {
        $resource = $this->newsResourceRepository->findOneByName($resourceName);
        foreach ($news as $header => $content) {
            $article = (new Article())
                ->setResource($resource)
                ->setHeader($header);
            if (isset($content['date'])) {
                $article->setDate($content['date']);
            }

            $this->entityManager->persist($article);
            $this->entityManager->flush();
            $articleContent = (new ArticleContent())
                ->setArticle($article)
                ->setContent($content['text']);
            if (isset($content['img'])) {
                $articleContent->setImgSources($content['img']);
            }
            $article->setContent($articleContent);
            $this->entityManager->persist($articleContent);
            $this->entityManager->flush();
            $articles[$article->getId()] = $article;
        }
    }
}
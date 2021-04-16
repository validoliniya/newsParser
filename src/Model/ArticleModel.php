<?php

namespace App\Model;

use App\Entity\Article;
use App\Entity\ArticleContent;
use App\Repository\NewsResourceRepository;
use DateTime;
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

    public function saveArticlesByResource(array $news, string $resourceName): array
    {
        $articles = [];
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

        return $articles;
    }

    public function saveArticleImages(string $resourceName, array $img): array
    {
        $newSrc = [];
        $imgDir = sprintf('%s/%s', $this->imgDir, $resourceName);
        if (!is_dir(dirname($imgDir))) {
            $this->fileSystem->mkdir(dirname($imgDir));
        }

        foreach ($img as $index => $src) {
            try {
                $date         = new DateTime();
                $relativePath = sprintf('%s/image_%s_%d.gif', $resourceName, $date->format('Y_m_d_H_i'), $index);
                $absolutePath = sprintf('%s/%s', $this->imgDir, $relativePath);
                file_put_contents($absolutePath, file_get_contents($src));
                $newSrc[] = $relativePath;
            } catch (\Exception $exception) {
                $this->logger->error($exception);
            }
        }

        return $newSrc;
    }
}
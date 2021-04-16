<?php

namespace App\Controller\View;

use App\Entity\NewsResource;
use App\Model\ArticleModel;
use App\Repository\ArticleRepository;
use App\Repository\NewsResourceRepository;
use App\Services\Parser\RbkParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RbkNewsController extends AbstractController
{
    /**
     * @Route("/rbk/news", name="rbk.news")
     */
    public function index(ArticleModel $articleModel,NewsResourceRepository $newsResourceRepository,ArticleRepository $articleRepository): Response
    {
        $resource = $newsResourceRepository->findOneByName(NewsResource::RBK);
        $news   = RbkParser::parseNewsBlock($resource->getUrl());
        $articles = $articleModel->saveArticlesByResource($news,NewsResource::RBK);

//        $articles = $articleRepository->findLastArticles(15);

        return $this->render('News/rbk_news.html.twig',
            [
                'articles' => $articles
            ]
        );
    }
}

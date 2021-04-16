<?php

namespace App\Controller\Api\v1;
use App\Repository\ArticleContentRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/rbk")
 */
class RbkNewsController
{
    /**
     * @Rest\Get("/news/{id}", name="rbk.news.getArticleContent")
     * @param int       $id
     * @return JsonResponse
     */

    public function getArticleContent(ArticleContentRepository $articleContentRepository,int $id):JsonResponse
    {
        $content = $articleContentRepository->findOneByArticleId($id);
        if(empty($content)){
            return new JsonResponse([],Response::HTTP_NO_CONTENT);
        }

        $result = [
            'text' => $content->getContent(),
            'img' => $content->getImgSources()
        ];

        return new JsonResponse($result);
    }

}
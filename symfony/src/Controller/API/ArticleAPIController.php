<?php

namespace App\Controller\API;

use App\Controller\JsonFormExtractorTrait;
use App\DTO\API\Response\JsonErrorResponseDTO;
use App\DTO\ArticleFormDTO;
use App\Exception\FormException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAPIController extends AbstractController
{
    use JsonFormExtractorTrait;

    #[Route('/articles', name: 'articles', methods: ['POST'])]
    public function postArticles(
        Request $request
    ): JsonResponse {
        $response = new JsonResponse();
        try {
            /** @var ArticleFormDTO $brandSearchDTO */
            $articleFormDTO = $this->extract(ArticleFormDTO::class, $request->getContent());
            // Do whatever you want with the formDTO
            dump($articleFormDTO);
            exit;
        } catch (FormException $exception) {
            $json = new JsonErrorResponseDTO();
            $json->message = $exception->getMessage();
            $json->errors = $exception->getErrors();
            $response->setData($json);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }


        return $response;
    }
}
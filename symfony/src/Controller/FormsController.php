<?php

namespace App\Controller;

use App\DTO\ArticleFormDTO;
use App\Entity\Article;
use App\Entity\Tag;
use App\Enum\ArticleStatusEnum;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forms', name: 'forms_')]
class FormsController extends AbstractController
{
    use JsonFormExtractorTrait;
    #[Route('/symfony', name: 'symfony')]
    public function formSymfony(
        Request $request
    ): Response {

        $article = new Article();

        // dummy code - add some example tags to the task
        // (otherwise, the template will render an empty list of tags)
        $tag1 = new Tag();
        $tag1->name = 'tag1';
        $tag1->description = 'description1';
        $article->tags->add($tag1);
        $tag2 = new Tag();
        $tag2->name = 'tag2';
        $tag2->description = 'description2';
        $article->tags->add($tag2);


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... do your form processing, like saving the Task and Tag entities
            dump($form->getData());
            exit;
        }

        return $this->render('forms/symfony.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dto', name: 'dto')]
    public function formWithDto(
    ): Response {
        // Here you can look for article in database and send as DTO to front IN A SERVICE NOT LIKE THIS EXAMPLE
        $articleFormDto = new ArticleFormDTO();
        $articleFormDto->title = 'toto';
        return $this->render('forms/with_dto.html.twig', [
            'articleStatusChoices' => ArticleStatusEnum::getConstants(),
            'article' => $articleFormDto,
        ]);
    }
}
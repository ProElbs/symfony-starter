<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltersController extends AbstractController
{
    #[Route('/filters', name: 'filters_page')]
    public function filters(): Response
    {
        // Imagine we have a service returning a string
        $myString = 'Hello Mister Auto';
        return $this->render('filters/view.html.twig', [
            'myString' => $myString
        ]);
    }
}
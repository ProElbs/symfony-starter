<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function home(): Response
    {
        // Imagine we have a service returning a string
        $myString = 'Hello Mister Auto';
        return $this->render('home/view.html.twig', [
            'myString' => $myString
        ]);
    }
}
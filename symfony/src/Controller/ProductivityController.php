<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductivityController extends AbstractController
{
    #[Route('/productivity', name: 'productivity_page')]
    public function home(): Response
    {
        return $this->render('productivity/view.html.twig');
    }
}
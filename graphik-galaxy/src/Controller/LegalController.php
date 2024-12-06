<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/legales', name: 'app_legal')]
    public function legales(): Response
    {
        return $this->render('legal/legal.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
    #[Route('/cgv', name: 'app_conditions')]
    public function conditions(): Response
    {
        return $this->render('legal/conditions.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}

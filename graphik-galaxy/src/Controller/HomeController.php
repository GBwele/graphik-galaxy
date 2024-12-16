<?php

namespace App\Controller;

use App\Service\Randomize;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Randomize $randomize): Response
    {
        $randomTagline = $randomize->getRandomTagline();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            // 'random_tagline' => $randomTagline,
        ]);




    }




}


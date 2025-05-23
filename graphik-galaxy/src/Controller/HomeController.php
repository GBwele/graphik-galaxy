<?php

namespace App\Controller;

use App\Repository\CommentairesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductsRepository $productsRepository, CommentairesRepository $commentairesRepository): Response
    {
        $derniersProduits = $productsRepository->findBy([], ['id' => 'DESC'], 4);

        $derniersCommentaires = $commentairesRepository->findBy([], ['dates' => 'DESC'], 5);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'derniersProduits' => $derniersProduits,
            'derniersCommentaires' => $derniersCommentaires
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details')]
    public function index(ProductsRepository $productsRepository, $id): Response
    {

        $produit = $productsRepository->find($id);


        return $this->render('details/index.html.twig', [
            'controller_name' => 'DetailsController',
        ]);
    }
}

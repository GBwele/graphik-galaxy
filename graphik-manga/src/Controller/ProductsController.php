<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductsController extends AbstractController
{
    #[Route('/products/{categories}', name: 'app_products')]
    public function index(ProductsRepository $productsRepository, $categories): Response
    {

        $css = $categories == 'goodies' ? 'ban-goodies' : ($categories == 'comics' ? 'ban-comics' : ($categories == 'mangas' ? 'ban-mangas' : 'ban-tout'));
        if ($categories != 'tout') {
            $produits = $productsRepository->findBy(['categorie' => $categories]);
        } else {
            $produits = $productsRepository->findAll();
        }
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'produits' => $produits,
            'classe_banniere' => $css
        ]);
    }
}

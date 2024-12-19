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

        $css = $categories == 'Goodies' ? 'ban-goodies' : ($categories == 'Comics' ? 'ban-comics' : ($categories == 'Mangas' ? 'ban-mangas' : 'ban-tout'));
        if ($categories != 'tout') {
            $produits = $productsRepository->findBy(['categorie' => $categories]);
        } else {
            $produits = $productsRepository->findAll();
        }


        if($categories == 'tout'){
            $categories = 'Produits';
        }


$dernierProduit = $productsRepository->findOneBy([],['id' => 'DESC']);






        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
            'produits' => $produits,
            'classe_banniere' => $css,
            'categorie' => $categories,
            'dernierProduit' => $dernierProduit

        ]);
    }
}

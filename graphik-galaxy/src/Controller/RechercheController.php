<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche-produits', name: 'app_recherche')]
    public function rechercheProduits( Request $request,ProductsRepository $productsRepository):  JsonResponse
    {


        $recherche=$request->query->get('q');

        if (strlen($recherche) < 2) {
            return new JsonResponse([]);
        }
        
        $products = $productsRepository->searchByName($recherche);

        $results = array_map(function($product){
            return[
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'url' => $this->generateUrl('product_details', ['id'=> $product->getId()])
            ];
        }, $products);




        return new JsonResponse($results);
    }
}

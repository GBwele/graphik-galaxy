<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class PanierController extends AbstractController
{
    #[Route('/ajout', name: 'app_panier')]
    public function index(Request $request, ProductsRepository $productsRepository): JsonResponse {



        $productId = $request->request->get('id');
        $product = $productsRepository->find($productId); 



        if(!$product){
            return new JsonResponse(['error' => 'Produit non trouvé'], 404);
        }

        $session = $request->getSession(); 
        $cart = $session ->get('cart',[]); 

        if (isset($cart[$productId])){
            $cart[$productId]['quantity']++;            
        }else{
            $cart[$productId] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => 1
            ];
        }


        $session->set('cart', $cart); 

        return new JsonResponse(['success'=> 'Produit ajouté au panier']);

     
    }
       #[Route('/panier', name: 'app_panier')]

       public function vue(Request $request): JsonResponse{

        $session = $request->getSession();
        $cart = $session->get('cart', []);

        return new JsonResponse($cart);
       }


}

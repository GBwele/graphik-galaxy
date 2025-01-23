<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StocksController extends AbstractController
{
    #[Route('/stocks', name: 'app_stocks')]
    public function updateStock(Request $request, ProductsRepository $productsRepository, EntityManagerInterface $entityManagerInterface): JsonResponse
    {

        // $cart = $request->getSession()->get('cart',[]);

        // try{
        //     foreach($cart as $productId => $item){
        //         $product = $productsRepository->find($productId); 

        //         if ($product->getStocks() < $item['quantity']) {
        //             return new JsonResponse([
        //                 'error' => "stock  insuffisant pour {$product->getNom()}"
        //             ], 400 );

        //         }


        //     }




        // }




        return $this->render('stocks/index.html.twig', [
            'controller_name' => 'StocksController',
        ]);
    }
}

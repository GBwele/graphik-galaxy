<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


class PanierController extends AbstractController
{
    #[Route('/panier/ajout', name: 'app_addpanier')]
    public function ajoutPanier(Request $request, ProductsRepository $productsRepository, SessionInterface $session): JsonResponse
    {
        $result = json_decode($request->getContent(), true);

        $productId = $result['id'];
        if (!$productId) {
            return new JsonResponse(['error' => 'ID de produit manquant'], 400);
        }


        $product = $productsRepository->find($productId);
        if (!$product) {
            return new JsonResponse(['error' => 'Produit non trouvé'], 404);
        }

        $cart = $session->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->getNom(),
                'price' => $product->getPrix(),
                'quantity' => 1
            ];
        }
        $session->set('cart', $cart);

        return new JsonResponse(
            [
                'success' => 'Produit ajouté au panier',
                'cart' => $cart,
            ]
        );
    }



    #[Route('/panier', name: 'app_panier')]

    public function panierVue(Request $request): Response
    {

        $session = $request->getSession();
        $cart = $session->get('cart', []);
        $prixTotal = 0;

        foreach ($cart as $c) {
            $prixTotal += $c['price'] * $c['quantity'];
        }

        return $this->render('panier/index.html.twig', [
            'cart' => $cart,
            'prixTotal' => $prixTotal
        ]);
    }
}

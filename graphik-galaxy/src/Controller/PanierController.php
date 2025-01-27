<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Commande;
use App\Entity\CommandeProduits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


class PanierController extends AbstractController
{
    #[Route('/panier/ajout', name: 'app_addpanier')]
    public function ajoutPanier(Request $request, ProductsRepository $productsRepository, SessionInterface $session, EntityManagerInterface $entityManager): JsonResponse
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

        if ($product->getStocks() <= 0) {
            return new JsonResponse(['error' => 'Produit en rupture de stock'], 400);
        }

        $cart = $session->get('cart', []);

        $currentQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        if (($currentQuantity + 1) > $product->getStocks()) {
            return new JsonResponse(['error' => 'Stock insuffisant'], 400);
        }

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

        $nb = count($cart);
        $session->set('nb', $nb);


        $product->setStocks($product->getStocks() - 1); // -1 car on ajoute un seul produit
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(
            [
                'success' => 'Produit ajouté au panier',
                'cart' => $cart,
                'nb' => $nb
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

        $session->set('prixTotal', $prixTotal);

        return $this->render('panier/index.html.twig', [
            'cart' => $cart,
            'prixTotal' => $prixTotal
        ]);
    }




    #[Route('/panier/supprimer', name: 'app_removepanier')]

    public function supprimerPanier(Request $request, SessionInterface $session, EntityManagerInterface $entityManager, ProductsRepository $productsRepository): JsonResponse
    {

        $result = json_decode($request->getContent(), true);
        $productId = $result['id'];
        $cart = $session->get('cart', []);

        if (isset($cart[$productId])) {

            //  quantité a mettre en stock récupérée
            $quantityRestoration = $cart[$productId]['quantity'];


            $product = $productsRepository->find($productId);
            $product->setStocks($product->getStocks() + $quantityRestoration);
            $entityManager->persist($product);
            $entityManager->flush();


            // suppression panier
            unset($cart[$productId]);
            $session->set('cart', $cart);
            $nb = count($cart);
            $session->set('nb', $nb);


            // prix total
            $prixTotal = 0;
            foreach ($cart as $c) {
                $prixTotal += $c['price'] * $c['quantity'];
            }
            return new JsonResponse([
                'success' => 'Produit supprimé du panier',
                'cart' => $cart,
                'nb' => $nb,
                'total' => $prixTotal
            ]);
        }

        return new JsonResponse(['error' => 'Produit non trouvé dans le panier'], 404);
    }


    #[Route('/panier/update-quantite', name: 'app_update_quantity')]
    public function updateQuantite(Request $request, SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des données envoyées
        $data = json_decode($request->getContent(), true);
        $productId = $data['id'] ?? null;
        $quantity = $data['quantity'] ?? null;

        // Vérifications de base
        if (!$productId || !$quantity || $quantity < 1) {
            return new JsonResponse([
                'error' => 'Données invalides',
                'status' => 'error'
            ], 400);
        }

        // modifications updateQuantite
        $product = $productsRepository->find($productId);
        if (!$product) {
            return new JsonResponse(['error' => 'Produit non trouvé'], 404);
        }

        // Vérification si le produit existe dans le panier+
        // Récupération du panier
        $cart = $session->get('cart', []);
        if (!isset($cart[$productId])) {
            return new JsonResponse([
                'error' => 'Produit non trouvé dans le panier',
                'status' => 'error'
            ], 404);
        }
        
        
        if ($quantity > $product->getStocks()) {
            
            return new JsonResponse([
                'error' => 'Stock insuffisant',
                'stockDisponible' => $product->getStocks()
            ], 400);
        }
        
        // ancienne quantité avant modification stockée
        $previousQuantity = $cart[$productId]['quantity'];
   
        // Calcule la différence pour ajuster le stock
        $difference = (int)$quantity - $previousQuantity;

        // Mise à jour du stock : si difference positive = retrait de stock, si négative = ajout
        $product->setStocks($product->getStocks() - $difference);
        $entityManager->persist($product);
        $entityManager->flush();

     


        // Mise à jour de la quantité
        $cart[$productId]['quantity'] = (int)$quantity;
        $session->set('cart', $cart);

        // Calcul du nouveau total
        $prixTotal = 0;
        foreach ($cart as $item) {
            $prixTotal += $item['price'] * $item['quantity'];
        }


        // Retour des nouvelles données
        return new JsonResponse([
            'success' => true,
            'newTotal' => $prixTotal,
            'productTotal' => $cart[$productId]['price'] * $cart[$productId]['quantity'],
            'message' => 'Quantité mise à jour avec succès'
        ]);
    }

    #[Route('/panier/checkout', name: 'app_checkout')]
    public function checkoutVue(request $request,EntityManagerInterface $entityManager): Response
    {
        $cart = $request->getSession()->get('cart', []);
        $prixTotal = $request->getSession()->get('prixTotal', 0);


        $commande = new Commande();
        $commande->setUser($this->getUser());
        $commande->setDate(new \DateTime());
        $commande->setTotal($prixTotal); 
        $commande->setStatut('Validée'); 


        foreach ($cart as $id =>$item){

            $commandeProduit = new CommandeProduits();
            $commandeProduit->setCommande($commande);
            $commandeProduit->setProduits($entityManager->getReference(Products::class, $id));
            $commandeProduit->setQuantité($item['quantity']);
            $entityManager->persist($commandeProduit);

        }

        $entityManager->persist($commande);
        $entityManager->flush();


        $request->getSession()->remove('cart');
        $request->getSession()->set('nb',0);




        return $this->redirectToRoute('commande_succes');
    }
}

<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Commande;
use App\Entity\CommandeProduits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function recupPaiement(Request $request): Response
    {
        // Récupération de nouveau si besoin :
        $prixTotal = $request->getSession()->get('prixTotal', 0);

        return $this->render('payment/index.html.twig', [
            'checkoutTotal' => $prixTotal,
        ]);
    }

    #[Route('/commande/succes', name: 'commande_success')]

    public function success(request $request, EntityManagerInterface $entityManager): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        // Vérification du panier
        $cart = $request->getSession()->get('cart', []);
        if (empty($cart)) {
            return $this->redirectToRoute('app_home');
        }




            $cart = $request->getSession()->get('cart', []);
            $prixTotal = $request->getSession()->get('prixTotal', 0);


            $commande = new Commande();
            $commande->setUser($this->getUser());
            $commande->setDate(new \DateTime());
            $commande->setTotal($prixTotal);
            $commande->setStatut('Validée');


            foreach ($cart as $id => $item) {

                $commandeProduit = new CommandeProduits();
                $commandeProduit->setCommande($commande);
                $commandeProduit->setProduits($entityManager->getReference(Products::class, $id));
                $commandeProduit->setQuantité($item['quantity']);
                $entityManager->persist($commandeProduit);
            }

            $entityManager->persist($commande);
            $entityManager->flush();


            $request->getSession()->remove('cart');
            $request->getSession()->set('nb', 0);




            return $this->render('commande/success.html.twig');
        }

    
}

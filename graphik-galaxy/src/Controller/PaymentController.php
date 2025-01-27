<?php

namespace App\Controller;

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

    #[Route('/commande/succes', name: 'commande_succes')]

    public function success(): Response
    {
        return $this->render('commande/success.html.twig');
    }
}

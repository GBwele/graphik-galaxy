<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentaireType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_details')]
    public function index(ProductsRepository $productsRepository, EntityManagerInterface $entityManager, Request $request, $id): Response
    {

        $produit = $productsRepository->find($id);
        $commentaire = new Commentaires();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setProducts($produit);
            $commentaire->setUser($this->getUser());
            $commentaire->setDates(new \DateTimeImmutable());

            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté !');
            return $this->redirectToRoute('app_details', ['id' => $id]);
        }



        return $this->render('details/index.html.twig', [
            'produit'=> $produit, 
            'commentForm' => $form->createView(),
            'commentaires' => $produit->getCommentaire(),
            'controller_name' => 'DetailsController'          
        ]);
    }
}
class CommentairesController extends DetailsController {}

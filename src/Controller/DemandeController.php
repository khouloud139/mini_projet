<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Demande;
use App\Form\DemandeType;
use Doctrine\ORM\EntityManagerInterface;


class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(Request $request,
    EntityManagerInterface $entityManager,
    Security $security): Response
    {
        $user = $security->getUser();

        // Vérifiez si l'utilisateur est connecté
        if ($user) {
            // Récupérez l'ID de l'utilisateur
            $userId = $user->getId(); 
          }
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande = $form->getData();

            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Associer l'utilisateur à la demande
            $demande->setUser($user);
            $entityManager->persist($demande);
            $entityManager->flush();
            return $this->redirectToRoute('app_userprofile') ;
        }
       

        return $this->render('demande/index.html.twig', [
            'demandeForm' => $form->createView(),
        ]);
    }
}

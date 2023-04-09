<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $this->getUser()->getId();

        // Récupérer la dernière demande de l'utilisateur
       // $demande = $this->getDoctrine()
         //   ->getRepository(Demande::class)
          //  ->findOneBy(['user_id' => $user_id]);

        // Vérifier si la demande existe
       // if (!$demande) {
        //    throw $this->createNotFoundException('La demande n\'existe pas.');
        
        $productRepository = $entityManager->getRepository(Demande::class);
        $demandes = $productRepository->findBy(['user' => $user_id]);

        $productData = [];
        foreach ($demandes as $demande) {
            $productData[] = [
                
        'id' => $demande->getId(),
        'Dis' => $demande->getDistination(),
        'depart' => $demande->getLieuDepart(),
        'date' => $demande->getDateSortie()->format('d/m/Y'),
        'heure' => $demande->getHeureDepart()->format('H:m'),
        'type' => $demande->getType(),
        'nombre' => $demande->getNombrePlaces(),
        'prix' => $demande->getPrix(),
        'statut' =>$demande->getStatut(),

            ];
        }
        

       
        // Faire quelque chose avec les données récupérées
        // ...

        // Renvoyer la réponse
        return $this->render('historique/index.html.twig', [
            'demande' => $productData,
        ]);
    



        return $this->render('historique/index.html.twig', [
            'controller_name' => 'HistoriqueController',
        ]);
    }
}

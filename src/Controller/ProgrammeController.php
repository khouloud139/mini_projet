<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Demande;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

 // Récupérer l'ID de l'utilisateur connecté
 $user_id = $this->getUser()->getId();

 
 
 //$photoRepository = $entityManager->getRepository(Demande::class);
 //$demandes = $photoRepository->findAll();
 $queryBuilder = $entityManager->createQueryBuilder();
 $queryBuilder
     ->select('d')
     ->from(Demande::class, 'd')
     ->where('d.statut = :statut')
     ->setParameter('statut', 'Accepté');

 $demandes = $queryBuilder->getQuery()->getResult();


 
 

 $demandeData = [];
 foreach ($demandes as $demande) {
     $demandeData[] = [
         
        'id' => $demande->getId(),
        'Dis' => $demande->getDistination(),
        'depart' => $demande->getLieuDepart(),
        'date' => $demande->getDateSortie()->format('d/m/Y'),
        'heure' => $demande->getHeureDepart()->format('H:m'),
        'type' => $demande->getType(),
        'nombre' => $demande->getNombrePlaces(),
        'prix' => $demande->getPrix(),
        'statut' =>$demande->getStatut(),
        'titre' =>$demande->getTitre(),
        'photo' =>$demande->getPhoto(),

 

     ];
 }
 


 // Faire quelque chose avec les données récupérées
 // ...

 











        return $this->render('programme/index.html.twig', [
            'demandes' => $demandeData,
        ]);
    }



    #[Route('/programme/{id}', name: 'programme_details')]
    public function show(Request $request,EntityManagerInterface $entityManager ,$id): Response
    {
        $demandeRepository = $entityManager->getRepository(Demande::class);
        $demandes = $demandeRepository->findBy(['id' => $id]);
        

    if (!$demandes) {
        throw $this->createNotFoundException(
            'Aucun produit trouvé pour l\'id '.$id
        );
    }
     $demandeData = [];
      foreach ($demandes as $demande) {
     $demandeData[] = [
         
        'id' => $demande->getId(),
        'Dis' => $demande->getDistination(),
        'depart' => $demande->getLieuDepart(),
        'date' => $demande->getDateSortie()->format('d/m/Y'),
        'heure' => $demande->getHeureDepart()->format('H:m'),
        'type' => $demande->getType(),
        'nombre' => $demande->getNombrePlaces(),
        'prix' => $demande->getPrix(),
        'statut' =>$demande->getStatut(),
        'titre' =>$demande->getTitre(),
        'photo' =>$demande->getPhoto(),
        'discription' =>$demande->getDiscription(),

 

     ];
     
 }

        return $this->render('programme/detail.html.twig', [
            'demande' => $demandeData,
        ]);

    }

}

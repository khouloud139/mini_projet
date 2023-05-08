<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Demande;
use App\Entity\Commentaire;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\CommentType;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

// <<<<<<< HEAD
 // Récupérer l'ID de l'utilisateur connecté
//  $user_id = $this->getUser()->getId();
 
// >>>>>>> b5444ff570f56762582f4197f2c3f2f5c89db649

 
 
 //$photoRepository = $entityManager->getRepository(Demande::class);
 //$demandes = $photoRepository->findAll();
 
 $searchTerm = $request->query->get('search');
    
 $queryBuilder = $entityManager->createQueryBuilder();

 $queryBuilder->select('p')
          ->from(Demande::class, 'p')
          ->where('p.statut = :statut')
          ->setParameter('statut', 'approuvee');
          

if ($searchTerm) {
    
 $queryBuilder->andWhere(
                    $queryBuilder->expr()->orX(
                        $queryBuilder->expr()->like('p.Distination', ':searchTerm'),
                        $queryBuilder->expr()->like('p.lieudepart', ':searchTerm'),
                        $queryBuilder->expr()->like('p.datesortie', ':searchTerm'),
                        $queryBuilder->expr()->like('p.type', ':searchTerm'),
                        $queryBuilder->expr()->like('p.prix', ':searchTerm'),
                    )
                )
              ->setParameter('searchTerm',  $searchTerm );

}
/*
 $queryBuilder
     ->select('d')
     ->from(Demande::class, 'd')
     ->where('d.statut = :statut')
     ->setParameter('statut', 'approuvee');
*/

 $demandes = $queryBuilder->getQuery()->getResult();
 $demandeData = [];
 foreach ($demandes as $demande) {
     $demandeData[] = [
         
        'id' => $demande->getId(),
        'Dis' => $demande->getDistination(),
        'depart' => $demande->getLieuDepart(),
        'date' => $demande->getDateSortie()->format('y-m-d'),
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
            'searchTerm' => $searchTerm,
        ]);
    }



    #[Route('/programme/{id}', name: 'programme_details')]
    public function show(Request $request,EntityManagerInterface $entityManager ,$id,Security $security): Response
    {
        $demandeRepository = $entityManager->getRepository(Demande::class);
        $demandes = $demandeRepository->findBy(['id' => $id]);
        $user = $this->getUser();
        
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
        
            // Associer l'utilisateur à la demande
            $reservation->setDemande($demandes[0]);
            $reservation->setMontant($demandes[0]->getPrix() *$reservation->getNombreplace());
            //dd($reservation);
            $entityManager->persist($reservation);
            $entityManager->flush();
            
            if ($security->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('programme_reservation',[
                    'id' => $reservation->getId(),
                    'idd' => $id,
                    'idu' => $user->getId(),
                ]);
            }
            else{
            return $this->redirectToRoute('app_login') ;}
        }


        

    if (!$reservation) {
        throw $this->createNotFoundException(
            'Aucun reservation trouvé pour l\'id '.$reservation->getId()
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
 $comment = new Commentaire();
 $commentForm = $this->createForm(CommentType::class, $comment);

 $commentForm->handleRequest($request);

 if ($commentForm->isSubmitted() ) {
    

    $comment=$commentForm->getData();
   
     $comment->setDamande($demandes[0]);
    
     $entityManager->persist($comment);
     $entityManager->flush();
     return $this->redirectToRoute('programme_details',[
        'id' => $demandes[0]->getId(),]);
     }

     $qb = $entityManager->createQueryBuilder();
     $qb->select('c')
              ->from(Commentaire::class, 'c')
              ->where('c.etat = :etat')
              ->setParameter('etat', 'approuvee');
$commentaires = $qb->getQuery()->getResult();
        // Initialise une liste vide pour stocker les commentaires spécifiques à un programme
$programmeComments = [];

// Récupère l'identifiant du programme spécifique à partir de la requête HTTP ou de toute autre source
$programmeId = $demandes[0]->getId();


// Parcours tous les commentaires pour trouver ceux qui sont spécifiques au programme
foreach ($commentaires as $comment) {
    if ($comment->getDamande()->getId() == $programmeId) {
        $programmeComments[] = $comment;
    }

}

       

        return $this->render('programme/detail.html.twig', [
            'demande' => $demandeData,
            'form' => $form->createView(),
            'commentForm' => $commentForm->createView(),
            'reservation'=>$reservation,
            'commentaires'=>$programmeComments,
        ]);

    }




    #[Route('/reservation/{id}/{idd}/{idu}', name: 'programme_reservation')]
    public function reserv(Request $request,EntityManagerInterface $entityManager ,$id,$idd,$idu): Response
    {
        
        $demandeRepository = $entityManager->getRepository(Demande::class);
        $demandes = $demandeRepository->findBy(['id' => $idd]);

        $resRepository = $entityManager->getRepository(Reservation::class);
        $reservations = $resRepository->findBy(['id' => $id]);

        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findBy(['id' => $idu]);
        




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
    ];}
     $resData = [];
     foreach ($reservations as $res) {
    $resData[] = [
        
       'id' => $res->getId(),
       'nb' => $res->getNombreplace(),
    ];}
    $userData = [];
    foreach ($user as $us) {
   $userData[] = [
       
      'id' => $us->getId(),
      'nom' => $us->getUsername(),
      'prenon' => $us->getUserlastname(),
      'email' => $us->getEmail(),
    
   ];}
    
 
        return $this->render('programme/reservation.html.twig', [
            'demande' => $demandeData,
            'reservation' => $resData,
            'user' => $userData,
            
            
        ]);

    }
    #[Route('/confirmation', name: 'confirmation_paiement')]
    public function confirmation_paiement(Request $request,EntityManagerInterface $entityManager ):Response
    {
     
    
    return $this->render('programme/confirmation.html.twig');
    }
   

}




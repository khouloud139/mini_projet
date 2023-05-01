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
use App\Entity\Reservation;
use App\Form\ReservationType;

class ProgrammeController extends AbstractController
{
    #[Route('/programme', name: 'app_programme')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {

 

 
 
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

        return $this->render('programme/detail.html.twig', [
            'demande' => $demandeData,
            'form' => $form->createView(),
            'reservation'=>$reservation,
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




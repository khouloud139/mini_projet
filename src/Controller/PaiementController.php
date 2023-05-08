<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use App\Entity\Reservation;
use App\Entity\User;

class PaiementController extends AbstractController{
    private UrlGeneratorInterface $generator;
    public function __construct( UrlGeneratorInterface $generator){
        $this->generator=$generator;
    }
    

    #[Route('/order/create-session-stripe/{id}', name: 'paiement-stripe')]
    public function stripeChekout($id ,EntityManagerInterface $entityManager):RedirectResponse{
        $succesUrl = $this->generateUrl('confirmation_paiement');
       
        //Stripe::setApiKey('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');
        $resRepository = $entityManager->getRepository(Reservation::class);
        $reservation = $resRepository->findBy(['id' => $id]);

        foreach ($reservation as $res) {
            $resData[] = [
                
               'id' => $res->getId(),
               'nb' => $res->getNombreplace(),
               'montant'=>$res->getMontant(),
            ];
    }

        if (!$reservation ) {
            throw $this->createNotFoundException('La réservation est introuvable ');
        }
        
    
            // Créer un objet de paiement Stripe
        Stripe::setApiKey($this->getParameter('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'));
        $paiement = \Stripe\PaymentIntent::create([
            'amount' => $reservation->getMontantTotal() * 100, // Le montant doit être en centimes
            'currency' => 'eur',
            'description' => 'Paiement de réservation pour le camping',
        ]);
            
             
 // Afficher la page de paiement avec le formulaire Stripe Checkout
 return $this->render('paiement/checkout.html.twig', [
    'reservation' => $reservation,
    'paiement' => $paiement,
]);

    }

    public function confirmationPaiement(Request $request)
    {
        // Récupérer l'objet de paiement Stripe
        Stripe::setApiKey($this->getParameter('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'));
        $paiement = \Stripe\PaymentIntent::retrieve($request->get('payment_intent_id'));

        // Vérifier le statut du paiement
        if ($paiement->status === 'succeeded') {
            // Mettre à jour la base de données pour marquer la réservation comme payée
            $reservation = $this->getDoctrine()
                ->getRepository(Reservation::class)
                ->find($request->get('id'));
            $reservation->setPaye(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Afficher la page de confirmation de paiement
            return $this->render('paiement/confirmation.html.twig', [
                'reservation' => $reservation,
            ]);
        }
    } 
}
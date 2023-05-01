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
       
        Stripe::setApiKey('sk_test_51N2HtvIx1c8VsXVtT1vcLKPyY9oPJ7oxLFw0XPBLIjAmayNTD3aKCOPCY5nal0h6r8jNsYwOiR0snduxtOL6zZDr00nCZFl13R');
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
        
    
             $checkout_session =Session::create([
                'payment_method_types' => ['card'],
                'customer_email'=>$this->getUser()->getEmail(),
                'line_items' => [[
                    'name' => 'Réservation de camping',
                    'description' => 'Réservation de camping pour ' . $reservation[0]->getNombreplace() . ' personnes',
                    'amount' => $reservation[0]->getMontant(),
                    'currency' => 'eur',
                    'quantity' => $reservation[0]->getNombreplace(),
                ]],
            'mode' => 'payment',
            'success_url' => $succesUrl,
            
             
]);

    }
}
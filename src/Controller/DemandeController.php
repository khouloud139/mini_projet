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
use Symfony\Component\String\Slugger\SluggerInterface;


class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(Request $request,
    EntityManagerInterface $entityManager,
    Security $security,
    SluggerInterface $slugger): Response
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
            
            $brochureFile = $form->get('photo')->getData();

            
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                
                try {
                    $brochureFile->move(
                        $this->getParameter('user_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                
                $demande->setPhoto($newFilename);
                
            }

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

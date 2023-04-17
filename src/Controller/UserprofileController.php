<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\PhotoType;
use App\Entity\User;
use App\Entity\Photo;

class UserprofileController extends AbstractController
{
    #[
        Route('/userprofile', name: 'app_userprofile'),
        IsGranted('ROLE_USER')
        ]
    public function index(): Response
    {
        return $this->render('userprofile/index.html.twig', [
           
        ]);
    }


    #[
        Route('/mesImages', name: 'app_img'),
        IsGranted('ROLE_USER')
        ]
    public function afficheImage(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger ): Response
    {

        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);
        
        $user = $this->getUser();
            
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();
            

            // Récupérer l'utilisateur connecté
            
            // Associer l'utilisateur à la demande
            $photo->setUser($user);
            
           
            $brochureFile = $form->get('photofile')->getData();

            
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

                
                $photo->setPhotofile($newFilename);
                
            }
            
            $entityManager->persist($photo);
            $entityManager->flush();
            $this->addFlash('success', 'La photo a été ajoutée avec succès.');

            return $this->redirectToRoute('app_userprofile') ;






        }

        //affichage des images
        
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $this->getUser()->getId();

        // Récupérer la dernière demande de l'utilisateur
       // $demande = $this->getDoctrine()
         //   ->getRepository(Demande::class)
          //  ->findOneBy(['user_id' => $user_id]);

        // Vérifier si la demande existe
       // if (!$demande) {
        //    throw $this->createNotFoundException('La demande n\'existe pas.');
        
        $photoRepository = $entityManager->getRepository(Photo::class);
        $photos = $photoRepository->findBy(['user' => $user_id]);
        

        $photoData = [];
        foreach ($photos as $photo) {
            $photoData[] = [
                
        'photo' => $photo->getPhotofile(),
        'type' => $photo->getType(),
        'description' => $photo->getDescription(),
        'titre'=> $photo->getTitre(),
        

            ];
        }
        

       
        // Faire quelque chose avec les données récupérées
        // ...

        
    



       
        

//fin affiche image
        return $this->render('userprofile/images.html.twig', [
            'PhotoForm' => $form->createView(),
            'photo' => $photoData,
        ]);
    }
}

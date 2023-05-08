<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class MessageController extends AbstractController
{//#[Route('/', name: 'app_test_index', methods: ['GET'])]
   #[Route('/message/new', name:'message_new', methods:["POST"])] 
    
   public function new(Request $request,EntityManagerInterface $entityManager): Response
    {     
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $messageContent = $request->request->get('message');

        $message = new Message();
        $message->setName($name);
        $message->setEmail($email);
        $message->setSubject($subject);
        $message->setMessage($messageContent);

        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();

        $this->addFlash('success', 'Your message has been sent. Thank you!');
        // return $this->redirectToRoute('app_main');
         return $this->redirectToRoute('app_main');
        // return $this->redirectToRoute('app_programme');
    } 
        
       /* $msg = new Message();
        $form = $this->createForm(MessageType::class, $msg);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $msg = $form->getData();

            ;

            
           
            $entityManager->persist($msg);
            $entityManager->flush();
            return $this->redirectToRoute('app_userprofile') ;
        }
       

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);

*/

    }

// Notez que ce code suppose que vous avez déjà créé un modèle Twig nommé contact.html.twig qui contient le formulaire HTML. Si ce n'est pas le cas, vous devrez l'ajouter à votre projet.

// Pour résoudre votre problème de double affichage de la page d'accueil, il se peut que vous deviez vérifier si vous redirigez correctement la page après la soumission du formulaire. La méthode redirectToRoute() dans le code ci-dessus redirige l'utilisateur vers la page d'accueil après avoir soumis le formulaire. Assurez-vous que la route homepage existe et qu'elle pointe vers la bonne page. Si vous continuez à avoir des problèmes, n'hésitez pas à partager plus de détails sur votre problème ou à clarifier votre question.







            


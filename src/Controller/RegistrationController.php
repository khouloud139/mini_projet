<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailerService;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
     EntityManagerInterface $entityManager,
     MailerService $mailerService,
     TokenGeneratorInterface $tokenGeneratorInterface  ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //token
            $tokenRegistration=$tokenGeneratorInterface->generateToken();
            //User
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //user token
            $user->setTokenRegistration($tokenRegistration);


            $entityManager->persist($user);
            $entityManager->flush();
            //mailer send
            $mailerService->send(
                $user->getEmail(),
                'Confirmation du compte utilisateur',
                'registration_confirmation.html.twig',
                [
                    'user'=>$user,
                    'token'=>$tokenRegistration,
                    //'lifTimeToken'=>$user->getTokenRegistrationLifeTime()->format('d-m-Y-H-i-s')



    

                ]





            );
            // do anything else you need here, like send an email
            $this->addFlash('success','votre compte a bien ete cree,veuiller virifier votre email pour l\'active');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/verify/{token}/{id}', name: 'account_verify',methods:['GET'])]
    public function verify(string $token,User $user,EntityManagerInterface $em):Response{
if($user->getTokenRegistration() !==$token){
    throw new AccessDeniedException();
}
   if($user->getTokenRegistration() ===null){
    throw new AccessDeniedException();
   }
   $user->setIsVerifed(true);
   $user->setTokenRegistration(true);
   $em->flush();

   $this->addFlash('success','votre compte a bien ete activé,vous pouver maintenant vous connecter');
   return $this->redirectToRoute('app_login');

    }
}

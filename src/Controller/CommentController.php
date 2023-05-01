<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Comment;

// use Doctrine\ORM\Mapping as ORM;

class CommentController extends AbstractController
{    #[Route('/comment/add', name:'comment_add')]
    
   public function addComment(Request $request,EntityManagerInterface $entityManager)
   {
       $comment = new Comment();
       $form = $this->createForm(CommentType::class, $comment);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
        //    $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($comment);
           $entityManager->flush();

        return $this->redirectToRoute('comment_add');
       }

       return $this->render('programme/detail.html.twig', [
           'formcomment' => $form->createView(),
       ]);
   }

     /*#[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    } */
}

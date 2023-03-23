<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserprofileController extends AbstractController
{
    #[Route('/userprofile', name: 'app_userprofile')]
    public function index(): Response
    {
        return $this->render('userprofile/index.html.twig', [
            'controller_name' => 'UserprofileController',
        ]);
    }
}

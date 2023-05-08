<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Demande;
<<<<<<< HEAD
use App\Entity\Commentaire;
=======
use App\Entity\Message;
use App\Entity\Reservation;
>>>>>>> 6f933102c4b3d97c58afd6dc52e3ab0488395814
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    { return $this->render('admin/dashboard.html.twig',[
        
    ]);
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Campa Holic')
            ->renderContentmaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
         yield MenuItem::linkToCrud('Demandes', 'fa fa-bell', Demande::class);
<<<<<<< HEAD
         yield MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Commentaire::class);
=======
         yield MenuItem::linkToCrud('Messages', 'fa fa-message', Message::class);
         yield MenuItem::linkToCrud('Reservation', 'fa fa-message', Reservation::class);
>>>>>>> 6f933102c4b3d97c58afd6dc52e3ab0488395814
    }
}
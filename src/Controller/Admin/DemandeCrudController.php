<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
//use EasyCorp\Bundle\EasyAdminBundle\Field\CrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DemandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Demande::class;
    }
    public function configureFields(string $pageName): iterable
    {    return [
        yield IdField::new('id'),
       //  IdField::new('user_id'),
       yield TextField::new('lieudepart'),
        //DateField::new('datesortie'),
        
        yield ChoiceField::new('statut')->setChoices([
            'En attente' => 'en_attente',
            'Approuvée' => 'approuvee',
            'Refusée' => 'refusee',
        ])
    ];
}
/*
public function configureActions(Actions $actions): Actions
    {
        $approveAction = Action::new('approve', 'Approve', 'fa fa-check')
    ->linkToCrudAction('updateStatus')
    ->setCssClass('btn btn-success')
    ->setAction('updateStatus');

     $rejectAction = Action::new('reject', 'Reject', 'fa fa-times')
    ->linkToCrudAction('updateStatus')
    ->setCssClass('btn btn-danger')
    ->setAction('updateStatus');

       /* $approveAction = Action::new('approve', 'Approve', 'fa fa-check')
            ->linkToCrudAction('updateStatus')
            ->setCssClass('btn btn-success')
            ->setController($this);

        $rejectAction = Action::new('reject', 'Reject', 'fa fa-times')
            ->linkToCrudAction('updateStatus')
            ->setCssClass('btn btn-danger')
            ->setController($this); 

        return $actions
            ->add(Crud::PAGE_INDEX, $approveAction)
            ->add(Crud::PAGE_INDEX, $rejectAction);
    }*/

   /* public function updateStatus(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $demande = $entityManager->getRepository(Demande::class)
            ->find($request->request->get('id'));

        if (!$demande) {
            throw $this->createNotFoundException('No demande found for id '.$request->request->get('id'));
        } */

       public function updateStatus(Request $request,EntityManagerInterface $entityManager): Response
    {
       // $entityManager = $this->getDoctrine()->getManager();

        $demande = $entityManager->getRepository(Demande::class)
            ->find($request->request->get('id'));

        if (!$demande) {
            throw $this->createNotFoundException('No demande found for id '.$request->request->get('id'));
        }

        $demande->setStatut($request->request->get('statut'));

        $entityManager->flush();

        return $this->redirectToRoute('admin_app_demande_list');
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    } */
    
}

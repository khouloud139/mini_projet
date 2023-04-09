<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') 
             ->hideOnForm(),
            TextField::new('username'),
            TextField::new('userlastname'),
            TextField::new('email'),
            TextField::new('adresse'),
            TextField::new('password')
            ->hideOnIndex(),
            TextField::new('numtel'),
           // ImageField::new('user_image')
            //->hideOnIndex(),
        ];
    }
    
}

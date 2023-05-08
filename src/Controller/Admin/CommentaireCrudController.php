<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //yield IdField::new('id'),
           
           yield TextField::new('name'),
            
            yield TextField::new('mail'),
            
            yield TextField::new('comment'),
            
            
            yield ChoiceField::new('etat')->setChoices([
                
                'Approuvee' => 'approuvee',
                'Refusee' => 'refusee',
            ])
        ];
    }
    
}

<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Votre commentaire'
    
                ],
            
                   
                   ])
            ->add('name',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre nom'
    
                ],
            
                   
                   ])
            ->add('mail',EmailType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre email'
    
                ],
            
                   
                   ])
            ->add('phone',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre numero de tel'
    
                ],
            
                   
                   ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}

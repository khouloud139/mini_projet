<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Name',TextTYPE::class,[
            'attr'=>[
                'class'=>'form-control',]
                ])
        ->add('Email',EmailTYPE::class,[
            'attr'=>[
                'class'=>'form-control',]
                ])
        ->add('Phone',TextTYPE::class,[
            'attr'=>[
                'class'=>'form-control',]
                ])
        ->add('Comment',TextAreaTYPE::class,[
            'attr'=>[
                'class'=>'form-control',]
                ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

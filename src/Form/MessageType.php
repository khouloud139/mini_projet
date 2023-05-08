<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            ->add('email',EmailTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            ->add('subject',TextTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            ->add('message',TextAreaTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Form\DataTransformer\PasswordTransformer;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Nom',
            'required' => true,
        ])
        ->add('userlastname', TextType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Prénom',
            'required' => true,
        ])
        ->add('adresse', TextType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Adresse',
            'required' => true,
        ])
        ->add('email', TextType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Email',
            'required' => true,
        ])
       /* ->add('userImage', FileType::class, [
            'required' => false,
        // ]) */
        ->add('password', PasswordType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Mot de passe ',
            'required' => false,
        ])
        ->add('numtel', TextType::class, [
            'attr'=>[
                'class'=>'form-control',],
            'label' => 'Numéro du téléphone',
            'required' => true,
            ]);
        // Ajoutez les autres champs pour les coordonnées de l'utilisateur
        
    //     $form->get('password')->addModelTransformer(new PasswordTransformer($this->passwordEncoder));
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => User::class
       // 'data_class' => ,
        // Configurez ici l'entité de l'utilisateur et d'autres options
    ]);
}
            /* ->add('username')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('tokenRegistration')
            ->add('isVerifed')
            ->add('userlastname')
            ->add('adresse')
            ->add('numtel') 
            ->add('userImage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }*/
}

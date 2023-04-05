<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre nom'
    
                ],
            
                   'label'=>'Nom'
                   ])
            ->add('userlastname',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre prenon'
    
                ],
                'label'=>'Prénom'])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre mail'
    
                ]
            ])
            
            ->add('adresse',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre adresse'
    
                ]
            ])
            ->add('numtel',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Entrer votre numero'
    
                ],
                'label'=>'Numero de telephone'])
            
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>'Accepter les termes',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Votre image de profil (Image file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/gif',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                
                'label'=>'Mot de passe',
                
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class'=>'form-control',
                'placeholder'=>'Entrer votre mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit etre au minimum {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

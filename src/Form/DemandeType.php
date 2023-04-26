<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Distination',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'la distination'
    
                ],
            
                   'label'=>'Distination'
            ])
            ->add('lieudepart',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>' lieu de départ'
    
                ],
            
                   'label'=>'Lieu de départ'
            ])
            ->add('datesortie',DateType::class,[
                'attr'=>[
                    'class'=>'form-control',
                   
    
                ],
            
                   'label'=>'Date de sortie'
            ])
            ->add('heuredepart',TimeType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'heure de départ'
    
                ],
            
                   'label'=>'Heure de départ'
            ])
            ->add('type', ChoiceType::class, [
                'attr'=>[
                    'class'=>'form-control',],
                'choices' => [
                    'Camping' => 'Camping',
                    'Rondonnée' => 'Rondonnée',
                ]])
            ->add('nombreplaces',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'le nombre des places'
    
                ],
            
                   'label'=>'Nombre de places'

            ])
            ->add('prix',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'le prix dune place'
    
                ],
            
                   'label'=>'Prix'

            ])
            ->add('photo', FileType::class, [
            
                'attr'=>[
                    'class'=>'form-control',],
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
            ->add('titre',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>' titre'
    
                ],
            
                   'label'=>'titre'
            ])
           
            ->add('discription',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>' discription'
    
                ],
            
                   'label'=>'discription'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}

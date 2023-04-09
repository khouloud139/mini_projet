<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


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
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}

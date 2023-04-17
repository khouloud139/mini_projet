<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photofile', FileType::class, [
            
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
            ->add('type',ChoiceType::class, [
                'choices' => [
                    'Camping' => 'Camping',
                    'Rondonnée' => 'Rondonnée',
                ],
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            ->add('description',TextTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            ->add('titre',TextTYPE::class,[
                'attr'=>[
                    'class'=>'form-control',]
                    ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}

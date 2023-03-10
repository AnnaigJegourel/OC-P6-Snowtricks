<?php

namespace App\Form;

use App\Entity\Trick;
use App\Form\ImageType;
use App\Form\VideoType;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('category')
                        ->orderBy('category.id', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('images', CollectionType::class, [
                'entry_type'    => ImageType::class,
                'prototype'		=> true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'label'         => false,
                'by_reference'  => false,
                'disabled'      => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type'    => VideoType::class,
                'prototype'		=> true,
                'allow_add'     => true,
                'allow_delete'  => true,
                'required'      => false,
                'label'         => false,
                'by_reference'  => false,
                'disabled'      => false,
            ])
            ->add('mainImageFile', FileType::class, [
                'label' => 'Main Image (jpg or jpeg file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the file
                // every time you edit the Trick details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpg or jpeg document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}

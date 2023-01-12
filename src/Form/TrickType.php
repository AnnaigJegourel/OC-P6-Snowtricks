<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            // ->add('imageFile', FileType::class, [
            //     'required'=>false
            // ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                //'prototype'			=> true,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label'=>false,
                'by_reference' => false,
                'disabled' => false,
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

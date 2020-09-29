<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('classification', ChoiceType::class, [
                'choices' => [
                    'Je demande' => 'Je demande',
                    'Je propose' => 'Je propose',
                ],
                'expanded' => true,
            ])
            ->add('address')
            ->add('city')
            ->add('zipcode')
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ->add('heading', ChoiceType::class, [
                'choices' => [
                    'Projet' => 'Projet',
                    'Événement' => 'Evénement',
                ]
            ])
            ->add('photoFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'allow_delete' => false
            ])

            ->add('video')
            ->add('pdf')
            ->add('needs')
            ->add('content')
            ->add('photoBFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'allow_delete' => false
            ])

            ->add('photoCFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'allow_delete' => false
            ])

            ->add('target')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false
            ])
            ->add('author')
            ->add('telephone')
            ->add('email')
            ->add('website');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

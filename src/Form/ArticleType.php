<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

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
            ->add('photo')
            ->add('video')
            ->add('pdf')
            ->add('needs')
            ->add('content')
            ->add('photoB')
            ->add('photoC')
            ->add('target')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false])
            ->add('author')
            ->add('telephone')
            ->add('email')
            ->add('website')
            ->add('updatedAt', HiddenType::class)
            ->add('isPublished', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

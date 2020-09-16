<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('heading', ChoiceType::class, [
                'choices' => [
                    'Projet' => 'Projet',
                    'Evénement' => 'Evénement',
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
            ->add('category')
            ->add('author');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

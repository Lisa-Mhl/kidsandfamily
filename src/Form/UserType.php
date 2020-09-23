<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('avatarFile', VichFileType::class, [
                'allow_delete' => true,
                'download_link' => false,
                'label' => false,
                'attr' => ['class' => 'form-control-file']
            ])

            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('channelnum')
            ->add('complement')
            ->add('namevoie')
            ->add('cp')
            ->add('city')
            ->add('country')
            ->add('phone')
            ->add('mobile')
            ->add('gender')
            ->add('profession')
            ->add('marital')
            ->add('hobbies', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    'Animaux' => 'Animaux',
                    'Beauté' => 'Beauté',
                    'Cuisine' => 'Cuisine',
                    'Décoration' => 'Décoration',
                    'Environnement' => 'Environnement',
                    'Films,séries' => 'Films, séries',
                    'Jeux' => 'Jeux',
                    'Mode' => 'Mode',
                    'Musique' => 'Musique',
                    'Nouvelles technologie' => 'Nouvelles technologie',
                    'Santé, bien-être' => 'Santé, bien-être',
                    'Soirées entre ami(e)s' => 'Soirées entre ami(e)s',
                    'Sorties culturelles' => 'Sorties culturelles',
                    'Sport' => 'Sport',
                    'Voyage' => 'Voyage',
                    'Autres' => 'Autres',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

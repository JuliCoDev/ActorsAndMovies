<?php

namespace App\Form;

use App\Entity\Actors;
use App\Entity\Movies;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MoviesEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', TextType::class, ['label' => 'Name'])
            ->add('sinopsis', TextType::class, ['label' => 'Synopsis'])
            ->add('anoEstreno', TextType::class, ['label' => 'Release year'])
            ->add('actors',EntityType::class,[
                'class'        => Actors::class,
                'choice_label' => 'nombre',
                'expanded'     => true,
                'multiple'     => true,
            ])
            ->add('Create', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movies::class,
        ]);
    }
}
